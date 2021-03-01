
<?php

class ProductController {
    public function __construct () {
        $this->dao = new ProductDAO();
    }
    
    public function index () {
        $products = $this->dao->fetchAll();
        include ('productlist.php');
    }

    public function show($id){
        $product = $this->dao->fetch($id);
        include('view/product.php');
    }

    public function creat(){
        include ('addproduct.php');
    }

    public function store ($data){
        $this->dao->store($data);
    }

    public function edit ($id){
        $product = $this->dao->fetch($id);
        include('editproduct.php');
    }

    public function update ($data){
        $product = $this->dao->update($data);
    }

    public function delete($data){
        $this->dao->delete($data);
    }
}