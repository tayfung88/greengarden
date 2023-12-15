<?php
// Démarrez la session
session_start();

// Détruisez toutes les données de session
session_destroy();

// Rediriger l'utilisateur vers la page d'accueil
header("Location: index.php");
exit;
?>
