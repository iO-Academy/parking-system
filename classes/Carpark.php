<?php

/**
 * Represents a single row of the carpark table.
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

    /**
     * Carpark constructor.
     * @param PDO $pdo
     * @param $name
     * @throws Exception
     */
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

    /**
     * Getter method for the id column.
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Getter method for the name column.
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Getter method for the capacity column.
     * @return mixed
     */
    public function getCapacity() {
        return $this->capacity;
    }

    /**
     * Getter method for the isVisitor column.
     * @return mixed
     */
    public function isVisitor() {
        return $this->isVisitor;
    }

}