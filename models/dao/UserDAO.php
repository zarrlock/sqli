<?php
class UserDAO
{
    function __construct()
    {
        $this->table = 'users';
        $this->connection = new PDO('mysql:host=localhost;dbname=demo', 'root', '');
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function fetchAll()
    {
        try {
            $statement = $this->connection->prepare("SELECT * FROM {$this->table}");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $this->createAll($result);
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }

    function fetch($id)
    {
        try {
            $statement = $this->connection->prepare("SELECT * FROM {$this->table} WHERE pk = ?");
            $statement->execute([
                $id
            ]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $this->create($result);
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }

    function createAll($results)
    {
        $productList = array();
        foreach ($results as $result) {
            array_push($productList, $this->create($result));
        }
        return $productList;
    }

    function create($result)
    {
        return new Product(
            $result['pk'],
            $result['name'],
            $result['password']
        );
    }

    function store($data)
    {
        var_dump($data);
        if (empty($data['name']) || empty($data['password'])) {
            return false;
        }

        $product = $this->create(['pk' => 0, 'name' => $data['name'], 'password' => $data['password']]);

        if ($product) {
            try {
                $statement = $this->connection->prepare(
                    "INSERT INTO {$this->table} (name, password) VALUES (?, ?)"
                );
                $statement->execute([
                    htmlspecialchars($product->__get('name')),
                    htmlspecialchars($product->__get('password'))
                ]);
            } catch (PDOException $e) {
                print $e->getMessage();
            }
        }
    }

    function delete($data)
    {
        if (empty($data['id'])) {
            return false;
        }

        try {
            $statement = $this->connection->prepare("DELETE FROM {$this->table} WHERE pk = ?");
            $statement->execute([
                $data['id']
            ]);
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }

    function update($data)
    {
        if (empty($data['id'])) {
            return false;
        }

        try {
            $statement = $this->connection->prepare("UPDATE {$this->table} SET name = ?, price = ? WHERE pk = ?");
            $statement->execute([
                htmlspecialchars($data['name']),
                htmlspecialchars($data['password']),
                htmlspecialchars($data['id'])
            ]);
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }
}