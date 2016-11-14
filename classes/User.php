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

    public function changeEmail($database, $newEmail){

        $sql = "UPDATE `users` SET `email` = :email WHERE `id` = " . $this->id . ";";
        $query = $database->prepare($sql);
        $query->execute([':email'=>$newEmail]);

    }

    public function changePassword($database, $newPassword){

        $newPassword = $this->id . $newPassword;
        $newPassword = sha1($newPassword);

        $sql = "UPDATE `users` SET `password` = :password WHERE `id` = " . $this->id . ";";
        $query = $database->prepare($sql);
        $query->execute([':password'=>$newPassword]);

    }
}