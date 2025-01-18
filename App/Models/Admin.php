<?php
namespace App\Models;

class Admin extends User {
    public function showDashboard() {
        return "Tableau de bord Administrateur";
    }

}