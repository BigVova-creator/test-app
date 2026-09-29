<?php

function getConnection()
{
    $host = 'localhost';
    $dbName = 'techstore';
    $user = 'root';
    $password = '';

    $db = new PDO("mysql:host=$host;charset=utf8mb4", $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $exists = $db->query("SHOW DATABASES LIKE '$dbName'")->fetch();

    if (!$exists) {
        $db->exec(file_get_contents(__DIR__ . '/../database/schema.sql'));
    }

    $db->exec("USE $dbName");

    return $db;
}
