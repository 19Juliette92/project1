<?php
require_once 'database.php';

class Datos extends Database
{
	public function readHomeDataModel()
	{
		$stmt = $this->getConnection()->query("SELECT 
			personas.id_persona,
			personas.nombres, 
			personas.apellidos, 
			personas.num_doc,
			inmuebles.bloque, 
			inmuebles.apto, 
			vehiculos.placa, 
			estacionamientos.no_estacionamiento
			FROM personas 
			LEFT JOIN inmuebles ON personas.id_persona = inmuebles.id_titular
			LEFT JOIN vehiculos ON personas.id_persona = vehiculos.id_conductor
			LEFT JOIN estacionamientos ON personas.id_persona = estacionamientos.id_titular");

		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}
}
?>
