<?php
class Advertisement {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addAdvertisement($description, $image, $provider, $tillDate) {
        $sql = "INSERT INTO advertisements (description, image, provider, till_date) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssss", $description, $image, $provider, $tillDate);
        return $stmt->execute();
    }

    public function getActiveAdvertisements() {
        $sql = "SELECT * FROM advertisements WHERE till_date >= CURDATE() ORDER BY RAND() LIMIT 5";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}