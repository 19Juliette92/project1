<?php
require_once 'database.php';

class Datos extends Database
{
	public function createVehiculoModel($datosModel, $tabla)
{
    $stmt = $this->getConnection()->prepare("INSERT INTO $tabla (placa, id_conductor, marca, modelo, color, tipo_vehiculo, fecha_registro) VALUES (:placa, :id_conductor, :marca, :modelo, :color, :tipo_vehiculo, NOW())");
    $stmt->execute([
		':placa' => $datosModel['placa'],
        ':id_conductor' => $datosModel['id_conductor'],
        ':marca' => $datosModel['marca'],
        ':modelo' => $datosModel['modelo'],
        ':color' => $datosModel['color'],
        ':tipo_vehiculo' => $datosModel['tipo_vehiculo']
    ]);

    return $stmt->rowCount() > 0;
}

	public function readVehiculoModel($tabla, $placa = null)
	{
		$sql = "SELECT vehiculos.placa, vehiculos.id_conductor, personas.nombres, personas.apellidos, vehiculos.marca, vehiculos.modelo, vehiculos.color, vehiculos.tipo_vehiculo, tipos.nombre_tipo, vehiculos.fecha_registro  
            FROM $tabla 
            LEFT JOIN personas ON vehiculos.id_conductor = personas.id_persona
			LEFT JOIN tipos ON vehiculos.tipo_vehiculo = tipos.id_tipo";
			

		if ($placa !== null) {
			$sql .= " WHERE vehiculos.placa = :placa";
		}

		$stmt = $this->getConnection()->prepare($sql);

		if ($placa !== null) {
			$stmt->bindParam(":placa", $placa, PDO::PARAM_STR);
		}

		$stmt->execute();

		$vehiculos = [];

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$row = array_map('utf8_encode', $row);
			$vehiculos[] = $row;
		}

		return $vehiculos;
	}

	public function updateVehiculoModel($datosModel, $tabla, $placa)
	{

		$stmt = $this->getConnection()->prepare("UPDATE $tabla SET id_conductor = :id_conductor, marca = :marca, modelo = :modelo, color = :color, tipo_vehiculo = :tipo_vehiculo WHERE placa = :placa");
		$stmt->execute([
			':id_conductor' => $datosModel['id_conductor'],
			':marca' => $datosModel['marca'],
			':modelo' => $datosModel['modelo'],
			':color' => $datosModel['color'],
			':tipo_vehiculo' => $datosModel['tipo_vehiculo'],
			':placa' => $placa
		]);

		return $stmt->rowCount() > 0;
	}

	public function deleteVehiculoModel($tabla, $placa)
	{
		$stmt = $this->getConnection()->prepare("DELETE FROM $tabla WHERE placa = :placa");
		$stmt->bindParam(':placa', $placa, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->rowCount() > 0;
	}
}

?>
