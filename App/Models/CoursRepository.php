<?php
namespace App\Models;
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Core\Model;
use Config\Database;

class CoursRepository extends Model {
    public static function getConnection(){
        return  Database::getConnection();
    }
    protected $table = 'Cours';
    protected $fillable = [
        'titre', 'description', 'contenu', 'type_contenu', 'enseignant_id', 
        'categorie_id', 'niveau', 'duree', 'prix', 'langue_id', 'statut_id'
    ];

    protected $contentHandlers = [];



    public function __construct() {
        $this->conn = Database::getConnection();
        $this->contentHandlers = [
            'texte' => function($contenu) {
                return "<p>$contenu</p>";
            },
            'video' => function($contenu) {
                return "<video controls><source src='$contenu' type='video/mp4'></video>";
            },
            'image' => function($contenu) {
                return "<img src='$contenu' alt='Image du cours'>";
            }
        ];
    }

    public function createCourse($data) {
        return parent::add($this->table,$data);
    }

    // recupere les nombre des course par moin
    public static function getCoursesByMonth() {
        $conn = Database::getConnection();
        $sql = "SELECT MONTH(date_creation) AS month, COUNT(*) AS total 
                FROM Cours 
                GROUP BY MONTH(date_creation)";
        $stmt = $conn->prepare($sql);
    
        try {
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des cours par mois : " . $e->getMessage());
            return [];
        }
    }
    // ajoute methode de calcule totale de course
    public static function getTotalCourses() {
        $conn = Database::getConnection();
        $sql = "SELECT COUNT(*) AS total FROM Cours";
        
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération du nombre total de cours : " . $e->getMessage());
            return 0; 
        }}

    public function getAllCourses() {
        $conn = self::getConnection();
        $sql = "
            SELECT 
                Cours.*,
                Categorie.nom AS categorie_nom,
                GROUP_CONCAT(Tag.nom SEPARATOR ', ') AS tags
            FROM Cours
            LEFT JOIN Categorie ON Cours.categorie_id = Categorie.id
            LEFT JOIN CoursTag ON Cours.id = CoursTag.cours_id
            LEFT JOIN Tag ON CoursTag.tag_id = Tag.id
            GROUP BY Cours.id;
        ";
        $stmt = $conn->prepare($sql);
    
        try {
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des cours : " . $e->getMessage());
            return false;
        }
    }
    // ajoute methode qui recupere course avec nome et techer
    public function getCoursesWithTeacherInfo() {
        $conn = self::getConnection();
        $sql = "
            SELECT 
                Cours.titre AS cours_titre,
                Cours.date_creation AS cours_date_creation,
                Utilisateur.nom AS enseignant_nom
            FROM Cours
            LEFT JOIN Utilisateur ON Cours.enseignant_id = Utilisateur.id
        ";
        $stmt = $conn->prepare($sql);
    
        try {
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des cours avec les informations de l'enseignant : " . $e->getMessage());
            return false;
        }
    }

    public function getCourseById($id) {
        return parent::find($this->table,$id);
    }

    public function updateCourse($id, $data) {
        return parent::update($this->id, $data);
    }

    public function deleteCourse($id) {
        return parent:: delete($this->$id);
    }

    public function handleContent($type_contenu, $contenu) {
        if (!isset($this->contentHandlers[$type_contenu])) {
            throw new \Exception("Type de contenu non supporte.");
        }
        return $this->contentHandlers[$type_contenu]($contenu);
    }

