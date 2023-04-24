<?php
session_start();
include("conn.php");

if(isset($_POST['updateProfile'])){
        $user_type = $_SESSION['user']['type'];
        if($user_type){
            $page = "tutor";
        }else{
            $page = "learner";
        }
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $user_id = $_SESSION['user_id'];
        if(isset($_FILES['user-image']) && $_FILES['user-image']['error'] == 0){
            $file_name = $_FILES['user-image']['name'];
            $file_size = $_FILES['user-image']['size'];
            $file_tmp = $_FILES['user-image']['tmp_name'];
            $file_type = $_FILES['user-image']['type'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $extensions = array("jpeg","jpg","png");
            if(in_array($file_ext,$extensions)=== false){
                echo "Extension not allowed, please choose a JPEG or PNG file.";
                exit();
            }
            $new_file_name = uniqid('', true) . '.' . $file_ext;
            $upload_path = '../'.$page.'/assets/img/' . $new_file_name;
            move_uploaded_file($file_tmp, $upload_path);
            $data = [
                'firstName' => $firstName,
                'lastName' => $lastName,
                'email' => $email,
                'phone' => $phone,
                'image' => $new_file_name
            ];
        }else{
            $data = [
                'firstName' => $firstName,
                'lastName' => $lastName,
                'email' => $email,
                'phone' => $phone,
            ];
        }
        $where = "id = ".$user_id;
    
        $update = $db->update('users', $data, $where);
        if($update){
            header("location: ../".$page."/profile.php");
            exit();
        }else{
            echo "There was an error";
            exit();
        }
}