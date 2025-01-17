<?php
namespace App\Controllers;

use App\Models\UserModel;

class UserController {
    public function register() {
        $data = [
            'nom' => $_POST['nom'],
            'email' => $_POST['email'],
            'mot_de_passe' => $_POST['mot_de_passe'],
        ];

        if (UserModel::emailExists($data['email'])) {
            echo json_encode(['success' => false, 'message' => 'Cet email est déjà utilisé.']);
            return;
        }

        if (UserModel::register($data['nom'], $data['email'], $data['mot_de_passe'])) {
            echo json_encode(['success' => true, 'message' => 'Inscription réussie.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'inscription.']);
        }
    }

    public function login() {
        $email = $_POST['email'];
        $password = $_POST['mot_de_passe'];

        $user = UserModel::login($email, $password);

        if ($user) {
            echo json_encode(['success' => true, 'user' => $user]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Email ou mot de passe incorrect.']);
        }
    }

    public function getUser($id) {
        $user = UserModel::getUserById($id);

        if ($user) {
            echo json_encode(['success' => true, 'user' => $user]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Utilisateur non trouvé.']);
        }
    }

    public function updateUser($id) {
        $data = [
            'nom' => $_POST['nom'],
            'email' => $_POST['email'],
            'mot_de_passe' => $_POST['mot_de_passe'] ?? null,
            'role_id' => $_POST['role_id'] ?? null,
        ];

        if (UserModel::updateUser($id, $data)) {
            echo json_encode(['success' => true, 'message' => 'Utilisateur mis à jour.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour.']);
        }
    }

    public function deleteUser($id) {
        if (UserModel::deleteUser($id)) {
            echo json_encode(['success' => true, 'message' => 'Utilisateur supprimé.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression.']);
        }
    }
}