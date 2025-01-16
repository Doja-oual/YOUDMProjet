<?php


namespace App\Core;
require_once __DIR__ .'/../vendor/autoload.php';
use Config\Database;


class Model{
    private $conn;
    private $table;


    public static function show($table){
        $coon=Database::getConnection();
        $sql="SELECT * FROM $table";
        $query->prepare($sql);
        $query->execute();
        return$query->fetchAll(\PDO::FETCH_ASSOC);
    }

  public static function add($table){
    $conn=Database::getConnection();
    $columns = implode(",",array_keys($data));
    $values=":" . implode(", :",array_keys($data));
    $sql="INSERT INTO $table($columns) VALUES ($values)";
    $stmt=$conn->prepare($sql);

    foreach($data as $key =>$value){
      $stmt->binValue(":$key",$value);} return $stmt->execute();
  }

  public static function update($table,$id,$data){
    $conn=Database::getConnection();
    $fields = "";
    foreach ($data as $key => $value) {
        $fields .= "$key = :$key, ";
    }
    $fields = rtrim($fields, ", ");
    $sql = "UPDATE $table SET $fields WHERE id = :id";

    $stmt = $conn->prepare($sql);
    foreach ($data as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }
    $stmt->bindValue(':id', $id);

    return $stmt->execute();

  }

  public static function delete($table,$id){
    $conn=Database::getConnection();
    $sql = "DELETE FROM $table WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id);
    return $stmt->execute();
}
  }




