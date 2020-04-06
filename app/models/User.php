<?php
class User
{
    private $dataBase;

    public function __construct()
    {
        $this->dataBase = new Database;
    }

    // Register user

    public function register($data)
    {
        // Prepare sql
        $this->dataBase->query('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
        //Bind values
        $this->dataBase->bind(':name', $data['name']);
        $this->dataBase->bind(':email', $data['email']);
        $this->dataBase->bind(':password', $data['password']);
        //Execute sql
        if ($this->dataBase->execute()) {
            return true;
        } else {
            return false;
        }

    }

    // Login user

    public function login($email, $password)
    {
        // Prepare sql
        $this->dataBase->query('SELECT * FROM users WHERE email=:email');
        // Bind values
        $this->dataBase->bind(':email', $email);
        // Find registered user by email (by binding email above)
        $row = $this->dataBase->resultSingle();
        // Checking if login form input value equals to database stored password
        $hashed_password = $row->password;
        // If true - return results
        if (password_verify($password, $hashed_password)) {
            return $row;
        } else {
            return false;
        }

    }

    // Find user by email
    public function findUseryEmail($email)
    {
        // Prepare sql
        $this->dataBase->query('SELECT * FROM users WHERE email=:email');
        //Bind values
        $this->dataBase->bind(':email', $email);
        // Find single result
        $row = $this->dataBase->resultSingle();

        if ($this->dataBase->countRows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserById($id)
    {
        // Prepare sql
        $this->dataBase->query('SELECT * FROM users WHERE id=:id');
        //Bind values
        $this->dataBase->bind(':id', $id);
        // Find single result
        $result = $this->dataBase->resultSingle();

        return $result;
    }

}