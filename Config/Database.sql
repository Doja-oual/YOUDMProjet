
CREATE DATABASE Youdemy;

USE Youdemy;

-- Table pour les roles 
CREATE TABLE Role (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL UNIQUE
);

-- Table pour les statuts (actif, suspendu, en attente, ...)
CREATE TABLE Statut (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL UNIQUE
);

-- Table pour les langues (français, anglais,..)
CREATE TABLE Langue (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(10) NOT NULL UNIQUE, -- Exemple : 'fr', 'en'
    nom VARCHAR(100) NOT NULL
);

-- Table pour les utilisateurs 
CREATE TABLE Utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    role_id INT,
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    photo_profil VARCHAR(255),
    bio TEXT,
    pays VARCHAR(100),
    langue_id INT,
    statut_id INT,
    FOREIGN KEY (role_id) REFERENCES Role(id) ON DELETE SET NULL,
    FOREIGN KEY (langue_id) REFERENCES Langue(id) ON DELETE SET NULL,
    FOREIGN KEY (statut_id) REFERENCES Statut(id) ON DELETE SET NULL
);

-- Table pour les catégories de cours (développement, design, etc.)
CREATE TABLE Categorie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE,
    description TEXT
);

-- Table pour les tags (programmation, web, etc.)
CREATE TABLE Tag (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE
);

-- Table pour les cours
CREATE TABLE Cours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT,
    contenu TEXT, 
    type_contenu ENUM('texte', 'video', 'image'), 
    enseignant_id INT,
    categorie_id INT,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    niveau VARCHAR(50),
    duree INT,
    prix DECIMAL(10, 2),
    langue_id INT,
    statut_id INT,
    FOREIGN KEY (enseignant_id) REFERENCES Utilisateur(id) ON DELETE CASCADE,
    FOREIGN KEY (categorie_id) REFERENCES Categorie(id) ON DELETE SET NULL,
    FOREIGN KEY (langue_id) REFERENCES Langue(id) ON DELETE SET NULL,
    FOREIGN KEY (statut_id) REFERENCES Statut(id) ON DELETE SET NULL
);

-- Table de liaison entre les cours et les tags (relation many-to-many)
CREATE TABLE CoursTag (
    cours_id INT,
    tag_id INT,
    PRIMARY KEY (cours_id, tag_id),
    FOREIGN KEY (cours_id) REFERENCES Cours(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES Tag(id) ON DELETE CASCADE
);

-- Table pour les inscriptions des etudiants aux cours
CREATE TABLE Inscription (
    etudiant_id INT,
    cours_id INT,
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    statut_id INT,
    PRIMARY KEY (etudiant_id, cours_id),
    FOREIGN KEY (etudiant_id) REFERENCES Utilisateur(id) ON DELETE CASCADE,
    FOREIGN KEY (cours_id) REFERENCES Cours(id) ON DELETE CASCADE,
    FOREIGN KEY (statut_id) REFERENCES Statut(id) ON DELETE SET NULL
);

-- Table pour les évaluations des cours par les etudiants
CREATE TABLE Evaluation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    etudiant_id INT,
    cours_id INT,
    note INT CHECK (note BETWEEN 1 AND 5),
    commentaire TEXT,
    date_evaluation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (etudiant_id) REFERENCES Utilisateur(id) ON DELETE CASCADE,
    FOREIGN KEY (cours_id) REFERENCES Cours(id) ON DELETE CASCADE
);

-- Table pour les certificats de complétion des cours
CREATE TABLE Certificat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    etudiant_id INT,
    cours_id INT,
    date_emission DATETIME DEFAULT CURRENT_TIMESTAMP,
    lien_certificat VARCHAR(255),
    FOREIGN KEY (etudiant_id) REFERENCES Utilisateur(id) ON DELETE CASCADE,
    FOREIGN KEY (cours_id) REFERENCES Cours(id) ON DELETE CASCADE
);

-- Table pour les notifications des utilisateurs
CREATE TABLE Notification (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT,
    message TEXT,
    date_notification DATETIME DEFAULT CURRENT_TIMESTAMP,
    statut_id INT,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur(id) ON DELETE CASCADE,
    FOREIGN KEY (statut_id) REFERENCES Statut(id) ON DELETE SET NULL
);

INSERT INTO Role (nom) VALUES ('Étudiant');
INSERT INTO Role (nom) VALUES ('Enseignant');
INSERT INTO Role (nom) VALUES ('Administrateur');