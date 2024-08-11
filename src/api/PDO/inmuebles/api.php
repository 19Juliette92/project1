<?php

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
require_once 'controllerjson.php';

$apicall = isset($_GET['apicall']) ? $_GET['apicall'] : '';
$id_inmueble = isset($_GET['id_inmueble']) ? $_GET['id_inmueble'] : '';
$response = array();

$db = new ControllerJson();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $apicall !== 'readinmueble') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if ($data === null) {
        $response = array(
            'error' => true,
            'message' => 'Error en el contenido JSON',
        );
    } else {
        switch ($apicall) {
            case 'createinmueble':
                $result = $db->createInmuebleController(
                    $data['bloque'],
                    $data['apto'],
                    $data['id_titular']
                );

                if ($result) {
                    $response['error'] = false;
                    $response['message'] = 'Inmueble agregado correctamente';
                    $response['contenido'] = $db->readInmueblesController();
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
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT' && $apicall === 'updateinmueble') {
    if (!empty($id_inmueble)) {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if ($data !== null) {
            $result = $db->updateInmuebleController(
                $id_inmueble,
                $data['bloque'],
                $data['apto'],
                $data['id_titular']
            );

            if ($result) {
                $response['error'] = false;
                $response['message'] = 'Inmueble actualizado correctamente';
                $response['contenido'] = $db->readInmueblesController();
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
        $response['message'] = 'ID de inmueble no proporcionado';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $apicall === 'deleteinmueble') {
    if (!empty($id_inmueble)) {
        $result = $db->deleteInmuebleController($id_inmueble);

        if ($result) {
            $response['error'] = false;
            $response['message'] = 'Inmueble eliminado correctamente';
            $response['contenido'] = $db->readInmueblesController();
        } else {
            $response['error'] = true;
            $response['message'] = 'Ocurrió un error, intenta nuevamente';
        }
    } else {
        $response['error'] = true;
        $response['message'] = 'ID de inmueble no proporcionado';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $apicall === 'readinmueble') {
    if (empty($id_inmueble)) {
        $response['error'] = false;
        $response['message'] = 'Solicitud completada correctamente';
        $response['contenido'] = $db->readInmueblesController();
    } else {
        $response['error'] = false;
        $response['message'] = 'Solicitud completada correctamente';
        $response['contenido'] = $db->readInmueblesController($id_inmueble);
    }
} else {
    $response['error'] = true;
    $response['message'] = 'Método de solicitud no válido';
}

echo json_encode($response);


?>

