<?php

namespace App\Models;

use Config\Database;
use PDOException;

class CertificatRepository{
    private static function getConnection() {
        return Database::getConnection();
    }

    // recuperer les cirtificats d'un etudiant

    public static function  getCertificatresByStudent($studentId){
        $conn = self::getConnection();
        $sql="SELECT *FROM Certificat WHERE etudiant_id=:etudiant_id";

        try{
            $stmt = $conn->prepare($sql);
            $stmt->execute(['etudiant_id' => $studentId]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des certificats : " . $e->getMessage());
            return false;
        }
    
    }
}