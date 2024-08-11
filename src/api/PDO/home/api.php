<?php

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
require_once 'controllerjson.php';

$response = array();
$controller = new ControllerJson();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$data = $controller->getHomeData();
	$response['error'] = false;
	$response['message'] = 'Solicitud completada correctamente';
	$response['contenido'] = $data;
} else {
	$response['error'] = true;
	$response['message'] = 'Método de solicitud no válido';
}

echo json_encode($response);
?>
