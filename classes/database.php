<?php
class Database {
    //add comment
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
    function view()
    {
        $con = $this->opencon();
        return $con->query("SELECT
        users.UserID,
        users.firstname,
        users.lastname,
        users.birthday,
        users.sex,
        users.username,
        users.password,
        CONCAT(
            users_address.users_add_street,
            ' ',
            users_address.users_add_barangay, ' ',
            users_address.users_add_city, ' ',
            users_address.users_add_province
        ) AS address
    FROM
        users
    JOIN users_address ON users.UserID = users_address.UserID")->fetchAll();
    
    }
    function delete($id)
    {
        try{
            $con = $this->opencon();
            $con->beginTransaction();

            $query = $con->prepare("DELETE FROM users_address WHERE UserID = ?");
            $query->execute([$id]);

            $query2 = $con->prepare("DELETE FROM users WHERE UserID = ?");
            $query2->execute([$id]);

            $con->commit();
            return true;
        } catch (PDOException $e) {
            $con->rollBack();
            return false;
        }
    }
}
?>
