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

    public function logout() {
        session_destroy();
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

    public function validateToken($token, $id)
    {
        $sql = "SELECT `validationString` FROM `users` WHERE `id` = :id;";
        $query = $this->pdo->prepare($sql);
        $query->execute([':id' => $id]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($token != $user['validationString']) {
            throw new Exception('error validating user');
        }
    }

    /**
     * gets all bookings for current user from the bookings table
     *
     * @return ARRAY multidimentional with an array for each row returned
     * @throws Exception
     */
    public function getBookings() {

        $sql = "SELECT `carpark`.`name` AS `Carpark Name`, DATE(`bookings`.`FROM`) AS `Date From`, TIME_FORMAT(`bookings`.`FROM`, '%H:%i') AS `Time From`, DATE(`bookings`.`TO`) AS `Date To`, TIME_FORMAT(`bookings`.`TO`, '%H:%i') AS `Time To` FROM `bookings` LEFT JOIN `carpark` ON `bookings`.`carpark_id`=`carpark`.`id` WHERE `bookings`.`user_id` = :id;";
        $query = $this->pdo->prepare($sql);
        $query->execute([':id' => $this->id]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}