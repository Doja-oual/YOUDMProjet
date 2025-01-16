<?php
require_once '../../vendor/autoload.php';

use App\Models\Course;
use App\Models\Tag;
use App\Models\Category;

use App\Controllers\TeacherController;

// Créer une instance de TeacherController
$teacherController = new TeacherController();

// Simuler une requête POST pour créer un cours


// Simuler une requête GET pour récupérer un cours par ID
// Remplacez par l'ID du cours créé
var_dump( $teacherController->showCours());

// Simuler une requête POST pour mettre à jour un cours
// $_POST = [
//     'titre' => 'PHP Avancé',
//     'description' => 'Un cours pour approfondir vos connaissances en PHP.',
//     'contenu' => 'Nouveau contenu...',
//     'type_contenu' => 'texte',
//     'enseignant_id' => 1,
//     'categorie_id' => 1,
//     'niveau' => 'Intermédiaire',
//     'duree' => '3 heures',
//     'prix' => 49.99,
//     'langue_id' => 1,
//     'statut_id' => 1
// ];
// echo "Mise à jour du cours avec l'ID $courseId...\n";
// $teacherController->update($courseId);
// echo "Cours mis à jour avec succès.\n";

// // Simuler une requête pour supprimer un cours
// echo "Suppression du cours avec l'ID $courseId...\n";
// $teacherController->destroy($courseId, $teacherId);
// echo "Cours supprimé avec succès.\n";

// // Simuler une requête GET pour récupérer tous les tags
// echo "Récupération de tous les tags...\n";
// $teacherController->tags();

// // Simuler une requête POST pour créer un tag
// $_POST = ['name' => 'PHP'];
// echo "Création d'un tag...\n";
// $teacherController->storeTag();
// echo "Tag créé avec succès.\n";

// // Simuler une requête pour supprimer un tag
// $tagId = 1; // Remplacez par l'ID du tag créé
// echo "Suppression du tag avec l'ID $tagId...\n";
// $teacherController->destroyTag($tagId);
// echo "Tag supprimé avec succès.\n";

// // Simuler une requête GET pour récupérer toutes les catégories
// echo "Récupération de toutes les catégories...\n";
// $teacherController->categories();

// // Simuler une requête POST pour créer une catégorie
// $_POST = ['name' => 'Programmation'];
// echo "Création d'une catégorie...\n";
// $teacherController->storeCategory();
// echo "Catégorie créée avec succès.\n";

// // Simuler une requête pour supprimer une catégorie
// $categoryId = 1; // Remplacez par l'ID de la catégorie créée
// echo "Suppression de la catégorie avec l'ID $categoryId...\n";
// $teacherController->destroyCategory($categoryId);
// echo "Catégorie supprimée avec succès.\n";