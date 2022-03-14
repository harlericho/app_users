<?php
require_once './config/cors.php';
require_once './app/models/user.php';
require_once './app/validation/user.php';
date_default_timezone_set('America/Guayaquil');
$data = null;
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id'])) {
            $user = User::getUserById($_GET['id']);
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
        } else {
            $users = User::getAllUsers();
            $data = array(
                'status' => 'success',
                'users' => $users
            );
        }

        break;
    case 'POST':
        $value = json_decode(file_get_contents('php://input'), true);
        if (!Validation::dniLength($value['dni'])) {
            $data = array(
                'status' => 'error',
                'message' => 'Dni must be 10 digits'
            );
        } else if (!Validation::dniEmpty($value['dni'])) {
            $data = array(
                'status' => 'error',
                'message' => 'Dni is required'
            );
        } else if (!Validation::namesEmpty($value['names'])) {
            $data = array(
                'status' => 'error',
                'message' => 'Names is required'
            );
        } else if (!Validation::emailVerification($value['email'])) {
            $data = array(
                'status' => 'error',
                'message' => 'Email is not valid'
            );
        } else if (!Validation::emailEmpty($value['email'])) {
            $data = array(
                'status' => 'error',
                'message' => 'Email is required'
            );
        } else if (!Validation::rolEmpty($value['rol'])) {
            $data = array(
                'status' => 'error',
                'message' => 'Rol is required'
            );
        } else {
            if (User::validationUserDni($value['dni'])) {
                $data = array(
                    'status' => 'error',
                    'message' => 'Dni is already taken'
                );
            } else if (User::validationUserEmail($value['email'])) {
                $data = array(
                    'status' => 'error',
                    'message' => 'Email is already taken'
                );
            } else {
                $arrayName = array(
                    'dni' => $value['dni'],
                    'names' => $value['names'],
                    'email' => $value['email'],
                    'address' => $value['address'],
                    'rol' => $value['rol']
                );
                User::createUser($arrayName);
                $data = array(
                    'status' => 'success',
                    'message' => 'User created'
                );
            }
        }
        break;
    case 'PUT':
        if (isset($_GET['id'])) {
            $value = json_decode(file_get_contents('php://input'), true);
            $user = User::getUserById($_GET['id']);
            if ($user) {
                if (!Validation::dniLength($value['dni'])) {
                    $data = array(
                        'status' => 'error',
                        'message' => 'Dni must be 10 digits'
                    );
                } else if (!Validation::dniEmpty($value['dni'])) {
                    $data = array(
                        'status' => 'error',
                        'message' => 'Dni is required'
                    );
                } else if (!Validation::namesEmpty($value['names'])) {
                    $data = array(
                        'status' => 'error',
                        'message' => 'Names is required'
                    );
                } else if (!Validation::emailVerification($value['email'])) {
                    $data = array(
                        'status' => 'error',
                        'message' => 'Email is not valid'
                    );
                } else if (!Validation::emailEmpty($value['email'])) {
                    $data = array(
                        'status' => 'error',
                        'message' => 'Email is required'
                    );
                } else if (!Validation::rolEmpty($value['rol'])) {
                    $data = array(
                        'status' => 'error',
                        'message' => 'Rol is required'
                    );
                } else {
                    if (User::validationUserDniUpdate($value['dni'], $_GET['id']) >= 2) {
                        $data = array(
                            'status' => 'error',
                            'message' => 'Dni is already taken'
                        );
                    } else if (User::validationUserEmailUpdate($value['email'], $_GET['id']) >= 2) {
                        $data = array(
                            'status' => 'error',
                            'message' => 'Email is already taken'
                        );
                    } else {
                        $arrayName = array(
                            'id' => $_GET['id'],
                            'dni' => $value['dni'],
                            'names' => $value['names'],
                            'email' => $value['email'],
                            'address' => $value['address'],
                            'rol' => $value['rol']
                        );
                        User::updateUser($arrayName);
                        $data = array(
                            'status' => 'success',
                            'message' => 'User updated'
                        );
                    }
                }
            } else {
                $data = array(
                    'status' => 'warning',
                    'message' => 'No se encontró el usuario'
                );
            }
        } else {
            $data = array(
                'status' => 'error',
                'message' => 'No se encontró el usuario'
            );
        }
        break;
    case 'DELETE':
        if (isset($_GET['id'])) {
            $user = User::getUserById($_GET['id']);
            if ($user) {
                User::deleteUser($_GET['id']);
                $data = array(
                    'status' => 'success',
                    'message' => 'User deleted'
                );
            } else {
                $data = array(
                    'status' => 'warning',
                    'message' => 'No se encontró el usuario'
                );
            }
        } else {
            $data = array(
                'status' => 'info',
                'message' => 'Invalid request'
            );
        }

        break;
    default:
        // $data = null;
        $data = array(
            'status' => 'info',
            'message' => 'Invalid request'
        );
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
    } else if ($data['status'] == 'info') {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
