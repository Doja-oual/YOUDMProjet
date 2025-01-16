<?php
namespace App\Core;

abstract class Controller {
    /**
     * Charge une vue et passe des données à cette vue.
     *
     * @param string $view Le nom de la vue à charger (sans l'extension .php).
     * @param array $data Les données à passer à la vue.
     */
    protected function view($view, $data = []) {
        // Extrait les données pour les rendre accessibles dans la vue
        extract($data);

        // Inclut la vue depuis le dossier /app/views
        require_once __DIR__ . '/../../app/views/' . $view . '.php';
    }

    /**
     * Redirige vers une autre URL.
     *
     * @param string $url L'URL vers laquelle rediriger.
     */
    protected function redirect($url) {
        header('Location: ' . $url);
        exit();
    }

    /**
     * Valide les données de la requête.
     *
     * @param array $data Les données à valider.
     * @param array $rules Les règles de validation.
     * @return array|bool Retourne un tableau d'erreurs ou true si la validation réussit.
     */
    protected function validate($data, $rules) {
        // Implémentez votre logique de validation ici
        // Par exemple, utilisez une bibliothèque comme Respect/Validation
        return true; // Pour l'exemple, retourne toujours true
    }
}