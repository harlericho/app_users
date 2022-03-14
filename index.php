<?php
require_once './config/cors.php';
require_once './app/models/user.php';
require_once './app/validation/user.php';
date_default_timezone_set('America/Guayaquil');
if ($_GET) {
    $data = null;
    $option = $_GET['option'];
    switch ($option) {
        case 'GET':
            $users = User::getAllUsers();
            $data = array(
                'status' => 'success',
                'users' => $users
            );
            break;
        case 'GET_ID':
            $user = User::getUserById($_POST['id']);
            if ($user) {
                $data = array(
                    'status' => 'success',
                    'user' => $user
                );
            } else {
                $data = array(
                    'status' => 'warning',
                    'message' => 'No se encontró el usuario'
                );
            }
            break;
        case 'POST':
            if (Validation::validationUserDni($_POST['dni'])) {
                $data = Validation::validationUserDni($_POST['dni']);
                // $data = array(
                //     'status' => 'error',
                //     'message' => 'Dni is already taken'
                // );
            } else if (Validation::validationUserEmail($_POST['email'])) {
                $data = Validation::validationUserEmail($_POST['email']);
                // $data = array(
                //     'status' => 'error',
                //     'message' => 'Email is already taken'
                // );
            } else {
                $arrayName = array(
                    'dni' => $_POST['dni'],
                    'names' => $_POST['names'],
                    'email' => $_POST['email'],
                    'address' => $_POST['address'],
                    'rol' => $_POST['rol']
                );
                User::createUser($arrayName);
                $data = array(
                    'status' => 'success',
                    'message' => 'User created'
                );
            }
            break;
        case 'PUT':
            if (User::validationUserDniUpdate($_POST['dni'], $_POST['id']) >= 2) {
                $data = array(
                    'status' => 'error',
                    'message' => 'Dni is already taken'
                );
            } else if (User::validationUserEmailUpdate($_POST['email'], $_POST['id']) >= 2) {
                $data = array(
                    'status' => 'error',
                    'message' => 'Email is already taken'
                );
            } else {
                $arrayName = array(
                    'id' => $_POST['id'],
                    'dni' => $_POST['dni'],
                    'names' => $_POST['names'],
                    'email' => $_POST['email'],
                    'address' => $_POST['address'],
                    'rol' => $_POST['rol']
                );
                User::updateUser($arrayName);
                $data = array(
                    'status' => 'success',
                    'message' => 'User updated'
                );
            }
            break;
        case 'DELETE':
            User::deleteUser($_POST['id']);
            $data = array(
                'status' => 'success',
                'message' => 'User deleted'
            );
            break;
        default:
            $data = null;
            break;
    }
    if ($data) {
        if ($data['status'] == 'success') {
            header('HTTP/1.1 200 OK');
            header('Content-Type: application/json');
            echo json_encode($data);
        } else if ($data['status'] == 'error') {
            header('HTTP/1.1 422 Unprocessable Entity');
            header('Content-Type: application/json');
            echo json_encode($data);
        } else if ($data['status'] == 'warning') {
            header('HTTP/1.1 400 Bad Request');
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }
}
