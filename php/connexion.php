<?php
session_start();
include("./server/server.php");

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $mdp = $_POST["password"];

        // Requête pour récupérer le hachage du mot de passe correspondant à l'e-mail fourni
        $stmt = $pdo->prepare("SELECT password FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);

        $row = $stmt->fetch();

        if ($row) {
            // Hachage du mot de passe récupéré depuis la base de données
            $stored_password_hash = $row['password'];

            // Vérifier si le mot de passe fourni par l'utilisateur correspond au hachage stocké
            if (password_verify($mdp, $stored_password_hash)) {
                // Mot de passe correct, authentification réussie
                echo "Connexion réussie!";
                header("Location: home.php");
                $_SESSION["email"] = $email;
                $_SESSION["pwd"] = $mdp;
                // Vous pouvez rediriger l'utilisateur vers la page d'accueil
            } else {
                // Mot de passe incorrect, authentification échouée
                echo "Mot de passe incorrect. Connexion échouée.";
            }
        } else {
            // Aucun utilisateur avec cet e-mail trouvé
            echo "Aucun utilisateur avec cet e-mail trouvé.";
        }
    }
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inscription | kpay</title>
    <link rel="icon" href="../image/K.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/inscription.css">
</head>
<body>
    <header>
        <h1>kpay</h1>
    </header>
    <main>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h1>connexion</h1>
           
            <div class="inputContainer">
                <img src="../image/homme.png" alt="">
                <input id="email" name="email" type="email" required placeholder="Adresse électronique">
            </div>
            <br>
            <br>
            <div class="inputContainer">
                <img src="../image/cle.png" alt="">
                <input id="password" name="password" type="password" required placeholder="Mot de passe">
            </div>
            <br>
            <br>
            <div class="inputContainer">
                <input id="submit" type="submit" value="se connecter">
            </div>
            
        </form>
    </main>
</body>
</html>
