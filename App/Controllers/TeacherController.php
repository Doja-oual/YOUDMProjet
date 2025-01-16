<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Course;

class TeacherController extends Controller {
    // Afficher la liste des tags
    public function tags() {
        $tags = (new Tag())->all();
        $this->view('teacher/tags', ['tags' => $tags]);
    }

    // Créer un nouveau tag
    public function createTag() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = ['name' => $_POST['name']];
            (new Tag())->create($data);
            header('Location: /teacher/tags');
            exit();
        }
        $this->view('teacher/tags/create');
    }

    // Afficher la liste des catégories
    public function categories() {
        $categories = (new Category())->all();
        $this->view('teacher/categories', ['categories' => $categories]);
    }

    // Créer une nouvelle catégorie
    public function createCategory() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = ['name' => $_POST['name']];
            (new Category())->create($data);
            header('Location: /teacher/categories');
            exit();
        }
        $this->view('teacher/categories/create');
    }





//courses



    public function listCourses() {
        $enseignant_id = $_SESSION['user_id'];
        $courseModel = new Course();
        $courses = $courseModel->getCoursesByTeacher($enseignant_id);
        $this->view('teacher/courses/list', ['courses' => $courses]);
    }

    public function createCourseForm() {
        $this->view('teacher/courses/create');
    }

    public function storeCourse() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $enseignant_id = $_SESSION['user_id'];
            $data = [
                'titre' => $_POST['titre'],
                'description' => $_POST['description'],
                'contenu' => $_POST['contenu'],
                'type_contenu' => $_POST['type_contenu'],
                'enseignant_id' => $enseignant_id,
                'categorie_id' => $_POST['categorie_id'],
                'niveau' => $_POST['niveau'],
                'duree' => $_POST['duree'],
                'prix' => $_POST['prix'],
                'langue_id' => $_POST['langue_id'],
                'statut_id' => $_POST['statut_id']
            ];
            $courseModel = new Course();
            $courseModel->createCourse($data);
            $this->redirect('/teacher/courses');
        }
    }

    public function showCourse($id) {
        $courseModel = new Course();
        $course = $courseModel->getCourseById($id);
        if ($course) {
            $course->contenu = $courseModel->handleContent($course->type_contenu, $course->contenu);
            $this->view('teacher/courses/show', ['course' => $course]);
        } else {
            $this->view('error', ['message' => 'Cours non trouvé']);
        }
    }

    public function editCourseForm($id) {
        $courseModel = new Course();
        $course = $courseModel->getCourseById($id);
        if ($course) {
            $this->view('teacher/courses/edit', ['course' => $course]);
        } else {
            $this->view('error', ['message' => 'Cours non trouvé']);
        }
    }

    public function updateCourse($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'titre' => $_POST['titre'],
                'description' => $_POST['description'],
                'contenu' => $_POST['contenu'],
                'type_contenu' => $_POST['type_contenu'],
                'categorie_id' => $_POST['categorie_id'],
                'niveau' => $_POST['niveau'],
                'duree' => $_POST['duree'],
                'prix' => $_POST['prix'],
                'langue_id' => $_POST['langue_id'],
                'statut_id' => $_POST['statut_id']
            ];
            $courseModel = new Course();
            $courseModel->updateCourse($id, $data);
            $this->redirect('/teacher/courses');
        }
    }

    public function deleteCourse($id) {
        $courseModel = new Course();
        $courseModel->deleteCourse($id);
        $this->redirect('/teacher/courses');
    }
}