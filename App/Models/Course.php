<?php
namespace App\Models;
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Core\Model;
use Config\Database;

class Course extends Model {
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
        return parent::all($this->table);
    }

    public function getCourseById($id) {
        return parent::find($this->table,$id);
    }

    public function updateCourse($id, $data) {
        return parent::update($id, $data);
    }

    public function deleteCourse($id) {
        return parent:: delete($id);
    }

    public function handleContent($type_contenu, $contenu) {
        if (!isset($this->contentHandlers[$type_contenu])) {
            throw new \Exception("Type de contenu non supporte.");
        }
        return $this->contentHandlers[$type_contenu]($contenu);
    }
}