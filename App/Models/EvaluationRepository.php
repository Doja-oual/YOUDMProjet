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
    public static function getAllEvaluations() {
        // Connexion à la base de données
        $conn = self::getConnection();
    
        // Requête SQL pour récupérer toutes les évaluations
        $sql = "SELECT * FROM Evaluation";
    
        try {
            // Préparation et exécution de la requête
            $stmt = $conn->prepare($sql);
            $stmt->execute();
    
            // Retourner toutes les évaluations sous forme de tableau associatif
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Journaliser l'erreur et retourner false en cas d'échec
            error_log("Erreur lors de la récupération de toutes les évaluations : " . $e->getMessage());
            return false;
        }
    }
    } 
