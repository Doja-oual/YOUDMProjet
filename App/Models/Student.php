<?php
namespace App\Models;

use App\Models\UserRepository;
use App\Models\CoursRepository;
use App\Models\InscriptionRepository;


class Student extends User {
    public function showDashboard() {
        return "Tableau de bord Étudiant";
    }
 public function InscritInCourse($courseId){
    // virifie que etudiant deja fait insciption

    if($this->isInscritCourse($courseId)){
        return "vous etes deja inscrita ce course";
    }



    // enregistre l'inscription dans database
    
 }


}