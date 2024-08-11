<?php
require_once 'modelojson.php';

class ControllerJson
{
	private $datos;

	public function __construct()
	{
		$this->datos = new Datos();
	}

	public function getHomeData()
	{
		return $this->datos->readHomeDataModel();
	}
}
?>
