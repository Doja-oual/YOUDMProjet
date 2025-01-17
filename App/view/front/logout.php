<?php

// Demarrer la session
session_start();

// Detruire toutes les donnees de la session
session_unset(); // Supprime toutes les variables de session
session_destroy(); // Detruit la session

header('Location: Auth.php');
exit(); 
?>