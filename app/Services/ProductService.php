<?php

require_once __DIR__ . '/../Models/Product.php';

class ProductService
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll($category = '')
    {
        if ($category !== '') {
            $stmt = $this->db->prepare('SELECT * FROM products WHERE category = ? ORDER BY id');
            $stmt->execute([$category]);
        } else {
            $stmt = $this->db->query('SELECT * FROM products ORDER BY id');
        }

        $products = [];
        foreach ($stmt->fetchAll() as $row) {
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
