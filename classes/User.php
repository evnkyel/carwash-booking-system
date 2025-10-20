<?php
class User
{
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }

        return false;
    }

    public function register($name, $email, $phone, $password, $confirm) {
        if ($password !== $confirm) {
            return ['success' => false, 'message' => 'Passwords do not match!'];
        }

        $check = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            return ['success' => false, 'message' => 'Email already exists!'];
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $hashed);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Account created successfully! You can now log in.'];
        } else {
            return ['success' => false, 'message' => 'Something went wrong. Please try again.'];
        }
    }



    public function verifyPassword($user_id, $current_password) {
        $stmt = $this->conn->prepare("SELECT password FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $hashed_password = null;
        $stmt->bind_result($hashed_password);

        if ($stmt->fetch() && $hashed_password !== null) {
            $stmt->close();
            return password_verify($current_password, $hashed_password);
        } else {
            $stmt->close();
            return false;
        }
    }


    public function updatePassword($user_id, $new_password) {
        $new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
        $stmt->bind_param("si", $new_hashed, $user_id);
        return $stmt->execute();
    }

    public function getUserById($user_id) {
        $stmt = $this->conn->prepare("SELECT name, email, phone FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateProfile($user_id, $name, $email, $phone) {
        $stmt = $this->conn->prepare("UPDATE users SET name = ?, email = ?, phone = ? WHERE user_id = ?");
        $stmt->bind_param("sssi", $name, $email, $phone, $user_id);
        return $stmt->execute();
    }
}
