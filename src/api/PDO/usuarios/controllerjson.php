<?php
require_once 'modelojson.php';

class ControllerJson
{
	private $datos;

	public function __construct()
	{
		$this->datos = new Datos();
	}

	public function createUsuarioController($nombre_usuario, $contrasena, $email, $estado)
	{
		$datosController = array(
			"nombre_usuario" => $nombre_usuario,
			"contrasena" => $contrasena,
			"email" => $email,
			"estado" => $estado

		);
		return $this->datos->createUsuarioModel($datosController, "usuarios");
	}

	public function readUsuariosController($id_usuario = null)
	{
		$usuarios = $this->datos->readUsuarioModel("usuarios");

		if ($id_usuario !== null) {
			$usuarios = array_filter($usuarios, function ($usuario) use ($id_usuario) {
				return $usuario['id_usuario'] == $id_usuario;
			});
		}

		return $usuarios;
	}

	public function updateUsuarioController($id_usuario, $nombre_usuario, $contrasena, $email, $estado)
	{
		$datosController = array(
			"nombre_usuario" => $nombre_usuario,
			"contrasena" => $contrasena,
			"email" => $email,
			"estado" => $estado
		);

		return $this->datos->updateUsuarioModel($datosController, "usuarios", $id_usuario);
	}

	public function deleteUsuarioController($id_usuario)
	{
		return $this->datos->deleteUsuarioModel("usuarios", $id_usuario);
	}
}
