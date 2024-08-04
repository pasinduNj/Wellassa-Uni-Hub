<?php

class User
{
    private $userId;
    private $firstName;
    private $lastName;
    private $businessName;
    private $phone;
    private $wphone;
    private $email;
    private $address;
    private $description;
    private $profileImage;
    private $productId;
    private $amountPer;
    private $dbconn;

    public function __construct()
    {
    }
    //constructor for sarath products
    public static function constructSPWithProductId($dbconn, $userId, $productId)
    {
        $user = new self();
        $user->dbconn = $dbconn;
        $user->userId = $userId;
        $user->productId = $productId;
        $user->loadUserSP();
        return $user;
    }

    public static function constructSPWithUserId($dbconn, $userId)
    {
        $user = new self();
        $user->dbconn = $dbconn;
        $user->userId = $userId;
        $user->loadUserSP();
        return $user;
    }
    public static function constructCUSWithUserId($dbconn, $userId)
    {
        $user = new self();
        $user->dbconn = $dbconn;
        $user->userId = $userId;
        $user->loadUserCUS();
        return $user;
    }


    private function loadUserCUS()
    {
        $stmt = $this->dbconn->prepare("SELECT * FROM user WHERE user_id = ?");
        $stmt->bind_param("s", $this->userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $this->firstName = $user['first_name'];
        $this->lastName = $user['last_name'];
        $this->phone = $user['contact_number'];
        $this->email = $user['email'];
        $this->profileImage = $user['profile_photo'];
    }

    private function loadUserSP()
    {
        $stmt = $this->dbconn->prepare("SELECT * FROM user WHERE user_id = ?");
        $stmt->bind_param("s", $this->userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $this->businessName = $user['business_name'];
        $this->phone = $user['contact_number'];
        $this->wphone = $user['whatsapp_number'];
        $this->email = $user['email'];
        $this->address = $user['service_address'];
        $this->description = $user['description'];
        $this->amountPer = $user['amount_per'];
        $this->profileImage = $user['profile_photo'];
    }

    public function getProfileImage()
    {
        return $this->profileImage;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }
    public function getBusinessName()
    {
        return $this->businessName;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getWphone()
    {
        return $this->wphone;
    }
    public function getEmail()
    {
        return $this->email;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getAmountPer(){
        return $this->amountPer;}

    public function setFirstName()
    {
        $stmt = $this->dbconn->prepare("UPDATE user SET first_name=? WHERE user_id=?");
        $stmt->bind_param("ss", $this->firstName, $this->userId);
        $stmt->execute();
    }

    public function setLastName()
    {
        $stmt = $this->dbconn->prepare("UPDATE user SET last_name=? WHERE user_id=?");
        $stmt->bind_param("ss", $this->lastName, $this->userId);
        $stmt->execute();
    }

    public function setBusinessName()
    {
        $stmt = $this->dbconn->prepare("UPDATE user SET business_name=? WHERE user_id=?");
        $stmt->bind_param("ss", $this->businessName, $this->userId);
        $stmt->execute();
    }

    public function setPhone()
    {
        $stmt = $this->dbconn->prepare("UPDATE user SET contact_number=? WHERE user_id=?");
        $stmt->bind_param("ss", $this->phone, $this->userId);
        $stmt->execute();
    }

    public function setWphone()
    {
        $stmt = $this->dbconn->prepare("UPDATE user SET whatsapp_number=? WHERE user_id=?");
        $stmt->bind_param("ss", $this->wphone, $this->userId);
        $stmt->execute();
    }

    public function setEmail()
    {
        $stmt = $this->dbconn->prepare("UPDATE user SET email=? WHERE user_id=?");
        $stmt->bind_param("ss", $this->email, $this->userId);
        $stmt->execute();
    }

    public function setAddress()
    {
        $stmt = $this->dbconn->prepare("UPDATE user SET service_address=? WHERE user_id=?");
        $stmt->bind_param("ss", $this->address, $this->userId);
        $stmt->execute();
    }

    public function setDescription()
    {
        $stmt = $this->dbconn->prepare("UPDATE user SET description=? WHERE user_id=?");
        $stmt->bind_param("ss", $this->description, $this->userId);
        $stmt->execute();
    }
    //remember we need to dynamically change the image url to a specific path
    public function setProfileImage($profileImage)
    {
        $stmt = $this->dbconn->prepare("UPDATE user SET profile_photo=? WHERE user_id=?");
        $stmt->bind_param("ss", $profileImage, $this->userId);
        $stmt->execute();
    }

    public function getPhotos()
    {
        $stmt = $this->dbconn->prepare("SELECT * FROM image WHERE user_id = ?");
        $stmt->bind_param("s", $this->userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $photos = [];
        while ($photo = $result->fetch_assoc()) {
            $photos[] = $photo['image_path'];
        }
        return $photos;
    }
    //for sarath products images
    public function getProductId()
    {
        // i think we have to give the prouduct id with url when click the product
        // so we definitely need to parse an argument to the function.
        // for now i just pass the product id as a parameter from url  
    }

    //i plan this getallproducts function to be used for sarath products on the userprofile page
    public function getAllProducts()
    {
        $stmt = $this->dbconn->prepare("SELECT * FROM product WHERE provider_id = ? AND product_id = ?");
        $stmt->bind_param("ss", $this->userId, $this->productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        while ($product = $result->fetch_assoc()) {
            $products[] = $product;
        }
        return $products;
    }

    //consider the rating
    public function getProductRating()
    {
        $stmt = $this->dbconn->prepare("SELECT * FROM rating WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ss", $this->userId, $this->productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $rating = $result->fetch_assoc();

        return $rating;
    }

    public function getRating()
    {
        $stmt = $this->dbconn->prepare("SELECT * FROM rating WHERE user_id = ?");
        $stmt->bind_param("ss", $this->userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $rating = $result->fetch_assoc();

        return $rating;
    }
    public function getProductPhotos()
    {
        $stmt = $this->dbconn->prepare("SELECT * FROM image WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ss", $this->userId, $this->productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $photos = [];
        while ($photo = $result->fetch_assoc()) {
            $photos[] = $photo['image_path'];
        }
        return $photos;
    }

    public function addPhoto($photoPath)
    {
        $stmt = $this->dbconn->prepare("UPDATE image SET image_path = ?, modified_date =CURRENT_TIMESTAMP WHERE user_id =".$this->userId."");
        $stmt->bind_param("s", $photoPath);
        $stmt->execute();

    }

    public function deletePhoto($photoPath)
    {
        $stmt = $this->dbconn->prepare("DELETE FROM photos WHERE image_path = ? AND user_id = ?");
        $stmt->bind_param("ss", $photoPath, $this->userId);
        $stmt->execute();
    }
}
