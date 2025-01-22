<?php

namespace App\Models;

use Config\Database;
use PDOException;

class CertificatRepository{
    private static function getConnection() {
        return Database::getConnection();
    }

    // recuperer les cirtificats d'un etudiant

    public static function  addCirtificat($studentId, $courseId){
        $conn=self::getConnection();
        $sql="INSERT INTO Certificat(etudiant_id,cours_id) 
        VALUES (:etudiant_id,:cours_id)";
        try{
            $stmt = $conn->prepare($sql);
            return $stmt->execute([
                'etudiant_id' => $studentId,
                'cours_id' => $courseId,
            ]);
                    }catch (PDOException $e) {
                        error_log("Erreur lors de l'ajout de cirtificat : " . $e->getMessage());
                        return false;

                    }
    }
    public static function getCertificatresByStudent($studentId) {
        $conn = self::getConnection();
        $sql = "SELECT * FROM Certificat WHERE etudiant_id = :etudiant_id";
    
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute(['etudiant_id' => $studentId]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des certificats : " . $e->getMessage());
            return false;
        }
    }
    // methode affichie cirtif de etudiant 
    public static function getCertificatsWithDetailsByStudent($studentId,$courseId) {
        $conn = self::getConnection();
        $sql = "SELECT 
                    Certificat.id AS certificat_id,
                    Certificat.date_emission,
                    Utilisateur.nom AS etudiant_nom,
                    Cours.titre AS cours_titre
                FROM Certificat
                JOIN Utilisateur ON Certificat.etudiant_id = Utilisateur.id
                JOIN Cours ON Certificat.cours_id = Cours.id
                WHERE Certificat.etudiant_id = :etudiant_id  and Certificat.cours_id=:cours_id "  ;
    
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'etudiant_id' => $studentId,
                'cours_id' => $courseId,
            
            ] );
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des certificats : " . $e->getMessage());
            return false;
        }
    }
}