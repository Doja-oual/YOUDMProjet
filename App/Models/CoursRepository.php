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

    public function getAllCourses() {
        $conn=self::getConnection();
        $sql="
        SELECT Cours.*,
        Categorie.nom as category.nom,
        GROUP_CONTACT(Tag.nom SEPARATOR  ',') AS tags
        FROM Cours
        LEFT JOIN 
        Categorie ON Cours.categorie_id = Categorie.id
        LEFT JOIN 
        CoursTag ON Cours.id=CoursTag.cours_id
        LEFT JOIN 
        *
        Tag ON CoursTag.tag_id=Tag.id
        GROUP BY
        Cours.id";
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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

    
}
