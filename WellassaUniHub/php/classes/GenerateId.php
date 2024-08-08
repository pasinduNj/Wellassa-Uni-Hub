<?php
require_once 'db_connection.php';

class GenerateId
{
    public function generateAdminId($conn)
    {
        $result = $conn->query("SELECT MAX(user_id) AS max_id FROM user WHERE user_id LIKE 'Admin-%'");
        $row = $result->fetch_assoc();
        $maxId = $row['max_id'];

        if ($maxId) {
            $num = (int)substr($maxId, 4); // Extract the numerical part
            $newId = 'Admin-' . str_pad($num + 1, 2, '0', STR_PAD_LEFT); // Increment and format the new ID
        } else {
            $newId = 'Admin-01'; // If no records exist, start with Admin-01
        }

        return $newId;
    }

    public function generateCustomerId($conn)
    {
        $result = $conn->query("SELECT MAX(user_id) AS max_id FROM user WHERE user_id LIKE 'CUS-%'");
        $row = $result->fetch_assoc();
        $maxId = $row['max_id'];

        if ($maxId) {
            $num = (int)substr($maxId, 4); // Extract the numerical part
            $newId = 'CUS-' . str_pad($num + 1, 4, '0', STR_PAD_LEFT); // Increment and format the new ID
        } else {
            $newId = 'CUS-0001'; // If no records exist, start with CUS-0001
        }

        return $newId;
    }
    public function generateServiceProviderId($conn)
    {
        $result = $conn->query("SELECT MAX(user_id) AS max_id FROM user WHERE user_id LIKE 'SP-%'");
        $row = $result->fetch_assoc();
        $maxId = $row['max_id'];

        if ($maxId) {
            $num = (int)substr($maxId, 4); // Extract the numerical part
            $newId = 'SP-' . str_pad($num + 1, 3, '0', STR_PAD_LEFT); // Increment and format the new ID
        } else {
            $newId = 'SP-001'; // If no records exist, start with SP-001
        }

        return $newId;
    }
}
