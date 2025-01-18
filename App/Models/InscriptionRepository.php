<?php

namespace App\Models;

use Config\Database;
use PDOException;

class InscriptionRepository{
 private static function getConnection(){
    return Database::getConnection();
 }

 //ajoute inscription

 public static function addInscription(){
    $conn = self::getConnection();
    $sql= "INSERT INTO Inscription(etudiant_id,cours_id) VALUE (:etudiant_id ,:cours_id)";
    try{
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'etudiant_id'=>$studentId,
            'cours_id'=>$courseId,
        ]);

    } catch(PDOException $e){
        error_log("Erreur lors de l'ajoute de l'inscription :" .$e->getMessage());
return false;


    }

 }

 // verifie que deja inscrite

 public static function isInscrit($studentId,$courseId){
    $conn=  self::getConnection();
    $sql="SELECT *FROM Inscription WHERE etudiant_id=: etudiant_id AND cours_id=:cours_id";
    try{
        $stmt=$conn->prepare($sql);
        stmt->execute([
            'etudiant_id'=>$studentId,
            'cours_id'=>$courseId,
        ]);

    }catch(PDOException $e){
        error_log("Erreur lors de la verification de l'inscription :" . $e->getMessage());
        return false;
    }

 }


 

}