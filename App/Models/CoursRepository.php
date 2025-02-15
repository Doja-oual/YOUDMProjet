<?php
namespace App\Models;
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Core\Model;
use Config\Database;
use App\Models\Tag;

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

    public static function createCourse($data, $tags) {
        $lastId = parent::add('Cours',$data);
        foreach($tags as $tag) {
            self::addTagToCours($lastId, $tag);
        }
        return true;
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

    public static function updateCourse($id, $data, $tags) {
        $tag = new Tag;
        $tag->deleteCourseTags($id);
        foreach($tags as $tag) {
            self::addTagToCours($id, $tag);
        }
        return parent::update('Cours', $id, $data);
    }

    public static function deleteCourse($id) {
        return parent:: delete('Cours', $id);
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
        $stmt->execute(['cours_id'=>$CoursId,'tag_id'=>$tagId]);
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
    public static function changerStatutCours($coursId) {
        $conn = Database::getConnection();
        $sql = "SELECT statut_id FROM cours WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $coursId]);
        $cours = $stmt->fetch(\PDO::FETCH_ASSOC);

        $nouveauStatut = ($cours['statut_id'] == 2) ? 1 : 2; // 1: Non actif, 2: Actif

        $sql = "UPDATE cours SET statut_id = :statut WHERE id = :id";
        $stmt = $conn->prepare($sql);
        return $stmt->execute(['id' => $coursId, 'statut' => $nouveauStatut]);
    }

    //cours NonActife
    public static function getCoursNonActifs() {
        $conn = Database::getConnection();
        $sql = "SELECT c.*, u.nom AS enseignant_nom 
                FROM cours c 
                JOIN utilisateur u ON c.enseignant_id = u.id
                WHERE c.statut_id = 2"; 
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
//cours actif 
public static function getCoursActifs() {
    $conn = Database::getConnection();
    $sql = "SELECT c.*, u.nom AS enseignant_nom 
            FROM cours c 
            JOIN utilisateur u ON c.enseignant_id = u.id
            WHERE c.statut_id = 1"; 
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

// nombre totale de cours cree par un enseinant
public static function getTotalCoursesByTeacher(int $teacherId): int
{
    $query = "SELECT COUNT(*) as total_courses 
              FROM Cours 
              WHERE enseignant_id = :teacherId";
    
    $stmt = Database::getConnection()->prepare($query);
    $stmt->execute(['teacherId' => $teacherId]);
    $result = $stmt->fetch();
    
    return (int) $result['total_courses'];
}
// nobre total inscrite
public static function getTotalStudentsByTeacher(int $teacherId): int
{
    $query = "SELECT COUNT(DISTINCT etudiant_id) as total_students
              FROM Inscription
              WHERE cours_id IN (SELECT id FROM Cours WHERE enseignant_id = :teacherId)";
    
    $stmt = Database::getConnection()->prepare($query);
    $stmt->execute(['teacherId' => $teacherId]);
    $result = $stmt->fetch();
    
    return (int) $result['total_students'];
}
// titre de cours plus populaire
public static function getMostPopularCourseByTeacher(int $teacherId): string
{
    $query = "SELECT c.titre
              FROM Cours c
              JOIN Inscription i ON c.id = i.cours_id
              WHERE c.enseignant_id = :teacherId
              GROUP BY c.id
              ORDER BY COUNT(i.etudiant_id) DESC
              LIMIT 1";
    
    $stmt = Database::getConnection()->prepare($query);
    $stmt->execute(['teacherId' => $teacherId]);
    $result = $stmt->fetch();
    
    return $result['titre'] ?? "Aucun cours trouvé";
}
//  grt detaie course pour page home 
public static function getActiveCoursesWithDetails() {
    $conn = self::getConnection();
    $sql = "
        SELECT 
            Cours.titre AS cours_titre,
            Utilisateur.nom AS enseignant_nom,
            Categorie.nom AS categorie_nom
        FROM 
            Cours
        JOIN 
            Utilisateur ON Cours.enseignant_id = Utilisateur.id
        JOIN 
            Categorie ON Cours.categorie_id = Categorie.id
        JOIN 
            Statut ON Cours.statut_id = Statut.id
        WHERE 
            Statut.nom = 'Actif';
    ";
    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération des cours actifs avec détails : " . $e->getMessage());
        return false;
    }
}
// course detaie  pou les cours prix=0
public static function getFreeCoursesWithDetailsGratuit() {
    $conn = self::getConnection();
    $sql = "
        SELECT 
            Cours.titre AS cours_titre,
            Utilisateur.nom AS enseignant_nom,
            Categorie.nom AS categorie_nom,
            Cours.prix AS prix
        FROM 
            Cours
        JOIN 
            Utilisateur ON Cours.enseignant_id = Utilisateur.id
        JOIN 
            Categorie ON Cours.categorie_id = Categorie.id
        JOIN 
            Statut ON Cours.statut_id = Statut.id
        WHERE 
            Statut.nom = 'Actif' AND Cours.prix = 0;
    ";
    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération des cours gratuits avec détails : " . $e->getMessage());
        return false;
    }
}

//methode recherche 
public static function searchCourses($keyword) {
    $conn = self::getConnection();

    // Préparer la requête SQL pour rechercher dans le titre, la description et le contenu
    $sql = "
        SELECT 
            Cours.*,
            Utilisateur.nom AS enseignant_nom,
            Categorie.nom AS categorie_nom
        FROM 
            Cours
        JOIN 
            Utilisateur ON Cours.enseignant_id = Utilisateur.id
        JOIN 
            Categorie ON Cours.categorie_id = Categorie.id
        WHERE 
            Cours.titre LIKE :keyword OR
            Cours.description LIKE :keyword OR
            Cours.contenu LIKE :keyword
    ";

    $stmt = $conn->prepare($sql);

    // Ajouter des wildcards (%) pour rechercher partiellement
    $keyword = "%$keyword%";

    try {
        $stmt->execute(['keyword' => $keyword]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
        error_log("Erreur lors de la recherche de cours : " . $e->getMessage());
        return [];
    }
}
    


//  les cours paginés

public static function getCoursesWithPagination($page = 1, $perPage = 6) {
    $conn = self::getConnection();
    $offset = ($page - 1) * $perPage;

    $sql = "
        SELECT 
            Cours.*,
            Utilisateur.nom AS enseignant_nom,
            Categorie.nom AS categorie_nom
        FROM Cours
        LEFT JOIN Utilisateur ON Cours.enseignant_id = Utilisateur.id
        LEFT JOIN Categorie ON Cours.categorie_id = Categorie.id
        LIMIT :limit OFFSET :offset
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
//totale cours
public static function countAllCourses() {
    $conn = self::getConnection();
    $sql = "SELECT COUNT(*) as total FROM Cours";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return (int) $stmt->fetch(\PDO::FETCH_ASSOC)['total'];
}
// course active 
public static function getActiveCourses() {
    $conn = self::getConnection();
    $sql = "SELECT * FROM Cours WHERE statut_id = :statut_id"; 
    $stmt = $conn->prepare($sql);
    
    try {
        $stmt->execute(['statut_id' => 1]); 
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération des cours actifs : " . $e->getMessage());
        return false;
    }
}

// methode qui affichie les cours de tescher 
public function getCoursesByTeacherId($teacherId) {
    $conn = self::getConnection();
    // Exemple de requête SQL pour récupérer les cours d'un enseignant
    $sql = "SELECT * FROM cours WHERE enseignant_id = :teacherId";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['teacherId' => $teacherId]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
}
