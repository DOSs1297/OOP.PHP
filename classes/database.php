<?php
 
class database{
 
    function opencon(){
        return new PDO('mysql:host=localhost; dbname=loginmethod', 'root', '');
    }
    function check($username, $passwords){
        $con = $this->opencon();
        $query = "Select * from users WHERE username='".$username."'&&passwords='".$passwords."'";
        return $con->query($query)->fetch();
    }
    function signup($username, $passwords, $firstname, $lastname, $Birthday, $sex){
        $con = $this->opencon();
   
        $query = $con->prepare("SELECT username FROM users WHERE username = ?");
        $query->execute([$username]);
        $existingUser = $query->fetch();
        if ($existingUser){
            return false; // Username already exists
        }
   
        $query = $con->prepare("INSERT INTO users (username, passwords, firstname, lastname, Birthday, sex) VALUES (?, ?, ?, ?, ?,?)");
        return $query->execute([$username, $passwords, $firstname, $lastname, $Birthday,$sex]);
    }
    function signupUser($username, $passwords, $firstName, $lastName, $Birthday, $Sex) {
        $con = $this->opencon();
   
        $query = $con->prepare("SELECT username FROM users WHERE username = ?");
        $query->execute([$username]);
        $existingUser = $query->fetch();
        if ($existingUser){
            return false;
        }
        $query = $con->prepare("INSERT INTO users (username, passwords, firstname, lastname, Birthday, sex) VALUES (?, ?, ?, ?, ?,?)");
        $query->execute([$username, $passwords, $firstName, $lastName, $Birthday,$Sex]);
        return $con->lastInsertId();

    }function insertAddress($user_id, $city, $province, $street, $barangay) {
        $con = $this->opencon();
        return $con->prepare("INSERT INTO user_address (UserID, city, province, street, barangay) VALUES (?, ?, ?, ?, ?)")
            ->execute([$user_id, $city, $province, $street, $barangay]);
    }
   
 
}