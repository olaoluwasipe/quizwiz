<?php
class FormValidator {
    private $email;
    private $password;
    private $firstName;
    private $lastName;

    public function __construct($formData) {
        $this->email = $formData['email'];
        $this->password = $formData['password'];
        $this->firstName = $formData['firstName'];
        $this->lastName = $formData['lastName'];
    }

    public function validateEmail() {
        if(empty($this->email)) {
            return false;
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    public function validatePassword() {
        $uppercase = preg_match('@[A-Z]@', $this->password);
        $lowercase = preg_match('@[a-z]@', $this->password);
        $number    = preg_match('@[0-9]@', $this->password);
        $specialChars = preg_match('@[^\w]@', $this->password);

        if(empty($this->password) || strlen($this->password) < 8 || !$uppercase || !$lowercase || !$number || !$specialChars) {
            return false;
        }
        return true;
    }

    public function validateFirstName() {
        if(empty($this->firstName) || !preg_match('/^[a-zA-Z]+$/', $this->firstName)) {
            return false;
        }
        return true;
    }

    public function validateLastName() {
        if(empty($this->lastName) || !preg_match('/^[a-zA-Z]+$/', $this->lastName)) {
            return false;
        }
        return true;
    }

    public function validateForm($login = "no") {
        if($login == "yes"){
            if(!$this->validateEmail() || !$this->validatePassword()) {
                return false;
            }
        }else{
            if(!$this->validateEmail() || !$this->validatePassword() || !$this->validateFirstName() || !$this->validateLastName()) {
                return false;
            }
        }
        return true;
    }

    public function getErrors() {
        $errors = array();
        if(!$this->validateEmail()) {
            $errors[] = "Invalid email format";
        }
        if(!$this->validatePassword()) {
            $errors[] = "Password must be at least 8 characters long and contain upper and lowercase letters, numbers, and special characters";
        }

        return $errors;
    }
}
       
