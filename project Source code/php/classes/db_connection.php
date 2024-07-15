// File: classes/db_connection.php
<?php
class DbConnection {
    private $servername = "localhost";
    private $username = "unihub";
    private $password = "Unihub@1234";
    private $dbname = "wellassaunihub";
    private $conn;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        // Enable exceptions for MySQLi
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function close() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>
