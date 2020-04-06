<?php
/*
 * PDO database class
 * Connect to database
 * Create prepared querys
 * Bind values
 * Return rows and results
 */

class Database
{
    private $host = DB_HOST;
    private $dbname = DB_NAME;
    private $user = DB_USER;
    private $password = DB_PASSWORD;

    private $db;
    private $query;
    private $error;

    public function __construct()
    {
        // Set data source name
        $dsn = 'mysql:host=' . $this->host . '; dbname=' . $this->dbname;

        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        );

        // Create error handling
        try {
            $this->db = new PDO($dsn, $this->user, $this->password, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    // Prepare query with query
    public function query($sql)
    {
        $this->query = $this->db->prepare($sql);
    }

    // Bind values
    public function bind($param, $value)
    {
        $this->query->bindParam($param, $value);
    }

    // Execute prepared statement
    public function execute()
    {
        return $this->query->execute();
    }

    // Get results and set as array of objects
    public function resultAll()
    {
        $this->execute();
        return $this->query->fetchAll(PDO::FETCH_OBJ);
    }
    // Get one single record as object
    public function resultSingle()
    {
        $this->execute();
        return $this->query->fetch(PDO::FETCH_OBJ);
    }
    // Get row count
    public function countRows()
    {
        return $this->query->rowCount();
    }
}