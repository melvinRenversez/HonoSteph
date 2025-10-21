<?php

include("./database.php");
session_start();

$mail = isset($_POST["mail"]) ? trim($_POST["mail"]) : "";
$password = isset($_POST["password"]) ? trim($_POST["password"]) : "";

if (empty($mail) || empty($password)) {
    die("Veuillez remplir tous les champs");
}



$query = "SELECT id FROM compte WHERE mail=:mail and password=:password";
$stmt = $db->prepare($query);
$stmt->execute(array(
    ':mail' => $mail,
    ':password' => $password
));

$result = $stmt->fetchColumn();
echo $result;


if ($result !== false) {
    $_SESSION['error'] = [
        "success" => true,
        "message" => "Connexion réussie"
    ];
    $_SESSION["id"] = $result;
    header("Location: ../index.php");
}else{
    $_SESSION["error"] = [
        "success" => false,
        "message" => "Identifiant ou mot de passe incorrect"
    ];
    header("Location: ../index.php");
}




