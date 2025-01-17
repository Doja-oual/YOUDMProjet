<?php
namespace App\Models;

use Config\Database;

class UserModel {
    private static function getConnection() {
        return Database::getConnection();
    }
    
    public static function getAllUsers() {
        $conn = self::getConnection();
        $sql = "SELECT * FROM users";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public static function addUser($data) {
        $conn = self::getConnection();
    
        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
    
        $sql = "INSERT INTO Utilisateur (nom, email, mot_de_passe, role_id, date_inscription, photo_profil,bio,pays,langue_id,statut_id) 
                VALUES (:nom, :email, :mot_de_passe, :role_id, :date_inscription, :photo_profil,:bio,:bio,:pays,:langue_id,:statut_id)";
        
        $stmt = $conn->prepare($sql);
        
        return $stmt->execute([
            'nom' => $data['nom'],
            'email' => $data['email'],
            'mot_de_passe' => $mot_de_passe, 
            'role_id' => $data['role_id'] ?? 'user',
            'date_inscription' => $data['date_inscription'] ,
            'photo_profil' => $data['photo_profil'] ,
            'bio' => $data['bio'] ,        
                'pays' => $data['pays'] ,
            'langue_id' => $data['langue_id'] ,
            'statut_id' => $data['statut_id'] ,



        ]);
    }
    
    public static function updateUser($id, $data) {
        $conn = self::getConnection();
        $sql = "UPDATE Utilisateur SET 
                nom = :nom,
                email = :email,
                bio = :bio,
                date_inscription = :date_inscription,
                photo_profil = :photo_profil
                bio= :bio,
                pays= :pays,
                langue_id=:langue_id,
                statut_id=:statut_id
                WHERE id = :id";
                
        $stmt = $conn->prepare($sql);
        
        return $stmt->execute([
            'nom' => $data['nom'],
            'email' => $data['email'],
            'mot_de_passe' => $mot_de_passe, 
            'role_id' => $data['role_id'] ?? 'user',
            'date_inscription' => $data['date_inscription'] ,
            'photo_profil' => $data['photo_profil'] ,
            'bio' => $data['bio'] ,        
            'pays' => $data['pays'] ,
            'langue_id' => $data['langue_id'] ,
            'statut_id' => $data['statut_id'] ,
            'id' => $id
        ]);
    }
    
    public static function deleteUser($id) {
        $conn = self::getConnection();
        $sql = "DELETE FROM Utilisateur WHERE id = :id";
        $stmt = $conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    
    public static function getUserById($id) {
        $conn = self::getConnection();
        $sql = "SELECT * FROM Utilisateur WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

//     //  enregistrer un nouvel utilisateur
//     public static function register($username, $email, $password) {
//         $conn = self::getConnection();
//         $sql = "INSERT INTO Utilisateur (nom, email, mot_de_passe, role_id, date_inscription, photo_profil,bio,pays,langue_id,statut_id) 
//                 VALUES (:nom, :email, :mot_de_passe, :role_id, :date_inscription, :photo_profil,:bio,:bio,:pays,:langue_id,:statut_id)";
        
//         $stmt = $conn->prepare($sql);
        
//         return $stmt->execute([
//             'username' => $username,
//             'email' => $email,
//             'password_hash' => password_hash($password, PASSWORD_DEFAULT)
//         ]);
//     }

//     //  pour verifie deja mmeme email
//     public static function emailExists($email) {
//         $conn = self::getConnection();
//         $sql = "SELECT id FROM Utilisateur WHERE email = :email";
//         $stmt = $conn->prepare($sql);
//         $stmt->execute(['email' => $email]);
//         return $stmt->fetch(\PDO::FETCH_ASSOC) !== false;
//     }


  

//     public static function login($email, $password) {
//         $conn = self::getConnection();
    
//         // Récupérer l'utilisateur par email
//         $sql = "SELECT * FROM Utilisateur WHERE email = :email";
//         $stmt = $conn->prepare($sql);
//         $stmt->execute(['email' => $email]);
//         $user = $stmt->fetch(\PDO::FETCH_ASSOC);
    
//         // Vérifier le mot de passe
//         if ($user && password_verify($password, $user['mot_de_passe'])) {
//             // Retourner les informations de l'utilisateur (sans le mot de passe)
//             unset($user['mot_de_passe']);
//             return $user;
//         }
    
//         return false; // Échec de la connexion
//     }
 }