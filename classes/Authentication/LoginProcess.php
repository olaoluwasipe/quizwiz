<?php
class LoginProcess {
    private $email;
    private $password;
    private $errors;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->errors = [];
    }

    public function authenticateUser($email, $password) {
        $user = $this->db->fetchOne('SELECT * FROM users WHERE email = ?', [$email]);

        if(!$user){
            $this->errors[] = "This Email wasn't found";
            return false;
        }
        if ($user && password_verify($password, $user['password'])) {
            // Authentication successful, return user ID
            $_SESSION['user_id'] = $user['id'];
            return $user['id'];
        } else {
            // Authentication failed, return false
            $this->errors[] = "This password is incorrect";
            return false;
        }
    }

    public function getUserData($id) {
        // fetch user data by id
        $user = $this->db->fetchOne('SELECT * FROM users WHERE id = ?', [$id]);

        return $user;
    }

    public function changePassword($email, $oldPassword, $newPassword) {
        // Check if the email and old password match a user in the database
        $user = $this->authenticateUser($email, $oldPassword);
        if (!$user) {
            return array("error"=>"Wrong Password");
        }

        // Hash the new password
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the user's password in the database
        $updateData = array('password' => $newPasswordHash);
        $where = "email = '".$email."'";
        $params = array($email);
        $updatedRows = $this->db->update('users', $updateData, $where);
        if($updatedRows){
            return array("success"=>"Password Updated successfully");
        }else{
            return array("error"=>"There was an error");
        }
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function redirectLogin() {
        header('Location: login.php');
        exit();
    }

    public function getErrors() {
        return $this->errors;
    }

    public function logout() {
        // Unset all session variables
        $_SESSION = array();
    
        // Destroy the session cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
    
        // Destroy the session
        session_destroy();
    
        // Redirect the user to the login page
        header('Location: /quizwiz/index.html');
        exit;
    }
    
}
