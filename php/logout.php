<?php
// Démarrez la session
session_start();

// Vérifiez si l'utilisateur est connecté
if($_SESSION["connectUser"] == true) {
    // Détruisez la session
    session_destroy();
    
    // Redirigez l'utilisateur vers une page d'accueil ou une page de connexion
    header("Location: home.php"); // Remplacez "page_accueil.php" par l'URL de votre choix
    exit; // Assurez-vous de terminer le script après la redirection
}
?>