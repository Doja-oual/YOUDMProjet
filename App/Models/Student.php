<?php
namespace App\Models;

class Student extends User {
    public function showDashboard() {
        return "Tableau de bord Administrateur";
    }

}