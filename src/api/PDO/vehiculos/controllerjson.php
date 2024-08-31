<?php
require_once 'modelojson.php';

class ControllerJson
{
	private $datos;

	public function __construct()
	{
		$this->datos = new Datos();
	}

	public function createVehiculoController($placa, $id_conductor, $marca, $modelo, $color, $tipo_vehiculo)
	{
		$datosController = array(
			"placa" => $placa,
			"id_conductor" => $id_conductor,
			"marca" => $marca,
			"modelo" => $modelo,
			"color" => $color,
			"tipo_vehiculo" => $tipo_vehiculo
		);
		return $this->datos->createVehiculoModel($datosController, "vehiculos");
	}

	public function readVehiculosController($placa = null)
	{
		$vehiculos = $this->datos->readVehiculoModel("vehiculos");

		if ($placa !== null) {
			$vehiculos = array_filter($vehiculos, function ($vehiculo) use ($placa) {
				return $vehiculo['placa'] == $placa;
			});
		}

		return $vehiculos;
	}

	public function updateVehiculoController($placa, $id_conductor, $marca, $modelo, $color, $tipo_vehiculo)
	{
		$datosController = array(
			"id_conductor" => $id_conductor,
			"marca" => $marca,
			"modelo" => $modelo,
			"color" => $color,
			"tipo_vehiculo" => $tipo_vehiculo
		);

		return $this->datos->updateVehiculoModel($datosController, "vehiculos", $placa);
	}

	public function deleteVehiculoController($placa)
	{
		return $this->datos->deleteVehiculoModel("vehiculos", $placa);
	}
}
