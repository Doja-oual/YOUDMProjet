<?php
namespace App\Models;
use App\Models\User;
use Config\Database;
use PDOException;

class UserRepository {
    private static function getConnection() {
        return Database::getConnection();
    }

    // Enregistrer un nouvel utilisateur
    public static function register($username, $email, $password, $role_id = User::ROLE_ETUDIANT) {
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

    // Connexion d'un utilisateur
    public static function login($email, $password) {
        $conn = self::getConnection();
        $sql = "SELECT * FROM Utilisateur WHERE email = :email";
        
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute(['email' => $email]);
            $userData = $stmt->fetch(\PDO::FETCH_ASSOC);
        
            if ($userData && password_verify($password, $userData['mot_de_passe'])) {
                // Créer une instance de la classe appropriée en fonction du rôle
                switch ($userData['role_id']) {
                    case User::ROLE_ETUDIANT:
                        return new Student(
                            $userData['id'],
                            $userData['nom'],
                            $userData['email'],
                            $userData['mot_de_passe'],
                            $userData['role_id'],
                            $userData['date_inscription'],
                            $userData['photo_profil'],
                            $userData['bio'],
                            $userData['pays'],
                            $userData['langue_id'],
                            $userData['statut_id']
                        );
                    case User::ROLE_ENSEIGNANT:
                        return new Teacher(
                            $userData['id'],
                            $userData['nom'],
                            $userData['email'],
                            $userData['mot_de_passe'],
                            $userData['role_id'],
                            $userData['date_inscription'],
                            $userData['photo_profil'],
                            $userData['bio'],
                            $userData['pays'],
                            $userData['langue_id'],
                            $userData['statut_id']
                        );
                    case User::ROLE_ADMIN:
                        return new Admin(
                            $userData['id'],
                            $userData['nom'],
                            $userData['email'],
                            $userData['mot_de_passe'],
                            $userData['role_id'],
                            $userData['date_inscription'],
                            $userData['photo_profil'],
                            $userData['bio'],
                            $userData['pays'],
                            $userData['langue_id'],
                            $userData['statut_id']
                        );
                    default:
                        return null; // Rôle inconnu
                }
            }
        
            return null; // Mot de passe incorrect ou utilisateur non trouvé
        } catch (PDOException $e) {
            error_log("Erreur lors de la connexion : " . $e->getMessage());
            return null;
        }
    }
    // Vérifier si un e-mail existe
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
    // totalstudents
    public static function getTotalStudents() {
        $conn = Database::getConnection();
        $sql = "SELECT COUNT(*) AS total FROM Utilisateur WHERE role_id = :role_id";
        
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute(['role_id' => User::ROLE_ETUDIANT]);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération du nombre total d'étudiants : " . $e->getMessage());
            return 0; // Retourne 0 en cas d'erreur
        }
    }
    // total teachers 
    public static function getTotalTeachers() {
        $conn = Database::getConnection();
        $sql = "SELECT COUNT(*) AS total FROM Utilisateur WHERE role_id = :role_id";
        
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute(['role_id' => User::ROLE_ENSEIGNANT]);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération du nombre total d'enseignants : " . $e->getMessage());
            return 0; // Retourne 0 en cas d'erreur
        }
    }

    // Récupérer tous les utilisateurs
    public static function getAllUsers() {
        $conn = self::getConnection();
        $sql = "SELECT * FROM Utilisateur";
        
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des utilisateurs : " . $e->getMessage());
            return false;
        }
    }

    // Récupérer un utilisateur par son ID
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

    // Mettre à jour un utilisateur
    public static function updateUser($id, $data) {
        $conn = self::getConnection();
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

    // Supprimer un utilisateur
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

    // Récupérer les cours suivis par un étudiant
    public static function getEnrolledCourses($userId) {
        $conn = self::getConnection();
        $sql = "SELECT c.* FROM Cours c
                JOIN Inscription i ON c.id = i.cours_id
                WHERE i.etudiant_id = :user_id";
        
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute(['user_id' => $userId]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des cours suivis : " . $e->getMessage());
            return false;
        }
    }

    // Récupérer les cours enseignés par un enseignant
    public static function getTaughtCourses($teacherId) {
        $conn = self::getConnection();
        $sql = "SELECT * FROM Cours WHERE enseignant_id = :enseignant_id";
        
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute(['enseignant_id' => $teacherId]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des cours enseignés : " . $e->getMessage());
            return false;
        }
    }

    // Récupérer les statistiques globales
    public static function getGlobalStatistics() {
        $conn = self::getConnection();
        $sql = "SELECT 
                (SELECT COUNT(*) FROM Utilisateur) AS total_users,
                (SELECT COUNT(*) FROM Cours) AS total_courses,
                (SELECT COUNT(*) FROM Inscription) AS total_enrollments";
        
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des statistiques : " . $e->getMessage());
            return false;
        }
    }

    // Récupérer les cours les plus populaires
    public static function getMostPopularCourses($limit = 5) {
        $conn = self::getConnection();
        $sql = "SELECT c.*, COUNT(i.etudiant_id) AS enrollments 
                FROM Cours c
                LEFT JOIN Inscription i ON c.id = i.cours_id
                GROUP BY c.id
                ORDER BY enrollments DESC
                LIMIT :limit";
        
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des cours populaires : " . $e->getMessage());
            return false;
        }
    }
//Active un utilisateur (valide un compte enseignant).
    public static function activateUser($userId) {
        $conn = self::getConnection();
        $sql = "UPDATE Utilisateur SET statut_id = :statut_id WHERE id = :id";
        $stmt = $conn->prepare($sql);
    
        try {
            return $stmt->execute(['statut_id' => User::STATUS_ACTIVE, 'id' => $userId]);
        } catch (PDOException $e) {
            error_log("Erreur lors de l'activation de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }
    // Suspend un utilisateur
    
    public static function suspendUser($userId) {
        $conn = self::getConnection();
        $sql = "UPDATE Utilisateur SET statut_id = :statut_id WHERE id = :id";
        $stmt = $conn->prepare($sql);
    
        try {
            return $stmt->execute(['statut_id' => User::STATUS_SUSPENDED, 'id' => $userId]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la suspension de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }
    //Récupère les utilisateurs par rôle et statut.
    public static function getUsersByRoleAndStatus($roleId, $statusId) {
        $conn = self::getConnection();
        $sql = "SELECT * FROM Utilisateur WHERE role_id = :role_id AND statut_id = :statut_id";
        $stmt = $conn->prepare($sql);
    
        try {
            $stmt->execute(['role_id' => $roleId, 'statut_id' => $statusId]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des utilisateurs par rôle et statut : " . $e->getMessage());
            return false;
        }
    }
    //REcupere les meilleurs enseignants.
    public static function getTopTeachers($limit) {
        $conn = self::getConnection();
        $sql = "
            SELECT Utilisateur.*, COUNT(Cours.id) AS total_courses
            FROM Utilisateur
            LEFT JOIN Cours ON Utilisateur.id = Cours.enseignant_id
            WHERE Utilisateur.role_id = :role_id
            GROUP BY Utilisateur.id
            ORDER BY total_courses DESC
            LIMIT :limit;
        ";
        $stmt = $conn->prepare($sql);
    
        try {
            $stmt->execute(['role_id' => User::ROLE_ENSEIGNANT, 'limit' => $limit]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des meilleurs enseignants : " . $e->getMessage());
            return false;
        }
    }

}