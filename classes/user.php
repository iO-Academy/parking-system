<?php

class User {

    //login function
    function login($database, $email, $password) {

        $sql = "SELECT * FROM `users` WHERE `email` = :email;";
        $query = $database->prepare($sql);
        $query->execute([':email'=>$email]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        $encryptPass = $user["id"] . $password;
        $encryptPass = sha1($encryptPass);

        if(empty($user)) {
            //throw error = user does not exist
        } elseif($user["password"] != $encryptPass) {
            //throw error = incorrect email and password combination
        } else {
            //login
        }
    }

    //public function logout(){}

    //public function changeDetails(){}
}
