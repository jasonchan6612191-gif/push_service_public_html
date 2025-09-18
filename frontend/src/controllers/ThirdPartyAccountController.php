<?php
class ThirdPartyAccountController
{
    private $conn;

    public function __construct($dbconn)
    {
        $this->conn = $dbconn;
    }

    public function linkAccount($userId, $provider, $accountData)
    {
        $stmt        = $this->conn->prepare("INSERT INTO third_party_accounts (user_id, provider, account_info) VALUES (?, ?, ?)");
        $accountJson = json_encode($accountData);
        $stmt->bind_param("iss", $userId, $provider, $accountJson);
        return $stmt->execute();
    }

    public function unlinkAccount($userId, $provider)
    {
        $stmt = $this->conn->prepare("DELETE FROM third_party_accounts WHERE user_id = ? AND provider = ?");
        $stmt->bind_param("is", $userId, $provider);
        return $stmt->execute();
    }

    public function getLinkedAccounts($userId)
    {
        $stmt = $this->conn->prepare("SELECT provider, account_info FROM third_party_accounts WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result   = $stmt->get_result();
        $accounts = [];
        while ($row = $result->fetch_assoc()) {
            $row['account_info'] = json_decode($row['account_info'], true);
            $accounts[]          = $row;
        }
        return $accounts;
    }

    public function updateAccount($userId, $provider, $newAccountData)
    {
        $stmt           = $this->conn->prepare("UPDATE third_party_accounts SET account_info = ? WHERE user_id = ? AND provider = ?");
        $newAccountJson = json_encode($newAccountData);
        $stmt->bind_param("sis", $newAccountJson, $userId, $provider);
        return $stmt->execute();
    }
}
