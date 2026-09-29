<?php

class Product
{
    public $id;
    public $name;
    public $brand;
    public $category;
    public $type;
    public $price;
    public $memory;
    public $description;
    public $image;
    public $stock;
    public $isPopular;

    public function __construct($row)
    {
        $this->id = (int) $row['id'];
        $this->name = $row['name'];
        $this->brand = $row['brand'];
        $this->category = $row['category'];
        $this->type = $row['type'];
        $this->price = (int) $row['price'];
        $this->memory = $row['memory'];
        $this->description = $row['description'];
        $this->image = $row['image'];
        $this->stock = (int) $row['stock'];
        $this->isPopular = (bool) $row['is_popular'];
    }
}
