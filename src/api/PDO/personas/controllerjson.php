<?php
require_once 'modelojson.php';

class ControllerJson
{
	private $datos;

	public function __construct()
	{
		$this->datos = new Datos();
	}

	public function createPersonaController($tipo_persona, $tip_doc, $num_doc, $nombres, $apellidos, $genero, $email, $telefono)
	{
		$datosController = array(
			"tipo_persona" => $tipo_persona,
			"tip_doc" => $tip_doc,
			"num_doc" => $num_doc,
			"nombres" => $nombres,
			"apellidos" => $apellidos,
			"genero" => $genero,
			"email" => $email,
			"telefono" => $telefono

		);
		return $this->datos->createPersonaModel($datosController, "personas");
	}

	public function readPersonasController($id_persona = null)
	{
		$personas = $this->datos->readPersonaModel("personas");

		if ($id_persona !== null) {
			$personas = array_filter($personas, function ($persona) use ($id_persona) {
				return $persona['id_persona'] == $id_persona;
			});
		}

		return $personas;
	}

	public function updatePersonaController($id_persona, $tipo_persona, $tip_doc, $num_doc, $nombres, $apellidos, $genero, $email, $telefono)
	{
		$datosController = array(
			"tipo_persona" => $tipo_persona,
			"tip_doc" => $tip_doc,
			"num_doc" => $num_doc,
			"nombres" => $nombres,
			"apellidos" => $apellidos,
			"genero" => $genero,
			"email" => $email,
			"telefono" => $telefono
		);

		return $this->datos->updatePersonaModel($datosController, "personas", $id_persona);
	}

	public function deletePersonaController($id_persona)
	{
		return $this->datos->deletePersonaModel("personas", $id_persona);
	}
}
