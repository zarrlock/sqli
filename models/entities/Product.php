<?php 

class Product { 
    private $id;
    private $name;
    private $price;
    
    public function __construct ($id, $name, $price) {
        $this->id = $id;
        $this->name = $name;
        $this->price = intval($price) && intval($price) > 0 ? intval($price) : 0;
    }
    
    public function __get ($prop) {
        if (property_exists($this, $prop)) {
            return $this->$prop;
        }
    }
    
    public function __set ($prop, $value) {
        if(property_exists($this, $prop)) {
            $this->$prop = $value;
        }
    } 
}

?> 