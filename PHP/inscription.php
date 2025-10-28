<?php

session_start();


include("./database.php");


$nom = isset($_POST["name"]) ? trim($_POST["name"]) : "";
$prenom = isset($_POST["surname"]) ? trim($_POST["surname"]) : "";
$date = isset($_POST["date"]) ? trim($_POST["date"]) : "";
$address = isset($_POST["address"]) ? trim($_POST["address"]) : "";
$mail = isset($_POST["email"]) ? trim($_POST["email"]) : "";
$tel = isset($_POST["tel"]) ? trim($_POST["tel"]) : "";
$password = isset($_POST["password"]) ? trim($_POST["password"]) : "";

if (empty($nom) || empty($prenom) || empty($date) || empty($address) || empty($mail) || empty($tel) || empty($password)) {
    die("Veuillez remplir tous les champs");
}

insertUser($nom, $prenom, $date, $address, $mail, $tel, $password, $db);


function insertUser($nom, $prenom, $date, $address, $mail, $tel, $password, $db)
{
    if (checkDuplicate($mail, $tel, $db) == 0) {

        $query = "INSERT INTO 
            compte (nom, prenom, mail, adresse, naissance, tel, salt, password) 
            VALUES (:nom, :prenom, :mail, :address, :date, :tel, :salt, :password)";

        $salt = bin2hex(random_bytes(32));

        // Hacher le mot de passe avec SHA256 + salt
        $hashedPassword = hash('sha256', $salt . $password);


        $stmt = $db->prepare($query);
        $stmt->execute(array(
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':date' => $date,
            ':address' => $address,
            ':mail' => $mail,
            ':tel' => $tel,
            ':salt' => $salt,
            ':password' => $hashedPassword
        ));
        $_SESSION["error"] = [
            "success" => true,
            "message" => "Votre compte a bien été créé "
        ];
        header("Location: ../index.php");

    } else {
        $_SESSION["error"] = [
            "success" => false,
            "message" => "Mail ou téléphone déjà utilisé"
        ];
        header("Location: ../index.php");
    }
}


function checkDuplicate($email, $tel, $db)
{

    $query = "SELECT COUNT(*) FROM compte WHERE mail=:email OR tel=:tel";
    $stmt = $db->prepare($query);
    $stmt->execute(array(
        ':email' => $email,
        ':tel' => $tel
    ));

    return $stmt->fetchColumn();


}

