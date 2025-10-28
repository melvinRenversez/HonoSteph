<?php

include("./database.php");
session_start();

$mail = isset($_POST["mail"]) ? trim($_POST["mail"]) : "";
$password = isset($_POST["password"]) ? trim($_POST["password"]) : "";

if (empty($mail) || empty($password)) {
    die("Veuillez remplir tous les champs");
}



$query = "select verifyHashPassword(:passwordInsert, salt, password) as validity
from compte
where mail = :mail;";
$stmt = $db->prepare($query);
$stmt->execute(array(
    ':passwordInsert' => $password,
    ':mail' => $mail
));

$result = $stmt->fetchColumn();
echo $result;


if ($result == 1) {
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




