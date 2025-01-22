<?php
namespace App\Models;

use Config\Database;
use PDOException;
 

class EvaluationRepository {
    private static function getConnection(){
        return Database::getConnection();
    }

    public static function  addEvaluation($studentId, $courseId, $rating, $comment){
        $conn=self::getConnection();
        $sql="INSERT INTO Evaluation(etudiant_id,cours_id,note,commentaire) 
        VALUES (:etudiant_id,:cours_id,:note,:commentaire)";
        // var_dump($studentId, $courseId, $rating, $comment);
        try{
            $stmt = $conn->prepare($sql);
            return $stmt->execute([
                'etudiant_id' => $studentId,
                'cours_id' => $courseId,
                'note' => $rating,
                'commentaire' => $comment,
            ]);
                    }catch (PDOException $e) {
                        error_log("Erreur lors de l'ajout de l'évaluation : " . $e->getMessage());
                        return false;

                    }
    }

    // recuper les evaluation d'un etudiant
    public static function getEvaluationsByStudent($studentId){
        $conn = self::getConnection();
        $sql = "SELECT * FROM Evaluation WHERE etudiant_id = :etudiant_id";
        
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute(['etudiant_id' => $studentId]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des évaluations : " . $e->getMessage());
            return false;
        }
    }
    } 
