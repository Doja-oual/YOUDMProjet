<?php
namespace App\Models;

use App\Models\Tag;
use App\Models\Category;

class AdminModel extends User {
    // Afficher la liste des tags
    public function tags() {
        $tags = (new Tag())->showTag();
        $this->view('admin/tags', ['tags' => $tags]);
    }

    // Créer un nouveau tag
    public function createTag() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = ['name' => $_POST['name']];
            (new Tag())->addTag($data);
            header('Location: /admin/tags');
            exit();
        }
        $this->view('admin/tags/create');
    }

    // Supprimer un tag
    public function deleteTag($id) {
        (new Tag())->deleteTag($id);
        header('Location: /admin/tags');
        exit();
    }

    // Afficher la liste des catégories
    public function categories() {
        $categories = (new Category())->showCategorie();
        $this->view('admin/categories', ['categories' => $categories]);
    }

    // Créer une nouvelle catégorie
    public function createCategory() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = ['name' => $_POST['name']];
            (new Category())->addCategorie($data);
            header('Location: /admin/categories');
            exit();
        }
        $this->view('admin/categories/create');
    }

    // Supprimer une catégorie
    public function deleteCategory($id) {
        (new Category())->deleteCategorie($id);
        header('Location: /admin/categories');
        exit();
    }
}