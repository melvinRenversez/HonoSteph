<?php 


include("./verifyUser.php");
include("./database.php");

$id = $_SESSION["id"];
$nom = isset($_POST["name"]) ? trim($_POST["name"]) : "";
$prenom = isset($_POST["surname"]) ? trim($_POST["surname"]) : "";
$naissance = isset($_POST["date"]) ? trim($_POST["date"]) : "";
$adresse = isset($_POST["address"]) ? trim($_POST["address"]) : "";
$mail = isset($_POST["email"]) ? trim($_POST["email"]) : "";
$tel = isset($_POST["tel"]) ? trim($_POST["tel"]) : "";


if (empty($nom) || empty($prenom) || empty($naissance) || empty($adresse) || empty($mail) || empty($tel)) {
    die("Veuillez remplir tous les champs");
}

$query = "UPDATE compte SET nom = :nom, prenom = :prenom, naissance = :naissance, adresse = :adresse, mail = :mail, tel = :tel WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->execute(array(
    ':nom' => $nom,
    ':prenom' => $prenom,
    ':naissance' => $naissance,
    ':adresse' => $adresse,
    ':mail' => $mail,
    ':tel' => $tel,
    ':id' => $id
));


if ($stmt->rowCount() > 0) {
    $_SESSION["error"] = [
        "success" => true,
        "message" => "Compte mis à jour"    
    ];
    header("Location: ../pages/compte.php");
}else{
    $_SESSION["error"] = [
        "success" => false,
        "message" => "Compte non mis à jour"
    ];
    header("Location: ../pages/compte.php");
}