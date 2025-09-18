<?php
class PasswordController
{
    private $conn;

    public function __construct($dbconn)
    {
        $this->conn = $dbconn;
    }

    public function changePassword($userId, $oldPassword, $newPassword)
    {
        $stmt = $this->conn->prepare("SELECT password_hash FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (password_verify($oldPassword, $row['password_hash'])) {
                $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
                $update  = $this->conn->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
                $update->bind_param("si", $newHash, $userId);
                return $update->execute();
            }
        }
        return false;
    }
}
