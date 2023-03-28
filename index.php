<?php

// Pré-requis: créer la BDD "injection_sql" puis importer le contenu avec le fichier injection_sql.sql fourni 

session_start();
$DB_NAME = "injection_sql";
$DB_USER = "root";
$DB_PASS = "adrar";

// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=' . $DB_NAME, $DB_USER, $DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if (!empty($_POST['login_user'])) {
    /* // Code pour effectuer une injection SQL ex: Champ 1: "Marceau", Champ 2: "adrar, 1); INSERT INTO users(login_user, pass_user, role_id) 
    VALUES('Marceau2', 'adrar', 3); -- " // Sans les guillemets
    $bdd->query("INSERT INTO users(login_user, pass_user, role_id) 
    VALUES('".$_POST['login_user']."', '".$_POST['pass_user'] ."');");
    */

    /* ____________________________________________ */

    /* // Code pour contrer une injection SQL */
    $req = $bdd->prepare("INSERT INTO users(login_user, pass_user, role_id) 
                            VALUES(:login_user, :pass_user, :role_id);");
    $req->bindParam(":login_user", $_POST['login_user']);
    $req->bindParam(":pass_user", $_POST['pass_user']);
    $role_id = 1;
    $req->bindParam(":role_id", $role_id);
    $req->execute();
}
$roles = $bdd->query("SELECT * FROM roles;");
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Injection SQL</title>
</head>

<body>
    <form method="post">
        <p>Login:</p>
        <input type="text" name="login_user">
        <p>Pass:</p>
        <input type="text" name="pass_user">
        <br>
        <br>
        <input type="submit" value="INJECTER">
    </form>
</body>

</html>