<?php
namespace App\Controllers;
require_once '../../vendor/autoload.php';

use App\Models\Course;
use App\Models\Tag;
use App\Models\Category;

class TeacherController {
    protected $teacherModel;
    protected $courseModel;

    public function __construct() {
        $this->courseModel = new Course();
    }

    public function index($teacherId) {
        $courses = $this->teacherModel->getCourses($teacherId);
        include 'App/Views/teacher/courses/index.php';
    }

    public function showCours() {
        $course = $this->courseModel->getAllCourses();
        // include 'App/Views/teacher/courses/show.php';
        return $course;
    }

    public function show($courseId) {
        $course = $this->courseModel->getCourseById($courseId);
        // include 'App/Views/teacher/courses/show.php';
    }


    public function create() {
        include 'App/Views/teacher/courses/create.php';
    }

    public function store($data) {
        $resulta=$this->courseModel->createCourse($data);

        // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //     // $data = [
        //     //     'titre' => $_POST['titre'],
        //     //     'description' => $_POST['description'],
        //     //     'contenu' => $_POST['contenu'],
        //     //     'type_contenu' => $_POST['type_contenu'],
        //     //     'enseignant_id' => $teacherId,
        //     //     'categorie_id' => $_POST['categorie_id'],
        //     //     'niveau' => $_POST['niveau'],
        //     //     'duree' => $_POST['duree'],
        //     //     'prix' => $_POST['prix'],
        //     //     'langue_id' => $_POST['langue_id'],
        //     //     'statut_id' => $_POST['statut_id']
        //     // ];
        //     var_dump($data);
        //     $resulta=$this->courseModel->createCourse($data);
        //     // header('Location: /teacher/courses/' . $teacherId);
        //     return $resulta;
        // }
    }

    public function edit($courseId) {
        $course = $this->courseModel->getCourseById($courseId);
        include 'App/Views/teacher/courses/edit.php';
    }

    public function update($courseId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'titre' => $_POST['titre'],
                'description' => $_POST['description'],
                'contenu' => $_POST['contenu'],
                'type_contenu' => $_POST['type_contenu'],
                'enseignant_id' => $_POST['enseignant_id'],
                'categorie_id' => $_POST['categorie_id'],
                'niveau' => $_POST['niveau'],
                'duree' => $_POST['duree'],
                'prix' => $_POST['prix'],
                'langue_id' => $_POST['langue_id'],
                'statut_id' => $_POST['statut_id']
            ];
            $this->courseModel->updateCourse($courseId, $data);
            header('Location: /teacher/courses/' . $_POST['enseignant_id']);
        }
    }

    public function destroy($courseId, $teacherId) {
        $this->courseModel->deleteCourse($courseId);
        header('Location: /teacher/courses/' . $teacherId);
    }

    public function tags() {
        $tags = (new Tag())->all();
        include 'App/Views/teacher/tags/index.php';
    }

    public function createTag() {
        include 'App/Views/teacher/tags/create.php';
    }

    public function storeTag() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = ['name' => $_POST['name']];
            (new Tag())->create($data);
            header('Location: /teacher/tags');
        }
    }

    public function editTag($tagId) {
        $tag = (new Tag())->find($tagId);
        include 'App/Views/teacher/tags/edit.php';
    }

    public function updateTag($tagId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = ['name' => $_POST['name']];
            (new Tag())->update($tagId, $data);
            header('Location: /teacher/tags');
        }
    }

    public function destroyTag($tagId) {
        (new Tag())->delete($tagId);
        header('Location: /teacher/tags');
    }

    public function categories() {
        $categories = (new Category())->all();
        include 'App/Views/teacher/categories/index.php';
    }

    public function createCategory() {
        include 'App/Views/teacher/categories/create.php';
    }

    public function storeCategory() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = ['name' => $_POST['name']];
            (new Category())->create($data);
            header('Location: /teacher/categories');
        }
    }

    public function editCategory($categoryId) {
        $category = (new Category())->find($categoryId);
        include 'App/Views/teacher/categories/edit.php';
    }

    public function updateCategory($categoryId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = ['name' => $_POST['name']];
            (new Category())->update($categoryId, $data);
            header('Location: /teacher/categories');
        }
    }

    public function destroyCategory($categoryId) {
        (new Category())->delete($categoryId);
        header('Location: /teacher/categories');
    }
}





