<?php

require_once __DIR__ . '/../Models/User.php';

class UserService
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        return $row ? new User($row) : null;
    }

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([strtolower(trim($email))]);
        $row = $stmt->fetch();

        return $row ? new User($row) : null;
    }

    public function register($name, $email, $password, $passwordConfirm)
    {
        $name = trim($name);
        $email = strtolower(trim($email));

        if ($name === '' || mb_strlen($name) > 100) {
            return 'Introduceți numele (maximum 100 de caractere).';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Introduceți o adresă de email validă.';
        }

        if (mb_strlen($password) < 8) {
            return 'Parola trebuie să aibă cel puțin 8 caractere.';
        }

        if ($password !== $passwordConfirm) {
            return 'Parolele nu coincid.';
        }

        if ($this->findByEmail($email)) {
            return 'Există deja un cont cu acest email.';
        }

        $stmt = $this->db->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
        $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);

        return null;
    }

    public function login($email, $password)
    {
        $user = $this->findByEmail($email);

        if ($user && $user->checkPassword($password)) {
            return $user;
        }

        return null;
    }
}
