<?php

class User {

    private $id;
    private $email;
    private $hash;
    private $canCreateUser;
    private $pdo;


    /**
     * sets class variables
     *
     * @param PDO $pdo database connection
     */
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    private function validateEmail($email) {

        // Remove all illegal characters from email
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        // Validate e-mail
        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new Exception('not a valid email address');
        }

        return true;
    }

    /**
     * @return mixed
     */
    public function getCanCreateUser()
    {
        return $this->canCreateUser;
    }

    /**
     * sets the session data and adds random validation string to database
     *
     * @param STRING $email email to check against database
     * @param STRING $password password to check against database
     */
    function login($email, $password) {

        if($this->validateEmail($email) && $this->validateDetails($email, $password)) {
            $token = sha1(time());

            //set all data used to validate / display
            $_SESSION['userAuth'] = $token;
            $_SESSION['id'] = $this->id;
            $_SESSION['email'] = $email;

            $sql = "UPDATE `users` SET `validationString` = :token WHERE `id` = " . $this->id . ";";
            $query = $this->pdo->prepare($sql);
            return $query->execute([':token'=>$token]);
        } else {
            throw new Exception('Invalid Login');
        }
    }

    /**
     * updates user email in database and $_SESSION
     *
     * @param STRING $newEmail email to add to database
     */
    public function changeEmail($newEmail){

        if($this->validateEmail($newEmail)){
            $sql = "UPDATE `users` SET `email` = :email WHERE `id` = " . $this->id . ";";
            $query = $this->pdo->prepare($sql);
            $query->execute([':email'=>$newEmail]);

            $_SESSION['email'] = $newEmail;
        }


    }

    /**
     * updates user password in database
     *
     * @param STRING $newPassword password to add to database
     */
    public function changePassword($password){

        $newPassword = $this->hash . $password;
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

        if(!$this->validateEmail($email)) {
            throw new Exception("not valid email");
        }

        $sql = "SELECT * FROM `users` WHERE `email` = :email;";
        $query = $this->pdo->prepare($sql);
        $query->execute([':email'=>$email]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if(empty($user)) {
            throw new Exception("user does not exist");
        }

        $encryptPass = $user['hash'] . $password;
        $encryptPass = sha1($encryptPass);

        if($user['password'] != $encryptPass) {
            throw new Exception("incorrect email and password combination");
        } else {
            $this->setUserDetails($user);
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
        $sql = "SELECT `users`.*, `permissions`.`canCreateUser` FROM `users` LEFT JOIN  `permissions` ON `users`.`id`=`permissions`.`userId` WHERE `id` = :id;";
        $query = $this->pdo->prepare($sql);
        $query->execute([':id' => $id]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($token != $user['validationString']) {
            throw new Exception('error validating user');
        }

        $this->id = $id;
        return $this->setUserDetails($user);

    }

    public function setUserDetails($user){
        //set details
        $this->id = $user['id'];
        $this->email = $user['email'];
        $this->canCreateUser = $user['canCreateUser'];
        $this->hash = $user['hash'];
        return true;
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

    /**
     * Add a user to the database with an a
     *
     * @param $arr ARRAY An associative array of user data of the form $arr['column'] = value;
     * @return STRING A PDOStatement error code, 00000 is ok.
     */
    public function addUser($arr) {

        $arr = $this->validateAddUserData($arr);
        $queryString = 'INSERT INTO `users` (' .
                        implode(', ', array_keys($arr)) .
                        ') ' .
                        'VALUES (' .
                        implode(', ', array_fill(0, count($arr), '?')) .
                        ');';
        $statement = $this->pdo->prepare($queryString);
        $statement->execute(array_values($arr));
        return $statement->errorCode();
    }

    private function validateAddUserData($arr) {

        // Let id auto increment
        unset($arr['id']);
        $arr['hash'] = $arr['hash'] ?: mt_rand(1000,9999);

        // Required fields
        $arr['department'] = !empty($arr['department']) ?: 2; // Undefined as default
        if (!empty($arr['password'])) {
            $arr['password'] = sha1($arr['hash'] . $arr['password']);
        } else {
            throw New Exception('Tried to add new user with no password!');
        }
        return $arr;
    }


}