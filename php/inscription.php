<?php 
include('./server/server.php');


try{
 
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $nom = $_POST["username"];
        $email = $_POST["email"];
        $mdp = $_POST["password"];
        
        $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);
    
        $sql = $pdo->prepare("INSERT INTO users (id, username, password, email, ketons) VALUES (0, :nom, :password, :email, 0)");
        // $sql->bindParam(':nom', $nom);
        // $sql->bindParam(':password', $mdpHash);
        // $sql->bindParam(':email', $email);
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        if($stmt->rowCount() > 0) {
            echo 'user exist';
        } else {
            $sql->execute([
                ":nom" => $nom,
                ":password" => $mdpHash,
                ":email" => $email
    
            ]);
            header("location: home.php");
        }
        
        
      
    }
}catch (PDOException  $e){
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
            <h1>s'inscrire</h1>
            <div class="inputContainer">
                <img src="../image/homme.png" alt="">
                <input id="username" name="username" type="text" required placeholder="Nom d'utilisateur">
            </div>
            <br>
            <br>
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
                <input id="submit" type="submit" value="s'inscrire">
            </div>
            
        </form>
    </main>
</body>
</html>


