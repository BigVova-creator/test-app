<?php

function getConnection()
{
    $dbFile = __DIR__ . '/../storage/database.db';
    $isNewDatabase = !file_exists($dbFile);

    $db = new PDO('sqlite:' . $dbFile);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    if ($isNewDatabase) {
        $db->exec(file_get_contents(__DIR__ . '/../database/schema.sql'));
    }

    return $db;
}
