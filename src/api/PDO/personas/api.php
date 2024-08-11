<?php

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
require_once 'controllerjson.php';

$apicall = isset($_GET['apicall']) ? $_GET['apicall'] : '';
$id_persona = isset($_GET['id_persona']) ? $_GET['id_persona'] : '';
$response = array();

$db = new ControllerJson();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $apicall !== 'readpersona') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if ($data === null) {
        $response = array(
            'error' => true,
            'message' => 'Error en el contenido JSON',
        );
    } else {
        switch ($apicall) {
            case 'createpersona':
                $result = $db->createPersonaController(
                    $data['tipo_persona'],
                    $data['tip_doc'],
                    $data['num_doc'],
                    $data['nombres'],
                    $data['apellidos'],
                    $data['genero'],
                    $data['email'],
                    $data['telefono']
                );

                if ($result) {
                    $response['error'] = false;
                    $response['message'] = 'Persona agregado correctamente';
                    $response['contenido'] = $db->readPersonasController();
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
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT' && $apicall === 'updatepersona') {
    if (!empty($id_persona)) {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if ($data !== null) {
            $result = $db->updatePersonaController(
                $id_persona,
                $data['tipo_persona'],
                $data['tip_doc'],
                $data['num_doc'],
                $data['nombres'],
                $data['apellidos'],
                $data['genero'],
                $data['email'],
                $data['telefono']
            );

            if ($result) {
                $response['error'] = false;
                $response['message'] = 'Persona actualizado correctamente';
                $response['contenido'] = $db->readPersonasController();
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
        $response['message'] = 'ID de persona no proporcionado';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $apicall === 'deletepersona') {
    if (!empty($id_persona)) {
        $result = $db->deletePersonaController($id_persona);

        if ($result) {
            $response['error'] = false;
            $response['message'] = 'Persona eliminado correctamente';
            $response['contenido'] = $db->readPersonasController();
        } else {
            $response['error'] = true;
            $response['message'] = 'Ocurrió un error, intenta nuevamente';
        }
    } else {
        $response['error'] = true;
        $response['message'] = 'ID de persona no proporcionado';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $apicall === 'readpersona') {
    if (!empty($id_persona)) {
        // Fetch persona data by id_persona
        $persona = $db->readPersonasController($id_persona);

        if ($persona) {
            $response['error'] = false;
            $response['message'] = 'Persona encontrada correctamente';
            $response['contenido'] = $persona;
        } else {
            $response['error'] = true;
            $response['message'] = 'No se encontró ninguna persona con el ID proporcionado';
        }
    } else {
        // If id_persona is not provided, fetch all personas
        $personas = $db->readPersonasController();

        if ($personas) {
            $response['error'] = false;
            $response['message'] = 'Lista de personas obtenida correctamente';
            $response['contenido'] = $personas;
        } else {
            $response['error'] = true;
            $response['message'] = 'No se encontraron personas';
        }
    }
} else {
    $response['error'] = true;
    $response['message'] = 'Método de solicitud no válido';
}

echo json_encode($response);

?>