//Ajoute les tags a course
    public static function addTagToCours($CoursId,$tagId){
        $conn=self::getConnection();
        $sql="INSERT INTO CoursTag (cours_id,tag_id) VALUES (:cours_id,:tag_id)";
        $stmt=$conn->prepare($sql);
        foreach($tagId as $tagsId)
        $stmt->execute(['cours_id'=>CoursId,'tag_id'=>$tagId]);
    }

    // Recupere tags d'un cours
    public static function getTagForCours($CourId){
        $conn=self::getConnection();
        $sql="SELECT * FROM Tag 
        JOIN CoursTag ON Tag.id=CoursTag.tag_id
        WHERE CoursTag.cours_id=:cours_id";
        $stmt=$conn->prepare($sql);
        $stmt->execute(['cours_id'=>$CourId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
    }

    //Recupere les cours par teacher 
    public static function getCoursesByTeacher($teacherId) {
        $conn = self::getConnection();
        $sql = "SELECT * FROM Cours WHERE enseignant_id = :enseignant_id";
        $stmt = $conn->prepare($sql);
    
        try {
            $stmt->execute(['enseignant_id' => $teacherId]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des cours de l'enseignant : " . $e->getMessage());
            return false;
        }
    }
    // recupere par categorie
    public static function getCoursesByCategory($categoryId) {
        $conn = self::getConnection();
        $sql = "SELECT * FROM Cours WHERE categorie_id = :categorie_id";
        $stmt = $conn->prepare($sql);
    
        try {
            $stmt->execute(['categorie_id' => $categoryId]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des cours par catégorie : " . $e->getMessage());
            return false;
        }
    }
    // cours plus inscription
    public static function getMostPopularCourses($limit = 5) {
        $conn = self::getConnection();
        $sql = "
            SELECT Cours.*, COUNT(Inscription.etudiant_id) AS total_inscriptions
            FROM Cours
            LEFT JOIN Inscription ON Cours.id = Inscription.cours_id
            GROUP BY Cours.id
            ORDER BY total_inscriptions DESC
            LIMIT :limit;
        ";
        $stmt = $conn->prepare($sql);
    
        try {
            $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des cours populaires : " . $e->getMessage());
            return false;
        }
    }
    // recupere les statistique d'un cours
    public static function getCourseStatistics($courseId) {
        $conn = self::getConnection();
        $sql = "
            SELECT 
                COUNT(Inscription.etudiant_id) AS total_inscriptions,
                AVG(Evaluation.note) AS moyenne_notes
            FROM Cours
            LEFT JOIN Inscription ON Cours.id = Inscription.cours_id
            LEFT JOIN Evaluation ON Cours.id = Evaluation.cours_id
            WHERE Cours.id = :course_id;
        ";
        $stmt = $conn->prepare($sql);
    
        try {
            $stmt->execute(['course_id' => $courseId]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des statistiques du cours : " . $e->getMessage());
            return false;
        }
    }
    // supreme un tage d'un cours 
    public static function removeTagFromCours($coursId, $tagId) {
        $conn = self::getConnection();
        $sql = "DELETE FROM CoursTag WHERE cours_id = :cours_id AND tag_id = :tag_id";
        $stmt = $conn->prepare($sql);
    
        try {
            $stmt->execute(['cours_id' => $coursId, 'tag_id' => $tagId]);
            return true;
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression du tag du cours : " . $e->getMessage());
            return false;
        }
    }
    // recupere tou tout les cours avec tag et catrgory
    public static function getAllCoursesWithDetails() {
        $conn = self::getConnection();
        $sql = "
            SELECT 
                Cours.*,
                Categorie.nom AS categorie_nom,
                GROUP_CONCAT(Tag.nom SEPARATOR ', ') AS tags
            FROM Cours
            LEFT JOIN Categorie ON Cours.categorie_id = Categorie.id
            LEFT JOIN CoursTag ON Cours.id = CoursTag.cours_id
            LEFT JOIN Tag ON CoursTag.tag_id = Tag.id
            GROUP BY Cours.id;
        ";
        $stmt = $conn->prepare($sql);
    
        try {
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des cours avec détails : " . $e->getMessage());
            return false;
        }

    }
    //methode pour active cours 
    public static function activerCours($courseId){
        $conn=Database::getConnection();
        $sql="UPDATE cours SET statut_id=2 WHERE id=:id ";
        $stmt = $conn->prepare($sql);
        return $stmt->execute(['id' => $coursId]);
    }
    
}
