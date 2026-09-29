<?php

class Product
{
    public $id;
    public $name;
    public $category;
    public $description;
    public $price;
    public $image;
    public $isPopular;

    public function __construct($row)
    {
        $this->id = (int) $row['id'];
        $this->name = $row['name'];
        $this->category = $row['category'];
        $this->description = $row['description'];
        $this->price = (int) $row['price'];
        $this->image = $row['image'];
        $this->isPopular = (bool) $row['is_popular'];
    }
}
