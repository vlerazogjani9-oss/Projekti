<?php
require_once __DIR__ . "/Database.php";

class User extends Database {

    public function register($name, $email, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare(
            "INSERT INTO users(name, email, password, role) VALUES (?, ?, ?, 'user')"
        );
        return $stmt->execute([$name, $email, $hash]);
    }

    public function findByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function login($email,$password){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($password,$user['password'])){
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }
}
