<?php
include('Product.php');

if(isset($_POST) && isset($_POST['createproduct'])) {
    store($_POST);
}

if(isset($_POST) && isset($_POST['deleteproduct'])) {
    delete($_POST);
}

if(!empty($_POST) && !empty($_POST['updateProduct'])){
    update($_POST);
}

function fetchAll () {
    $db_con = new PDO('mysql:host=localhost;dbname=demo', 'root', '');
    $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $table = 'products';
    try {
        $statement = $db_con->prepare("SELECT * FROM {$table}");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return createAll($result);
    } catch (PDOException $e) {
        print $e->getMessage();
    }
}

function fetch($id){
  $db_con = new PDO('mysql:host=localhost;dbname=demo', 'root', '');
  $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $table = 'products';
  try {
      $statement = $db_con->prepare("SELECT * FROM {$table} where pk = ?");
      $statement->execute([$id]);
      $result = $statement->fetch(PDO::FETCH_ASSOC);
      return create($result);
  } catch (PDOException $e) {
      print $e->getMessage();
  }
}

function createAll ($results) {
    $productList = array();
    foreach ($results as $result) {
        array_push($productList, create($result));
    }
    return $productList;
}

function create ($result) {
    return new Product(
        $result['pk'],
        $result['name'],
        $result['price']
    );
}

function store ($data) {
    var_dump($data);
    if(empty($data['name']) || empty($data['price'])) {
        return false;
    }

    $product = create(['pk'=> 0, 'name'=>$data['name'], 'price' => $data['price']]);

    if ($product) {
        $table = 'products';
        $db_con = new PDO('mysql:host=localhost;dbname=demo', 'root', '');
        $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $statement = $db_con->prepare(
                "INSERT INTO {$table} (name, price) VALUES (?, ?)"
            );
            $statement->execute([
                htmlspecialchars($product->__get('name')),
                htmlspecialchars($product->__get('price'))
            ]);
        } catch(PDOException $e) {
            print $e->getMessage();
        }
    }
}

function delete ($data) {
    if(empty($data['id'])) {
        return false;
    }

    $table = 'products';
    $db_con = new PDO('mysql:host=localhost;dbname=demo', 'root', '');
    $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
        $statement = $db_con->prepare("DELETE FROM {$table} WHERE pk=?");
        $statement->execute([
            $data['id']
        ]);
    } catch(PDOException $e) {
        print $e->getMessage();
    }
}

function update($data){
  if(empty($data['id'])) {
      return false;
  }

  $table = 'products';
  $db_con = new PDO('mysql:host=localhost;dbname=demo', 'root', '');
  $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try {
      $statement = $db_con->prepare("UPDATE products SET name = ?, price = ? WHERE pk = ?");
      $statement->execute([
          htmlspecialchars($data['name']),
          htmlspecialchars($data['price']),
          htmlspecialchars($data['id'])
      ]);
  } catch(PDOException $e) {
      print $e->getMessage();
  }
}

$products = fetchAll();

include ('productlist.php');
if(!empty($_POST) && !empty($_POST['modiProduct'])){
  include('modProduct.php');
}
else {
  include ('addproduct.php');
}
