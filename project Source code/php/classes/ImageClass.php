<?php

class Image{
    private $imageId;
    private $userId;
    private $productId;
    private $imagePath;
    private $modifiedDate;
    private $dbconn;
    public function __construct()    
    {
        
    }

    public static function __constructImageProduct($dbconn,$userId, $productId, $imagePath, $modifiedDate){
        $image = new self();
        $image->dbconn = $dbconn;
        $image->imagePath = $imagePath;
        $image->productId = $productId;
        $image->userId = $userId;
        $image->modifiedDate = $modifiedDate;
        return $image;
    }

    public static function __constructImageUser($dbconn,$userId, $imagePath, $modifiedDate){
        $image = new self();
        $image->dbconn = $dbconn;
        $image->imagePath = $imagePath;
        $image->userId = $userId;
        $image->modifiedDate = $modifiedDate;
        return $image;
    }

    public function selectProductImage($dbconn){
        $sql = "SELECT image_Path FROM image WHERE product_id = ? AND user_id = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bind_param("ss", $this->productId, $this->userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $photos = [];
        while ($photo = $result->fetch_assoc()) {
            $photos[] = $photo['image_path'];
        }
        return $photos;
    }

    public function selectUserImage($dbconn){
        $sql = "SELECT image_Path FROM image WHERE user_id = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bind_param("s", $this->userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $photos = [];
        while ($photo = $result->fetch_assoc()) {
            $photos[] = $photo['image_path'];
        }
        return $photos;
    }

    public function insertProductImage($dbconn){
        $sql = "INSERT INTO image (user_id, product_id, image_path, modifie_date) VALUES (?, ?, ?, ?)";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bind_param("ssss", $this->userId, $this->productId, $this->imagePath, $this->modifiedDate);
        $stmt->execute();
    }

    public function insertUserImage($dbconn){
        $sql = "INSERT INTO image (user_id, image_path, modifie_date) VALUES (?, ?, ?)";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bind_param("sss", $this->userId, $this->imagePath, $this->modifiedDate);
        $stmt->execute();
    }
    public function updateProductImage($dbconn){
        $sql = "UPDATE image SET image_path = ?, modified_date = ? WHERE product_id = ? AND user_id = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bind_param("ssss", $this->imagePath, $this->modifiedDate, $this->productId, $this->userId);
        $stmt->execute();
    }

    public function updateUserImage($dbconn){
        $sql = "UPDATE image SET image_path = ?, modified_date = ? WHERE image_id = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bind_param("sss", $this->imagePath, $this->modifiedDate, $this->userId);
        $stmt->execute();
    }   

    public function deleteProductImage($dbconn){
        $sql = "DELETE FROM image WHERE product_id = ? AND user_id = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bind_param("ss", $this->productId, $this->userId);
        $stmt->execute();
    }

    public function deleteUserImage($dbconn){
        $sql = "DELETE FROM image WHERE user_id = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bind_param("s", $this->userId);
        $stmt->execute();
    }
}