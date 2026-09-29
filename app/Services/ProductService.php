<?php

require_once __DIR__ . '/../Models/Product.php';

class ProductService
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $rows = $this->db->query('SELECT * FROM products ORDER BY id')->fetchAll();

        $products = [];
        foreach ($rows as $row) {
            $products[] = new Product($row);
        }

        return $products;
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM products WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return new Product($row);
    }
}
