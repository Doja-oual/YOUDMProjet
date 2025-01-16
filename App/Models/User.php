<?php
namespace App\Models;

use Config\Database;

class UserModel {
    private static function getConnection() {
        return Database::getConnection();
    }
    
    public static function getAllUsers() {
        $conn = self::getConnection();
        $sql = "SELECT id, username, email, role, bio, profile_picture_url FROM users";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public static function addUser($data) {
        $conn = self::getConnection();
    
        // Hacher le mot de passe avant de l'insérer
        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
    
        // Requête SQL pour insérer l'utilisateur
        $sql = "INSERT INTO users (username, email, password_hash, role, bio, profile_picture_url) 
                VALUES (:username, :email, :password_hash, :role, :bio, :profile_picture_url)";
        
        $stmt = $conn->prepare($sql);
        
        return $stmt->execute([
            'username' => $data['username'],
            'email' => $data['email'],
            'password_hash' => $passwordHash, // Mot de passe hashé
            'role' => $data['role'] ?? 'user', // Rôle par défaut : 'user'
            'bio' => $data['bio'] ?? null,
            'profile_picture_url' => $data['profile_picture_url'] ?? null
        ]);
    }
    
    public static function updateUser($id, $data) {
        $conn = self::getConnection();
        $sql = "UPDATE users SET 
                username = :username,
                email = :email,
                bio = :bio,
                role = :role,
                profile_picture_url = :profile_picture_url
                WHERE id = :id";
                
        $stmt = $conn->prepare($sql);
        
        return $stmt->execute([
            'username' => $data['username'],
            'email' => $data['email'],
            'bio' => $data['bio'] ?? null,
            'role' => $data['role'] ?? 'user',
            'profile_picture_url' => $data['profile_picture_url'] ?? null,
            'id' => $id
        ]);
    }
    
    public static function deleteUser($id) {
        $conn = self::getConnection();
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    
    public static function getUserById($id) {
        $conn = self::getConnection();
        $sql = "SELECT id, username, email, role, bio, profile_picture_url FROM users WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    //  enregistrer un nouvel utilisateur
    public static function register($username, $email, $password) {
        $conn = self::getConnection();
        $sql = "INSERT INTO users (username, email, password_hash, role) 
                VALUES (:username, :email, :password_hash, 'user')";
        
        $stmt = $conn->prepare($sql);
        
        return $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }

    //  pour verifie deja mmeme email
    public static function emailExists($email) {
        $conn = self::getConnection();
        $sql = "SELECT id FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC) !== false;
    }


  

    public static function login($email, $password) {
        $conn = self::getConnection();
    
        // Récupérer l'utilisateur par email
        $sql = "SELECT id, username, email, password_hash, role FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        // Vérifier le mot de passe
        if ($user && password_verify($password, $user['password_hash'])) {
            // Retourner les informations de l'utilisateur (sans le mot de passe)
            unset($user['password_hash']);
            return $user;
        }
    
        return false; // Échec de la connexion
    }
}