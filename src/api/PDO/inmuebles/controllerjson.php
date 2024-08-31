<?php
require_once 'modelojson.php';

class ControllerJson
{
	private $datos;

	public function __construct()
	{
		$this->datos = new Datos();
	}

	public function createInmuebleController($bloque, $apto, $id_titular)
	{
		$datosController = array(
			"bloque" => $bloque,
			"apto" => $apto,
			"id_titular" => $id_titular			

		);
		return $this->datos->createInmuebleModel($datosController, "inmuebles");
	}

	public function readInmueblesController($id_inmueble = null)
	{
		$inmuebles = $this->datos->readInmuebleModel("inmuebles");

		if ($id_inmueble !== null) {
			$inmuebles = array_filter($inmuebles, function ($inmueble) use ($id_inmueble) {
				return $inmueble['id_inmueble'] == $id_inmueble;
			});
		}

		return $inmuebles;
	}

	public function updateInmuebleController($id_inmueble, $bloque, $apto, $id_titular)
	{
		$datosController = array(
			"bloque" => $bloque,
			"apto" => $apto,
			"id_titular" => $id_titular
		);

		return $this->datos->updateInmuebleModel($datosController, "inmuebles", $id_inmueble);
	}

	public function deleteInmuebleController($id_inmueble)
	{
		return $this->datos->deleteInmuebleModel("inmuebles", $id_inmueble);
	}
}
