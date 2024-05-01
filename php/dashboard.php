<?php 
session_start();
include("./server/server.php");
$sql = $pdo->prepare("SELECT username FROM users WHERE email = :email");
$sql->execute([
    ":email" => $_SESSION["email"]
]);
$row = $sql->fetch();

$stored_name = $row["username"];

$sql2 = $pdo->prepare("SELECT ketons FROM users WHERE email = :email");
$sql2->execute([
    ":email" => $_SESSION["email"]

]);

$row2 = $sql2->fetch();
$stored_ketons = $row2["ketons"];

$sql3 = $pdo->prepare("SELECT email FROM users WHERE username = :username");
$sql3->execute([
    ":username"=>$stored_name
]);

$row3 = $sql3->fetch();
$stored_email = $row3["email"];

try{
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $mail = $_POST["Smail"];
        $ketons = $_POST["number"];
        if($stored_ketons >= $ketons && $ketons > 0){
            if($sql3->rowCount() > 0) {
                $sqlsend = $pdo->prepare("UPDATE users SET ketons = :ketons WHERE email = :email;");
                $sqlsend->execute([
                    ":ketons"=>$ketons,
                    ":email"=>$mail

                ]);
            }else{
                echo "email not exist";
            }
        }else{
            echo "pas assé de ketons";
        }
    }

}catch(PDOException $e){
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard | kpay</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="icon" href="../image/K.png">
</head>
<body>
    <header>
        <h1>kpay</h1>
        
        
        <h2><?= $stored_ketons ?> ₭</h2>
        
        
    </header>
    <main>
        <section id="sendMoney">
        <h3>send ketons</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="inputDiv">
                <input id="Smail" name="Smail" type="email" require placeholder="destinataire">
                <input id="number" name="number" type="number" require placeholder="débit">
            </div>
            <input type="submit" id="submit">
            
        
        </form>

        </section>
        <br>
        <br>
        
        <section id="userInfo">
            <h3>nom d'utilisateur: <?= $stored_name ?></h3>
            <h3>adresse électronique: <?= $_SESSION["email"] ?></h3>
            <div id="logoutDiv">
                <a href="logout.php">se déconnecter</a>
            </div>
            
        </section>

    </main>
</body>
</html>