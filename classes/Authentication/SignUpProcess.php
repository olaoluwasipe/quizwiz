<?php
class SignUpProcess {
    private $db;
    private $errors;

    public function __construct(DatabaseConnection $db) {
        $this->db = $db;
        $this->errors = [];
    }

    public function createUser($firstName, $lastName, $email, $password, $confirmPassword, $accountType) {
        // Check if email is already in use
        $existingUser = $this->db->fetchOne('SELECT * FROM users WHERE email = ?', [$email]);

        if ($existingUser) {
            // Email is already in use, return error message
            $this->errors[] = 'Email is already in use.';
            return false;
        }

        // Check if password and confirm password match
        if ($password !== $confirmPassword) {
            // Passwords don't match, return error message
            $this->errors[] = 'Passwords do not match.';
            return false;
        }

        // Create unique userToken
        $userToken = uniqid('user_');

        // Add timestamp of registration
        $dateCreated = time();

        // Hash the password before storing it in the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user into the database
        $userId = $this->db->insert('users', [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'password' => $hashedPassword,
            'type' => $accountType,
            'userToken' => $userToken,
            'dateCreated' => date("Y-m-d",$dateCreated)
        ]);

        // Set Session for new User
        $_SESSION['user_id'] = $userId;

        // Return the ID of the newly created user
        return $userId;
    }

    public function getUserData($id) {
        // fetch user data by id
        $user = $this->db->fetchOne('SELECT * FROM users WHERE id = ?', [$id]);

        return $user;
    }

    public function getErrors() {
        return $this->errors;
    }
}

