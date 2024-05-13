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


    
  function view()
  {
    $con = $this ->opencon();
    return $con->query("SELECT
    users.UserID,
    users.username,
    users.passwords,
    users.firstname,
    users.lastname,
    users.Birthday,
    users.Sex,
    CONCAT(
        user_address.street,
        ' ',
        user_address.barangay,
        ' ',
        user_address.city,
        ' ',
        user_address.province,
        ' '
    ) AS address
FROM
    users
JOIN user_address ON users.UserID = user_address.UserID")-> fetchAll();
  }

  function delete($id)
  {
    try{
        $con = $this->opencon();
        $con->beginTransaction();
        
        $query =$con->prepare("DELETE FROM user_address WHERE userID = ?");
        $query->execute([$id]);

        $query2 =$con->prepare("DELETE FROM user_address WHERE userID = ?");
        $query2->execute([$id]);

        $con->commit();
        return true;
    } catch(PDOException $e) {  
  }
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