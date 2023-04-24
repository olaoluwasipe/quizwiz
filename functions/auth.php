<?php
include("conn.php");
require_once '../classes/Authentication/FormValidator.php';
require_once '../classes/Authentication/LoginProcess.php';
require_once '../classes/Authentication/SignUpProcess.php';
session_start();

$formData = array(
    'email' => $_POST['email'],
    'password' => $_POST['password'],
    'cpassword' => isset($_POST['cpassword']) ? $_POST['cpassword'] : '',
    'firstName' => isset($_POST['firstName']) ? $_POST['firstName'] : '',
    'lastName' => isset($_POST['lastName']) ? $_POST['lastName'] : '',
    'acctType' => isset($_POST['acctType']) ? $_POST['acctType'] : '',
);

$formValidator = new FormValidator($formData);

if(!$formValidator->validateForm($login="yes")){
    $errors = $formValidator->getErrors();
    echo json_encode(array("errors"=>$errors));
}else{
    // print_r($formData);
    if(isset($_POST['login'])){
        $login = new LoginProcess($db);
        if(!$login->authenticateUser($formData['email'], $formData['password'])){
            echo json_encode(array("errors" => $login->getErrors()));
        }else{
            $_SESSION['user'] = $login->getUserData($_SESSION['user_id']);
            $user = json_encode(array("user" => $login->getUserData($_SESSION['user_id'])));
            echo $user;
        }
    }
    
    if(isset($_POST['signup'])){
        $signup = new SignUpProcess($db);
        if(!$signup->createUser($formData['firstName'], $formData['lastName'], $formData['email'], $formData['password'], $formData['cpassword'], $formData['acctType'])){
            echo json_encode(array("errors" => $signup->getErrors()));
        }else{
            $_SESSION['user'] = $signup->getUserData($_SESSION['user_id']);
            $user = json_encode(array("user" => $signup->getUserData($_SESSION['user_id'])));
            echo $user;
        }
    }

    if(isset($_POST['changePassword'])){
        $login = new LoginProcess($db);
        $email = $formData['email'];
        $oldPassword = $_POST['oldpassword'];
        $newPassword = $formData['password'];
    
        $passwordChanged = $login->changePassword($email, $oldPassword, $newPassword);
    
        if ($passwordChanged) {
            echo json_encode($passwordChanged);
        }
    }
}


if(isset($_POST['logout'])){
    $login = new LoginProcess($db);
    $login->logout();
}

