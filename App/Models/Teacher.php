<?php
namespace App\Models;

class Teacher extends User {
    public function showDashboard() {
        return "Tableau de bord Administrateur";
    }

}