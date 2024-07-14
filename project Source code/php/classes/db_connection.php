<?php
class DbConnection
{
    private $servername = "localhost";
    private $username = "unihub";
    private $password = "Unihub@1234";
    private $dbname = "wellassaunihub";
    private $conn;

    // Method to create the database connection
    private function connect()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        // Check the connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Method to get the connection
    public function getConnection()
    {
        return $this->conn;
    }

    // Method to close the connection
    public function close()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
