<?php
class OtpController
{
    private $conn;

    public function __construct($dbconn)
    {
        $this->conn = $dbconn;
    }

    public function sendOtp($phone)
    {
        $otp     = rand(100000, 999999);
        $expires = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        $stmt = $this->conn->prepare("REPLACE INTO otp_codes (phone, code, expires_at) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $phone, $otp, $expires);
        if ($stmt->execute()) {
            return $otp;
        }
        return false;
    }

    public function verifyOtp($phone, $code)
    {
        $now  = date('Y-m-d H:i:s');
        $stmt = $this->conn->prepare("SELECT code FROM otp_codes WHERE phone = ? AND expires_at > ?");
        $stmt->bind_param("ss", $phone, $now);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row['code'] == $code;
        }
        return false;
    }

    public function unbindOtp($phone)
    {
        $stmt = $this->conn->prepare("DELETE FROM otp_codes WHERE phone = ?");
        $stmt->bind_param("s", $phone);
        return $stmt->execute();
    }
}
