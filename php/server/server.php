<?php 
$host = "localhost";
$dbname = 'kpayphp'; // Le nom de la base de données
$username = 'root'; // Le nom d'utilisateur MySQL
$password = '';


try{
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion à la base de données réussie.";
}catch (PDOException  $e){
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>



