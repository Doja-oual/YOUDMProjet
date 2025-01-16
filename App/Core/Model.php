<?php


namespace App\Core;
require_once __DIR__ .'/../../vendor/autoload.php';
use Config\Database;


class Model{
    private $conn;
    private $table;


    public static function all($table){
        $conn=Database::getConnection();
        $sql="SELECT * FROM $table";
        $query=$conn->prepare($sql);
        $query->execute();
        return  $result=$query->fetchAll(\PDO::FETCH_ASSOC);
        var_dump($result);
    }

    public static function find($table, $id){
        $conn=Database::getConnection();
        $sql="SELECT * FROM $table WHERE id= :id" ;
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Erreur SQL: " . $e->getMessage();
            return null;
        }    }

    public  static function add($table,$data) {
        $conn=Database::getConnection();
        echo "<br>";
        $columns = implode(",",array_keys($data));
        $values = ":" . implode(", :", array_keys($data));  
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $stmt = $conn->prepare($sql);
    
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value); }
        return $stmt->execute();
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




