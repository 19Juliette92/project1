<?php
require_once 'modelojson.php';

class ControllerJson
{
	private $datos;

	public function __construct()
	{
		$this->datos = new Datos();
	}

	public function createEstacionamientoController($no_estacionamiento, $id_titular, $placa, $id_inmueble, $id_usuario)
	{
		$datosController = array(
			"no_estacionamiento" => $no_estacionamiento,
			"id_titular" => $id_titular,
			"placa" => $placa,
			"id_inmueble" => $id_inmueble,
			"id_usuario" => $id_usuario

		);
		return $this->datos->createEstacionamientoModel($datosController, "estacionamientos");
	}

	public function readEstacionamientosController($id_estacionamiento = null)
	{
		$estacionamientos = $this->datos->readEstacionamientoModel("estacionamientos");

		if ($id_estacionamiento !== null) {
			$estacionamientos = array_filter($estacionamientos, function ($estacionamiento) use ($id_estacionamiento) {
				return $estacionamiento['id_estacionamiento'] == $id_estacionamiento;
			});
		}

		return $estacionamientos;
	}

	public function updateEstacionamientoController($id_estacionamiento, $no_estacionamiento, $id_titular, $placa, $id_inmueble, $id_usuario)
	{
		$datosController = array(
			"no_estacionamiento" => $no_estacionamiento,
			"id_titular" => $id_titular,
			"placa" => $placa,
			"id_inmueble" => $id_inmueble,
			"id_usuario" => $id_usuario
		);

		return $this->datos->updateEstacionamientoModel($datosController, "estacionamientos", $id_estacionamiento);
	}

	public function deleteEstacionamientoController($id_estacionamiento)
	{
		return $this->datos->deleteEstacionamientoModel("estacionamientos", $id_estacionamiento);
	}
}
