<?php
require_once 'database.php';

class Datos extends Database
{
	public function createEstacionamientoModel($datosModel, $tabla)
	{
		$stmt = $this->getConnection()->prepare("INSERT INTO $tabla (no_estacionamiento, id_titular, placa, id_inmueble, id_usuario) VALUES (:no_estacionamiento, :id_titular, :placa, :id_inmueble, :id_usuario)");
		$stmt->execute([
			':no_estacionamiento' => $datosModel['no_estacionamiento'],
			':id_titular' => $datosModel['id_titular'],
			':placa' => $datosModel['placa'],
			':id_inmueble' => $datosModel['id_inmueble'],
			':id_usuario' => $datosModel['id_usuario']
		]);

		return $stmt->rowCount() > 0;
	}

	public function readEstacionamientoModel($tabla, $id_estacionamiento = null)
	{
		$sql = "SELECT estacionamientos.id_estacionamiento, estacionamientos.no_estacionamiento, estacionamientos.id_titular, personas.nombres, personas.apellidos, estacionamientos.placa, vehiculos.placa, estacionamientos.id_inmueble, inmuebles.bloque, inmuebles.apto, estacionamientos.id_usuario, usuarios.nombre_usuario  
            FROM $tabla 
            LEFT JOIN personas ON estacionamientos.id_titular = personas.id_persona
			LEFT JOIN vehiculos ON estacionamientos.placa = vehiculos.placa
			LEFT JOIN inmuebles ON estacionamientos.id_inmueble = inmuebles.id_inmueble
			LEFT JOIN usuarios ON estacionamientos.id_usuario = usuarios.id_usuario";

		if ($id_estacionamiento !== null) {
			$sql .= " WHERE estacionamientos.id_estacionamiento = :id_estacionamiento";
		}

		$stmt = $this->getConnection()->prepare($sql);

		if ($id_estacionamiento !== null) {
			$stmt->bindParam(":id_estacionamiento", $id_estacionamiento, PDO::PARAM_INT);
		}

		$stmt->execute();

		$estacionamientos = [];

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			// $row = array_map('utf8_encode', $row);
			$estacionamientos[] = $row;
		}

		return $estacionamientos;
	}

	public function updateEstacionamientoModel($datosModel, $tabla, $id_estacionamiento)
	{

		$stmt = $this->getConnection()->prepare("UPDATE $tabla SET no_estacionamiento = :no_estacionamiento, id_titular = :id_titular, placa = :placa, id_inmueble = :id_inmueble, id_usuario = :id_usuario WHERE id_estacionamiento = :id_estacionamiento");
		$stmt->execute([
			':no_estacionamiento' => $datosModel['no_estacionamiento'],
			':id_titular' => $datosModel['id_titular'],
			':placa' => $datosModel['placa'],
			':id_inmueble' => $datosModel['id_inmueble'],
			':id_usuario' => $datosModel['id_usuario'],
			':id_estacionamiento' => $id_estacionamiento
		]);

		return $stmt->rowCount() > 0;
	}

	public function deleteEstacionamientoModel($tabla, $id_estacionamiento)
	{
		$stmt = $this->getConnection()->prepare("DELETE FROM $tabla WHERE id_estacionamiento = :id_estacionamiento");
		$stmt->bindParam(':id_estacionamiento', $id_estacionamiento, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->rowCount() > 0;
	}
}

?>
