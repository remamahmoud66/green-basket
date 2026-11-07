<?php
class Category{
private PDO $pdo;
public function __construct(PDO $pdo){
    $this->pdo=$pdo;
}
public function getAll():array{
$value='select*from categories'; 
$category=$this->pdo->query($value)->fetchAll();
return $category;
}

public function getById($id){
$value='select*from categories where id=?'; 
$category_value=$this->pdo->prepare($value);
$category_value->execute([$id]);
$category=$category_value->fetch();
return $category;
}

public function create($name,$description,$image){
$value = 'INSERT INTO categories (name, description, image) VALUES (?, ?, ?)';
$category_value=$this->pdo->prepare($value);
return $category_value->execute([$name,$description,$image]);
}
public function update($id,$name,$description,$image){
$value = 'UPDATE categories SET name = ?, description = ?, image = ? WHERE id = ?';
$category_value=$this->pdo->prepare($value);
return $category_value->execute([$name, $description, $image, $id]);
}

public function delete($id){
$value='delete from categories where id=?'; 
$category_value=$this->pdo->prepare($value);
return $category_value->execute([$id]);
}
}

?>