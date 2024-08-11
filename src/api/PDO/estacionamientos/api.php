<?php

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
require_once 'controllerjson.php';

$apicall = isset($_GET['apicall']) ? $_GET['apicall'] : '';
$id_estacionamiento = isset($_GET['id_estacionamiento']) ? $_GET['id_estacionamiento'] : '';
$response = array();

$db = new ControllerJson();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $apicall !== 'readestacionamiento') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if ($data === null) {
        $response = array(
            'error' => true,
            'message' => 'Error en el contenido JSON',
        );
    } else {
        switch ($apicall) {
            case 'createestacionamiento':
                $result = $db->createEstacionamientoController(
                    $data['no_estacionamiento'],
                    $data['id_titular'],
                    $data['placa'],
                    $data['id_inmueble'],
                    $data['id_usuario']
                );

                if ($result) {
                    $response['error'] = false;
                    $response['message'] = 'Estacionamiento agregado correctamente';
                    $response['contenido'] = $db->readEstacionamientosController();
                } else {
                    $response['error'] = true;
                    $response['message'] = 'Ocurrió un error, intenta nuevamente';
                }
                break;

            default:
                $response['error'] = true;
                $response['message'] = 'Llamado Inválido del API';
                break;
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT' && $apicall === 'updateestacionamiento') {
    if (!empty($id_estacionamiento)) {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if ($data !== null) {
            $result = $db->updateEstacionamientoController(
                $id_estacionamiento,
                $data['no_estacionamiento'],
                $data['id_titular'],
                $data['placa'],
                $data['id_inmueble'],
                $data['id_usuario']
            );

            if ($result) {
                $response['error'] = false;
                $response['message'] = 'Estacionamiento actualizado correctamente';
                $response['contenido'] = $db->readEstacionamientosController();
            } else {
                $response['error'] = true;
                $response['message'] = 'Ocurrió un error, intenta nuevamente';
            }
        } else {
            $response['error'] = true;
            $response['message'] = 'Error en el contenido JSON';
        }
    } else {
        $response['error'] = true;
        $response['message'] = 'ID de estacionamiento no proporcionado';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $apicall === 'deleteestacionamiento') {
    if (!empty($id_estacionamiento)) {
        $result = $db->deleteEstacionamientoController($id_estacionamiento);

        if ($result) {
            $response['error'] = false;
            $response['message'] = 'Estacionamiento eliminado correctamente';
            $response['contenido'] = $db->readEstacionamientosController();
        } else {
            $response['error'] = true;
            $response['message'] = 'Ocurrió un error, intenta nuevamente';
        }
    } else {
        $response['error'] = true;
        $response['message'] = 'ID de estacionamiento no proporcionado';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $apicall === 'readestacionamiento') {
    if (empty($id_estacionamiento)) {
        $response['error'] = false;
        $response['message'] = 'Solicitud completada correctamente';
        $response['contenido'] = $db->readEstacionamientosController();
    } else {
        $response['error'] = false;
        $response['message'] = 'Solicitud completada correctamente';
        $response['contenido'] = $db->readEstacionamientosController($id_estacionamiento);
    }
} else {
    $response['error'] = true;
    $response['message'] = 'Método de solicitud no válido';
}

echo json_encode($response);


?>

