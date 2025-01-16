<?php
namespace App\Models;

use App\Core\Model;

class Course extends Model {
    protected $table = 'Cours';
    protected $fillable = [
        'titre', 'description', 'contenu', 'type_contenu', 'enseignant_id', 
        'categorie_id', 'niveau', 'duree', 'prix', 'langue_id', 'statut_id'
    ];

    public function createCourse($data) {
        return $this->create($data);
    }

    public function getAllCourses() {
        return $this->all();
    }

    public function getCourseById($id) {
        return $this->find($id);
    }

    public function updateCourse($id, $data) {
        return $this->update($id, $data);
    }

    public function deleteCourse($id) {
        return $this->delete($id);
    }

    public function handleContent($type_contenu, $contenu) {
        switch ($type_contenu) {
            case 'texte':
                return $this->displayText($contenu);
            case 'video':
                return $this->displayVideo($contenu);
            case 'image':
                return $this->displayImage($contenu);
            default:
                throw new \Exception("Type de contenu non supporté.");
        }
    }

    protected function displayText($contenu) {
        return "<p>$contenu</p>";
    }

    protected function displayVideo($contenu) {
        return "<video controls><source src='$contenu' type='video/mp4'></video>";
    }

    protected function displayImage($contenu) {
        return "<img src='$contenu' alt='Image du cours'>";
    }
}