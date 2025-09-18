<?php

class PushController
{
    private $conn;

    public function __construct($dbconn)
    {
        $this->conn = $dbconn;
    }

    public function getPushSubscriptions($userId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM push_subscriptions WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function addPushSubscription($userId, $endpoint, $keys)
    {
        $stmt = $this->conn->prepare("INSERT INTO push_subscriptions (user_id, endpoint, p256dh, auth) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $userId, $endpoint, $keys['p256dh'], $keys['auth']);
        return $stmt->execute();
    }

    public function removePushSubscription($userId, $endpoint)
    {
        $stmt = $this->conn->prepare("DELETE FROM push_subscriptions WHERE user_id = ? AND endpoint = ?");
        $stmt->bind_param("is", $userId, $endpoint);
        return $stmt->execute();
    }

    public function sendPushNotification($userId, $message)
    {
        return true;
    }
}
