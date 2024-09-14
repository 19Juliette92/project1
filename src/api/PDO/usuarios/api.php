<?php

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
require_once 'controllerjson.php';

$apicall = isset($_GET['apicall']) ? $_GET['apicall'] : '';
$id_usuario = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : '';
$response = array();

$db = new ControllerJson();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $apicall === 'login') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if ($data === null) {
        $response = array(
            'error' => true,
            'message' => 'Error en el contenido JSON',
        );
    } else {
        $user = $db->authenticateUserController($data['nombre_usuario'], $data['contrasena']);

        if ($user) {
            $response['error'] = false;
            $response['contenido'] = $user;
        } else {
            $response['error'] = true;
            $response['message'] = 'Credenciales inválidas';
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $apicall !== 'login') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if ($data === null) {
        $response = array(
            'error' => true,
            'message' => 'Error en el contenido JSON',
        );
    } else {
        switch ($apicall) {
            case 'createusuario':
                $result = $db->createUsuarioController(
                    $data['nombre_usuario'],
                    $data['contrasena'],
                    $data['email'],
                    $data['estado']
                );

                if ($result) {
                    $response['error'] = false;
                    $response['message'] = 'Usuario agregado correctamente';
                    $response['contenido'] = $db->readUsuariosController();
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
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT' && $apicall === 'updateusuario') {
    if (!empty($id_usuario)) {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if ($data !== null) {
            $result = $db->updateUsuarioController(
                $id_usuario,
                $data['nombre_usuario'],
                $data['contrasena'],
                $data['email'],
                $data['estado']
            );

            if ($result) {
                $response['error'] = false;
                $response['message'] = 'Usuario actualizado correctamente';
                $response['contenido'] = $db->readUsuariosController();
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
        $response['message'] = 'ID de usuario no proporcionado';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $apicall === 'deleteusuario') {
    if (!empty($id_usuario)) {
        $result = $db->deleteUsuarioController($id_usuario);

        if ($result) {
            $response['error'] = false;
            $response['message'] = 'Usuario eliminado correctamente';
            $response['contenido'] = $db->readUsuariosController();
        } else {
            $response['error'] = true;
            $response['message'] = 'Ocurrió un error, intenta nuevamente';
        }
    } else {
        $response['error'] = true;
        $response['message'] = 'ID de usuario no proporcionado';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $apicall === 'readusuario') {
    if (empty($id_usuario)) {
        $response['error'] = false;
        $response['message'] = 'Solicitud completada correctamente';
        $response['contenido'] = $db->readUsuariosController();
    } else {
        $response['error'] = false;
        $response['message'] = 'Solicitud completada correctamente';
        $response['contenido'] = $db->readUsuariosController($id_usuario);
    }
} else {
    $response['error'] = true;
    $response['message'] = 'Método de solicitud no válido';
}

echo json_encode($response);
?>
