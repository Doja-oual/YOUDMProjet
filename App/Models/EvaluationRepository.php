<?php
namespace App\Models;

use Config\Database;
use PDOException;
 

class EvaluationRepository {
    private static function getConnection(){
        return Database::getConnection();
    }

    public static function  addEvaluation($studentId,$coursId,$note,$comentaire){
        $conn=self::getConnection();
        $sql="INSERT INTO Evaluation(etudiant_id,cours_id,note,commentaire) 
        VALUES (:etudiant_id,:cours_id,:note,commentaire)";

        try{
            $stmt = $conn->prepare($sql);
            return $stmt->execute([
                'etudiant_id' => $studentId,
                'cours_id' => $courseId,
                'note' => $note,
                'commentaire' => $commentaire,
            ]);
                    }catch (PDOException $e) {
                        error_log("Erreur lors de l'ajout de l'évaluation : " . $e->getMessage());
                        return false;

                    }
    }

    
}