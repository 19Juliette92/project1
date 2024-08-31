<?php
require_once 'database.php';

class Datos extends Database
{
	public function createInmuebleModel($datosModel, $tabla)
	{
		$stmt = $this->getConnection()->prepare("INSERT INTO $tabla (bloque, apto, id_titular) VALUES (:bloque, :apto, :id_titular)");
		$stmt->execute([
			':bloque' => $datosModel['bloque'],
			':apto' => $datosModel['apto'],
			':id_titular' => $datosModel['id_titular']
			
		]);

		return $stmt->rowCount() > 0;
	}

	public function readInmuebleModel($tabla, $id_inmueble = null)
	{
		$sql = "SELECT inmuebles.id_inmueble, inmuebles.bloque, inmuebles.apto, inmuebles.id_titular, personas.nombres, personas.apellidos 
            FROM $tabla 
            LEFT JOIN personas ON inmuebles.id_titular = personas.id_persona";

		if ($id_inmueble !== null) {
			$sql .= " WHERE inmuebles.id_inmueble = :id_inmueble";
		}

		$stmt = $this->getConnection()->prepare($sql);

		if ($id_inmueble !== null) {
			$stmt->bindParam(":id_inmueble", $id_inmueble, PDO::PARAM_INT);
		}

		$stmt->execute();

		$inmuebles = [];

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$row = array_map('utf8_encode', $row);
			$inmuebles[] = $row;
		}

		return $inmuebles;
	}

	public function updateInmuebleModel($datosModel, $tabla, $id_inmueble)
	{

		$stmt = $this->getConnection()->prepare("UPDATE $tabla SET bloque = :bloque, apto = :apto, id_titular = :id_titular WHERE id_inmueble = :id_inmueble");
		$stmt->execute([
			':bloque' => $datosModel['bloque'],
			':apto' => $datosModel['apto'],
			':id_titular' => $datosModel['id_titular'],
			':id_inmueble' => $id_inmueble
		]);

		return $stmt->rowCount() > 0;
	}

	public function deleteInmuebleModel($tabla, $id_inmueble)
	{
		$stmt = $this->getConnection()->prepare("DELETE FROM $tabla WHERE id_inmueble = :id_inmueble");
		$stmt->bindParam(':id_inmueble', $id_inmueble, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->rowCount() > 0;
	}
}

?>
