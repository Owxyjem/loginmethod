<?php
class database {
    
    function opencon() {
        return new PDO('mysql:host=localhost;dbname=loginmethod','root','');
    }

    function check($username, $password){
        $con = $this->opencon();
        $query = "SELECT * FROM users WHERE username=? AND password=?";
        $stmt = $con->prepare($query);
        $stmt->execute([$username, $password]);
        return $stmt->fetch();
    }
    
    public function register($username, $password) {
        $con = $this->opencon();   
        $query = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $con->prepare($query);
        return $stmt->execute([$username, $password]); 
    }
    
    public function isUsernameTaken($username) {
        $con = $this->opencon();
        $query = "SELECT COUNT(*) FROM users WHERE username=?";
        $stmt = $con->prepare($query);
        $stmt->execute([$username]);
        $count = $stmt->fetchColumn();
        return $count > 0; 
    }
}
?>