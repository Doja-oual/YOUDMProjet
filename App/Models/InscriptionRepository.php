<?php

namespace App\Models;

use Config\Database;
use PDOException;

class InscriptionRepository{
 private static function getConnection(){
    return Database::getConnection();
 }

 //ajoute inscription

 public static function addInscription($studentId, $courseId){
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

 public static function isInscritCours($studentId,$courseId){
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

// Recupere  les cours suivis par un etudiant

public static function getInscritCourse($studentId){
    $conn=  self::getConnection();
    $sql="SELECT c.* FROM Cours c
    JOIN Inscription i ON c.id= i.cours_id
    WHERE i.etudiant_id=:etudiant_id";
    
    try{
        $stmt=$conn->prepare($sql);
        $stmt->execute(['etudiant_id'=>$studentId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }catch(PDOException $e){
        error_log("Erreur lors de la recuperaation des cours suivis :" . $e->getMessage());
            return false;
    }


}
/// course qui termine 
public static function getCompletedCourses($studentId,$courseId) {
    $conn = self::getConnection();
    $sql = "UPDATE Inscription SET progress = 100 WHERE etudiant_id = :etudiant_id AND cours_id = :cours_id";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'etudiant_id' => $studentId,
            'cours_id' => $courseId
        ]);
        return true;
    } catch (PDOException $e) {
        error_log("Erreur lors de la mise à jour du cours comme terminé : " . $e->getMessage());
        return false;

}
}
}