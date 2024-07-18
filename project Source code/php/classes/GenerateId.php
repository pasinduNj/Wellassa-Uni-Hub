<?php
require_once 'db_connection.php';

class GenerateId
{

    public function generateAdminId($conn)
    {
        $result = $conn->query("SELECT COUNT(*) AS count FROM admins");
        $row = $result->fetch_assoc();
        return 'Admin-' . ($row['count'] + 1);
    }
    public function generateCustomerId($conn)
    {
        $result = $conn->query("SELECT COUNT(*) AS count FROM customers");
        $row = $result->fetch_assoc();
        return 'CUS-' . str_pad($row['count'] + 1, 4, '0', STR_PAD_LEFT);
    }

    public function generateServiceProviderId($conn)
    {
        $result = $conn->query("SELECT COUNT(*) AS count FROM service_providers");
        $row = $result->fetch_assoc();
        return 'SP-' . str_pad($row['count'] + 1, 3, '0', STR_PAD_LEFT);
    }
}
