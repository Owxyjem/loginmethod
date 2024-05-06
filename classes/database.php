<?php
class Database {
    
    public function opencon() {
        return new PDO('mysql:host=localhost;dbname=loginmethod','root','');
    }
    
    public function check($username, $password) {
        $con = $this->opencon();
        $query = "SELECT * FROM users WHERE username=? AND password=?";
        return $con->query($query)->fetch(); 
    }
   
    public function insertAddress($userID, $street, $city, $barangay, $province) {
        $con = $this->opencon();
        $query = "INSERT INTO users_address (userID, users_add_street, users_add_city, users_add_barangay, users_add_province) VALUES (?, ?, ?, ?, ?)";
        return $con->prepare($query)->execute([$userID, $street, $city, $barangay, $province]); 
    }
    
    public function register($username, $password, $firstname, $lastname, $birthday, $sex) {
        $con = $this->opencon();   
        $query = "INSERT INTO users (username, password, lastname, firstname, birthday, sex) VALUES (?, ?, ?, ?, ?, ?)";
        $con->prepare($query)->execute([$username, $password, $lastname, $firstname, $birthday, $sex]); 
        return $con->lastInsertId();
    }
    
    public function isUsernameTaken($username) {
        $con = $this->opencon();
        $query = "SELECT COUNT(*) FROM users WHERE Username=?";
        $count = $con->prepare($query)->execute([$username])->fetchColumn(); 
        return $count > 0; 
    }
}
?>
