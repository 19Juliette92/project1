<?php
require_once 'database.php';

class Datos extends Database
{
	public function createUsuarioModel($datosModel, $tabla)
	{
		$stmt = $this->getConnection()->prepare("INSERT INTO $tabla (nombre_usuario, contrasena, email, fecha_creacion, estado) VALUES (:nombre_usuario, :contrasena, :email, NOW(), :estado)");
		$stmt->execute([
			':nombre_usuario' => $datosModel['nombre_usuario'],
			':contrasena' => $datosModel['contrasena'],
			':email' => $datosModel['email'],
			':estado' => $datosModel['estado'],
		]);

		return $stmt->rowCount() > 0;
	}

	public function readUsuarioModel($tabla, $id_usuario = null)
	{
		$sql = $id_usuario !== null ? "SELECT id_usuario, nombre_usuario, contrasena, email, fecha_creacion, estado FROM $tabla WHERE id_usuario= :id_usuario" : "SELECT id_usuario, nombre_usuario, contrasena, email, fecha_creacion, estado FROM $tabla";

		$stmt = $this->getConnection()->prepare($sql);

		if ($id_usuario !== null) {
			$stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
		}

		$stmt->execute();

		$usuarios = [];

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$row = array_map('utf8_encode', $row);
			$usuarios[] = $row;
		}

		return $usuarios;
	}

	public function updateUsuarioModel($datosModel, $tabla, $id_usuario)
	{

		$stmt = $this->getConnection()->prepare("UPDATE $tabla SET nombre_usuario = :nombre_usuario, contrasena = :contrasena, email = :email, estado = :estado WHERE id_usuario = :id_usuario");
		$stmt->execute([
			':nombre_usuario' => $datosModel['nombre_usuario'],
			':contrasena' => $datosModel['contrasena'],
			':email' => $datosModel['email'],
			':estado' => $datosModel['estado'],
			':id_usuario' => $id_usuario
		]);

		return $stmt->rowCount() > 0;
	}

	public function deleteUsuarioModel($tabla, $id_usuario)
	{
		$stmt = $this->getConnection()->prepare("DELETE FROM $tabla WHERE id_usuario = :id_usuario");
		$stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->rowCount() > 0;
	}
}

?>
