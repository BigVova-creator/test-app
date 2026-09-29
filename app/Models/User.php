<?php

class User
{
    public $id;
    public $name;
    public $email;
    public $createdAt;
    private $password;

    public function __construct($row)
    {
        $this->id = (int) $row['id'];
        $this->name = $row['name'];
        $this->email = $row['email'];
        $this->createdAt = $row['created_at'];
        $this->password = $row['password'];
    }

    public function checkPassword($password)
    {
        return password_verify($password, $this->password);
    }
}
