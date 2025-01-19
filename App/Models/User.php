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

    // Constructeur
    public function __construct($id, $username, $email, $passwordHash, $role, $dateInscription = null, $photoProfil = null, $bio = null, $pays = null, $langueId = null, $statutId = null) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->role = $role;
        $this->dateInscription = $dateInscription;
        $this->photoProfil = $photoProfil;
        $this->bio = $bio;
        $this->pays = $pays;
        $this->langueId = $langueId;
        $this->statutId = $statutId;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPasswordHash() {
        return $this->passwordHash;
    }

    public function getRole() {
        return $this->role;
    }

    public function getDateInscription() {
        return $this->dateInscription;
    }

    public function getPhotoProfil() {
        return $this->photoProfil;
    }

    public function getBio() {
        return $this->bio;
    }

    public function getPays() {
        return $this->pays;
    }

    public function getLangueId() {
        return $this->langueId;
    }

    public function getStatutId() {
        return $this->statutId;
    }

    // Setters
    public function setUsername($username) {
        $this->username = $username;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPasswordHash($passwordHash) {
        $this->passwordHash = $passwordHash;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function setDateInscription($dateInscription) {
        $this->dateInscription = $dateInscription;
    }

    public function setPhotoProfil($photoProfil) {
        $this->photoProfil = $photoProfil;
    }

    public function setBio($bio) {
        $this->bio = $bio;
    }

    public function setPays($pays) {
        $this->pays = $pays;
    }

    public function setLangueId($langueId) {
        $this->langueId = $langueId;
    }

    public function setStatutId($statutId) {
        $this->statutId = $statutId;
    }

    // Méthode pour vérifier le mot de passe
    public function verifyPassword($password) {
        return password_verify($password, $this->passwordHash);
    }

    // Méthode abstraite pour afficher le tableau de bord
    abstract public function showDashboard();
}