<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Tag;
use App\Models\Category;

class StudentController extends Controller {
    // Afficher la liste des tags
    public function tags() {
        $tags = (new Tag())->all();
        $this->view('student/tags', ['tags' => $tags]);
    }

    // Afficher la liste des catégories
    public function categories() {
        $categories = (new Category())->all();
        $this->view('student/categories', ['categories' => $categories]);
    }
}