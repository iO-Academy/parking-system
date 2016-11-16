<?php

class User {

    private $id;
    private $pdo;


    /**
     * sets class variables
     *
     * @param PDO $pdo database connection
     */
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    /**
     * sets the session data and adds random validation string to database
     *
     * @param STRING $email email to check against database
     * @param STRING $password password to check against database
     */
    function login($email, $password) {

        if($this->validateDetails($email, $password)) {
            $token = sha1(time());
            $_SESSION['userAuth'] = $token;
            $_SESSION['id'] = $this->id;

            $sql = "UPDATE `users` SET `validationString` = :token WHERE `id` = " . $this->id . ";";
            $query = $this->pdo->prepare($sql);
            $query->execute([':token'=>$token]);
        }
    }

    /**
     * updates user email in database
     *
     * @param STRING $newEmail email to add to database
     */
    public function changeEmail($newEmail){

        $sql = "UPDATE `users` SET `email` = :email WHERE `id` = " . $this->id . ";";
        $query = $this->pdo->prepare($sql);
        $query->execute([':email'=>$newEmail]);

    }

    /**
     * updates user password in database
     *
     * @param STRING $newPassword password to add to database
     */
    public function changePassword($newPassword){

        $newPassword = $this->id . $newPassword;
        $newPassword = sha1($newPassword);

        $sql = "UPDATE `users` SET `password` = :password WHERE `id` = " . $this->id . ";";
        $query = $this->pdo->prepare($sql);
        $query->execute([':password'=>$newPassword]);

    }

    /**
     * validates user login details:
     * if email and password match database then sets $loggedIn to TRUE
     *
     * @param STRING $email user email
     * @param STRING $password user password
     *
     * @return BOOLEAN returns if login is successful
     *
     * @throws Exception
     */
    public function validateDetails($email, $password){

        $sql = "SELECT * FROM `users` WHERE `email` = :email;";
        $query = $this->pdo->prepare($sql);
        $query->execute([':email'=>$email]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if(empty($user)) {
            throw new Exception("user does not exist");
        }

        $encryptPass = $user["id"] . $password;
        $encryptPass = sha1($encryptPass);

        if($user["password"] != $encryptPass) {
            throw new Exception("incorrect email and password combination");
        } else {
            $this->id = $user['id'];
            return true;
        }

    }

    /**
     * validates that the session data matches up with the data in the database
     *
     * @param STRING $token validation string to check against database
     * @param STRING $id id of user to check validation string against
     *
     * @throws Exception
     */
    public function validateToken($token, $id) {
        $sql = "SELECT `validationString` FROM `users` WHERE `id` = :id;";
        $query = $this->pdo->prepare($sql);
        $query->execute([':id'=>$id]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if($token != $user['validationString']) {
            throw new Exception('error validating user');
        }

        $this->id = $id;
        
    }
}