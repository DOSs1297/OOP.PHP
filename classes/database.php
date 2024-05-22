<?php
class database{

    


    function opencon(){
        return new PDO('mysql:host=localhost; dbname=loginmethood', 'root', '');
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
    users.user_profile_picture,
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


    function signupUser($username, $passwords, $firstname, $lastname, $Birthday,$sex, $email, $profilePicture)
    {
        $con = $this->opencon();
        // Save user data along with profile picture path to the database
        $con->prepare("INSERT INTO users (username, passwords, firstname, lastname, Birthday, sex, user_email, user_profile_picture) VALUES (?,?,?,?,?,?,?,?)")->execute([$username, $passwords, $firstname, $lastname, $Birthday,$sex, $email, $profilePicture]);
        return $con->lastInsertId();
        }
    




    // function signupUser($username, $passwords, $firstName, $lastName, $Birthday, $Sex) {
    //     $con = $this->opencon();
   
    //     $query = $con->prepare("SELECT username FROM users WHERE username = ?");
    //     $query->execute([$username]);
    //     $existingUser = $query->fetch();
    //     if ($existingUser){
    //         return false;
    //     }
    //     $query = $con->prepare("INSERT INTO users (username, passwords, firstname, lastname, Birthday, Sex) VALUES (?, ?, ?, ?, ?,?)");
    //     $query->execute([$username, $passwords, $firstName, $lastName, $Birthday,$Sex]);
    //     return $con->lastInsertId();

        //}
        function insertAddress($user_id, $city, $province, $street, $barangay) {
        $con = $this->opencon();
        return $con->prepare("INSERT INTO user_address (UserID, city, province, street, barangay) VALUES (?, ?, ?, ?, ?)")
            ->execute([$user_id, $city, $province, $street, $barangay]);
    }
    function viewdata($id){
    try{
       $con = $this->opencon();
       $query = $con->prepare("SELECT
       users.UserID,
       users.username,
       users.passwords,
       users.firstName,
       users.lastName,
       users.Birthday,
       users.Sex,
   
           user_address.street,
          user_address.barangay,
           user_address.city,
           user_address.province
   FROM
       users
   JOIN  user_address ON users.UserID = user_address.UserID Where users.userID = ?");


       $query->execute([$id]);
       return $query->fetch();
    }
    catch (PDOException $e) {
        return[];
    
    }
 
  }

  function updateUser($user_id, $firstname, $lastname, $birthday,$sex, $username, $password) {
    try {
        $con = $this->opencon();
        $con->beginTransaction();
        $query = $con->prepare("UPDATE users SET firstName=?, lastName=?,Birthday=?, Sex=?,username=?, passwords=? WHERE userID=?");
        $query->execute([$firstname, $lastname, $birthday, $sex, $username, $password,$user_id]);
        // Update successful
        $con->commit();
        return true;
    } catch (PDOException $e) {
        // Handle the exception (e.g., log error, return false, etc.)
         $con->rollBack();
        return false; // Update failed
    }
}

function updateUserAddress($user_id, $street, $barangay, $city, $province) {
    try {
        $con = $this->opencon();
        $con->beginTransaction();
        $query = $con->prepare("UPDATE user_address SET street=?, barangay=?, city=?, province=? WHERE userID=?");
        $query->execute([$street, $barangay, $city, $province, $user_id]);
        $con->commit();
        return true; // Update successful
    } catch (PDOException $e) {
        // Handle the exception (e.g., log error, return false, etc.)
        $con->rollBack();
        return false; // Update failed
    }
     
}
}