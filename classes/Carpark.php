<?php

/**
 * Created by PhpStorm.
 * User: benmorris
 * Date: 14/11/2016
 * Time: 14:35
 */
class Carpark
{
    const CARPARK_TABLE_NAME = 'carpark';

    private $pdo;
    private $id;
    private $name;
    private $capacity;
    private $isVisitor;

    public function __construct(PDO $pdo, $name) {

        $statement = $pdo->prepare('SELECT * FROM `' . self::CARPARK_TABLE_NAME . '` WHERE `name` = ?;');
        $statement->execute(array($name));
        $result = $statement->fetch();
        if (!empty($result)) {
            $this->pdo = $pdo;
            $this->id = $result['id'];
            $this->name = $name;
            $this->capacity = $result['capacity'];
            $this->isVisitor = $result['isVisitor'];
            return $this;
        } else {
            throw new Exception ('Carpark with name ' . $name . ' does not exist in pdo.');
        }

    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getCapacity() {
        return $this->capacity;
    }

    public function isVisitor() {
        return $this->isVisitor;
    }


}