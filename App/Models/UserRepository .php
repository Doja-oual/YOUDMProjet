<?php
namespace App\Models;

use Config\Database;
use PDOException;

class UserRepository  {
    // Constantes pour les rôles
    const ROLE_ETUDIANT = 1;
    const ROLE_ENSEIGNANT = 2;
    const ROLE_ADMIN = 3;

    private static function getConnection() {
        return Database::getConnection();
    }
    
    public static function getAllUsers() {
        $conn = self::getConnection();
        $sql = "SELECT * FROM Utilisateur";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public static function addUser($data) {
        $conn = self::getConnection();
    
        // Hacher le mot de passe
        $passwordHash = password_hash($data['mot_de_passe'], PASSWORD_DEFAULT);
    
        $sql = "INSERT INTO Utilisateur (nom, email, mot_de_passe, role_id) 
                VALUES (:nom, :email, :mot_de_passe, :role_id)";
        
        try {
            $stmt = $conn->prepare($sql);
            return $stmt->execute([
                'nom' => $data['nom'],
                'email' => $data['email'],
                'mot_de_passe' => $passwordHash,
                'role_id' => $data['role_id'] ?? self::ROLE_ETUDIANT, // Rôle par défaut
            ]);
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }
    
    public static function updateUser($id, $data) {
        $conn = self::getConnection();

        // Hacher le mot de passe si fourni
        if (isset($data['mot_de_passe'])) {
            $data['mot_de_passe'] = password_hash($data['mot_de_passe'], PASSWORD_DEFAULT);
        }

        $sql = "UPDATE Utilisateur SET 
                nom = :nom,
                email = :email,
                mot_de_passe = :mot_de_passe,
                bio = :bio,
                date_inscription = :date_inscription,
                photo_profil = :photo_profil,
                pays = :pays,
                langue_id = :langue_id,
                statut_id = :statut_id
                WHERE id = :id";
        
        try {
            $stmt = $conn->prepare($sql);
            return $stmt->execute([
                'nom' => $data['nom'],
                'email' => $data['email'],
                'mot_de_passe' => $data['mot_de_passe'] ?? null,
                'bio' => $data['bio'] ?? null,
                'date_inscription' => $data['date_inscription'] ?? null,
                'photo_profil' => $data['photo_profil'] ?? null,
                'pays' => $data['pays'] ?? null,
                'langue_id' => $data['langue_id'] ?? null,
                'statut_id' => $data['statut_id'] ?? null,
                'id' => $id
            ]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }
    
    public static function deleteUser($id) {
        $conn = self::getConnection();
        $sql = "DELETE FROM Utilisateur WHERE id = :id";
        
        try {
            $stmt = $conn->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }
    
    public static function getUserById($id) {
        $conn = self::getConnection();
        $sql = "SELECT * FROM Utilisateur WHERE id = :id";
        
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }

    public static function register($username, $email, $password, $role_id = self::ROLE_ETUDIANT) {
        $conn = self::getConnection();
        $sql = "INSERT INTO Utilisateur (nom, email, mot_de_passe, role_id) 
                VALUES (:nom, :email, :mot_de_passe, :role_id)";
        
        try {
            $stmt = $conn->prepare($sql);
            return $stmt->execute([
                'nom' => $username,
                'email' => $email,
                'mot_de_passe' => password_hash($password, PASSWORD_DEFAULT),
                'role_id' => $role_id,
            ]);
        } catch (PDOException $e) {
            error_log("Erreur lors de l'enregistrement de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }

    public static function emailExists($email) {
        $conn = self::getConnection();
        $sql = "SELECT id FROM Utilisateur WHERE email = :email";
        
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute(['email' => $email]);
            return $stmt->fetch(\PDO::FETCH_ASSOC) !== false;
        } catch (PDOException $e) {
            error_log("Erreur lors de la vérification de l'e-mail : " . $e->getMessage());
            return false;
        }
    }

    public static function login($email, $password) {
        $conn = self::getConnection();
        $sql = "SELECT * FROM Utilisateur WHERE email = :email";
        
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        
            if ($user && password_verify($password, $user['mot_de_passe'])) {
                unset($user['mot_de_passe']);
                return $user;
            }
        
            return false;
        } catch (PDOException $e) {
            error_log("Erreur lors de la connexion : " . $e->getMessage());
            return false;
        }
    }
}