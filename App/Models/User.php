<?php
namespace App\Models;

abstract class User {
    // Constantes pour les rôles
    const ROLE_ETUDIANT = 1;
    const ROLE_ENSEIGNANT = 2;
    const ROLE_ADMIN = 3;

    // Propriétés protégées
    protected $id;
    protected $username;
    protected $email;
    protected $passwordHash;
    protected $role;
    protected $dateInscription;
    protected $photoProfil;
    protected $bio;
    protected $pays;
    protected $langueId;
    protected $statutId;

}