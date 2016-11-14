<?php

class User {

    private $loggedIn;
    private $id;

    public function __construct(){
        $this->loggedIn = FALSE;
    }

    //login function
    function login($database, $email, $password) {

        $sql = "SELECT * FROM `users` WHERE `email` = :email;";
        $query = $database->prepare($sql);
        $query->execute([':email'=>$email]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        $encryptPass = $user["id"] . $password;
        $encryptPass = sha1($encryptPass);

        if(empty($user)) {
            throw new Exception("user does not exist");
        } elseif($user["password"] != $encryptPass) {
            throw new Exception("incorrect email and password combination");
        } else {
            $this->loggedIn = TRUE;
            $this->id = $user['id'];
        }
    }

    public function logOut(){
        $this->loggedIn = FALSE;
    }

    public function getLoggedIn(){
        return $this->loggedIn;
    }

    //TODO: change details function(s)
}
