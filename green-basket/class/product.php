<?php
class Product{
private PDO $pdo;
public function __construct(PDO $pdo){
    $this->pdo=$pdo;
}
public function getAll():array{
$value='select*from products'; 
$product=$this->pdo->query($value)->fetchAll();
return $product;
}

public function getById($id){
$value='select*from products where id=?'; 
$product_value=$this->pdo->prepare($value);
$product_value->execute([$id]);
$product=$product_value->fetch();
return $product;
}

public function create($name,$description,$price,$stock,$category_id,$image){
$value = 'INSERT INTO products (name, description, price, stock, category_id, image) VALUES (?, ?, ?, ?, ?, ?)';
$product_value=$this->pdo->prepare($value);
return $product_value->execute([$name,$description,$price,$stock,$category_id,$image]);
}
public function update($id,$name,$description,$price,$stock,$category_id,$image){
$value = 'UPDATE products SET name = ?, description = ?, price = ?, stock = ?, category_id = ?, image = ? WHERE id = ?';
$product_value=$this->pdo->prepare($value);
return $product_value->execute([$name, $description, $price, $stock, $category_id, $image, $id]);
}

public function delete($id){
$value='delete from products where id=?'; 
$product_value=$this->pdo->prepare($value);
return $product_value->execute([$id]);
}
}

?>