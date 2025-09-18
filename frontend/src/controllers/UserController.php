<?php
class UserController
{
    private $conn;

    public function __construct($dbconn)
    {
        $this->conn = $dbconn;
    }

    public function getUserById($id)
    {
        $stmt = $this->conn->prepare("SELECT id, full_name, email, mobile, status FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function createUser($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO users (full_name, email, mobile) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $data['full_name'], $data['email'], $data['mobile']);
        return $stmt->execute();
    }

    public function updateUser($id, $data)
    {
        $stmt = $this->conn->prepare("UPDATE users SET full_name = ?, email = ?, mobile = ? WHERE id = ?");
        $stmt->bind_param("sssi", $data['full_name'], $data['email'], $data['mobile'], $id);
        return $stmt->execute();
    }

    public function deleteUser($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
