<?php
class database{
    function opencon() {
        return new PDO('mysql:host=localhost;dbname=loginmethod','root','');
    }
    function check($Username, $Pass_word){
        $con = $this->opencon();
        $query = "Select * from users WHERE Username='".$Username."'&& Pass_word='".$Pass_word."'";
        return  $con->query($query)->fetch();
    }
 
}