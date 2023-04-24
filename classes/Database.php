<?php
class DatabaseConnection {
    private $host;
    private $username;
    private $password;
    private $database;
    private $pdo;

    public function __construct($host, $username, $password, $database) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;

        $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";

        try {
            $this->pdo = new PDO($dsn, $username, $password);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        $params = array_values($data);

        $stmt = $this->query($sql, $params);

        return $this->pdo->lastInsertId();
    }

    public function update($table, $data, $where) {
        $set = '';
        foreach ($data as $column => $value) {
            $set .= "$column=?, ";
        }
        $set = rtrim($set, ', ');

        $sql = "UPDATE $table SET $set WHERE $where";

        $params = array_values($data);

        $stmt = $this->query($sql, $params);

        // return $stmt->rowCount();
        return true;
    }

    public function delete($table, $where) {
        $sql = "DELETE FROM $table WHERE $where";

        $stmt = $this->query($sql);

        return $stmt->rowCount();
    }

    public function getLastInsertId() {
        return $this->pdo->lastInsertId();
    }
}

?>