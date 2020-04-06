<?php
class Post
{
    private $dataBase;

    public function __construct()
    {
        $this->dataBase = new Database;
    }

    public function getPosts()
    {
        // Query that joins users and posts tables
        $this->dataBase->query('SELECT * FROM users INNER JOIN posts ON users.id=posts.user_id ORDER BY posts.created_at DESC');
        $results = $this->dataBase->resultAll();
        return $results;
    }

    public function createPost($data)
    {
        // Prepare sql
        $this->dataBase->query('INSERT INTO posts (title, user_id, body) VALUES (:title, :user_id, :body)');
        //Bind values
        $this->dataBase->bind(':title', $data['title']);
        $this->dataBase->bind(':user_id', $data['user_id']);
        $this->dataBase->bind(':body', $data['body']);
        //Execute query
        if ($this->dataBase->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getPostById($id)
    {
        $this->dataBase->query('SELECT * FROM posts WHERE id=:id');
        $this->dataBase->bind(':id', $id);
        $this->dataBase->execute();

        $result = $this->dataBase->resultSingle();

        return $result;
    }

    public function updatePost($data)
    {
        // Prepare sql
        $this->dataBase->query('UPDATE posts SET title=:title, body=:body WHERE id=:id');
        //Bind values
        $this->dataBase->bind(':title', $data['title']);
        $this->dataBase->bind(':body', $data['body']);
        $this->dataBase->bind(':id', $data['id']);
        //Execute query
        if ($this->dataBase->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deletePostById($id)
    {
        // Prepare sql
        $this->dataBase->query('DELETE FROM posts WHERE id=:id');
        //Bind values
        $this->dataBase->bind(':id', $id);
        //Execute query
        if ($this->dataBase->execute()) {
            return true;
        } else {
            return false;
        }
    }
}