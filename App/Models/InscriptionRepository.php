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

}