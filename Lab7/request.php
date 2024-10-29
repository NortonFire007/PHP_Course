<?php
session_start();
require_once 'user.php';

function handleRequest()
{
    $response = array('success' => false, 'message' => '');

    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'register':
                $response = registerUser($_POST['username'], $_POST['email'], $_POST['password']);
                break;
            case 'login':
                $response = loginUser($_POST['email'], $_POST['password']);
                break;
            case 'logout':
                $response = logoutUser();
                break;
            case 'updateProfile':
                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];
                    $response = updateProfile($user_id, $_POST['newUsername'], $_POST['newPassword']);
                } else {
                    $response['message'] = 'Вам потрібно увійти.';
                }
                break;
            default:
                $response['message'] = 'Невідома дія.';
                break;
        }
    }

    return $response;
}
