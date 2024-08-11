<?php

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
require_once 'controllerjson.php';

$apicall = isset($_GET['apicall']) ? $_GET['apicall'] : '';
$placa = isset($_GET['placa']) ? $_GET['placa'] : '';
$response = array();

$db = new ControllerJson();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if ($data === null) {
        $response = array(
            'error' => true,
            'message' => 'Error en el contenido JSON',
        );
    } else {
        switch ($apicall) {
            case 'createvehiculo':

                if (empty($data['placa'])) {
                    $response['error'] = true;
                    $response['message'] = 'El campo Placa no puede estar vacío';
                    
                } else {
                    $result = $db->createVehiculoController(
                        $data['placa'],
                        $data['id_conductor'],
                        $data['marca'],
                        $data['modelo'],
                        $data['color'],
                        $data['tipo_vehiculo']
                    );

                    if ($result) {
                        $response['error'] = false;
                        $response['message'] = 'Vehiculo agregado correctamente';
                        $response['contenido'] = $db->readVehiculosController();
                    } else {
                        $response['error'] = true;
                        $response['message'] = 'Ocurrió un error, intenta nuevamente';
                    }
                }
                break;

            default:
                $response['error'] = true;
                $response['message'] = 'Llamado Inválido del API';
                break;
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT' && $apicall === 'updatevehiculo') {
    if (!empty($placa)) {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if ($data !== null) {
            $result = $db->updateVehiculoController(
                $placa,
                $data['id_conductor'],
                $data['marca'],
                $data['modelo'],
                $data['color'],
                $data['tipo_vehiculo']
            );

            if ($result) {
                $response['error'] = false;
                $response['message'] = 'Vehiculo actualizado correctamente';
                $response['contenido'] = $db->readVehiculosController();
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
        $response['message'] = 'ID de vehiculo no proporcionado';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $apicall === 'deletevehiculo') {
    if (!empty($placa)) {
        $result = $db->deleteVehiculoController($placa);

        if ($result) {
            $response['error'] = false;
            $response['message'] = 'Vehiculo eliminado correctamente';
            $response['contenido'] = $db->readVehiculosController();
        } else {
            $response['error'] = true;
            $response['message'] = 'Ocurrió un error, intenta nuevamente';
        }
    } else {
        $response['error'] = true;
        $response['message'] = 'ID de vehiculo no proporcionado';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $apicall === 'readvehiculo') {
    if (empty($placa)) {
        $response['error'] = false;
        $response['message'] = 'Solicitud completada correctamente';
        $response['contenido'] = $db->readVehiculosController();
    } else {
        $response['error'] = false;
        $response['message'] = 'Solicitud completada correctamente';
        $response['contenido'] = $db->readVehiculosController($placa);
    }
} else {
    $response['error'] = true;
    $response['message'] = 'Método de solicitud no válido';
}

echo json_encode($response);
