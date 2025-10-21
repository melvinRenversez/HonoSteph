<?php 

include("./verifyUser.php");

include("./database.php");

$nom = isset($_POST["name"]) ? trim($_POST["name"]) : "";
$prenom = isset($_POST["surname"]) ? trim($_POST["surname"]) : "";
$naissance  = isset($_POST["date"]) ? trim($_POST["date"]) : "";

if (empty($nom) || empty($prenom) || empty($naissance)) {
    die("Veuillez remplir tous les champs");
}

$query = "select count(mf.id) 
from membre_famille mf
join famille f on f.id = mf.fk_famille
join compte c on c.id = f.fk_compte
where c.id = :idCompte";

$stmt = $db->prepare($query);
$stmt->execute(
    array(
        ':idCompte' => $_SESSION["id"]
    )
);
$result = $stmt->fetchColumn();

if ($result >= 3) {
    $_SESSION['error'] = [
        "success" => false,
        "message" => "Vous avez atteint le nombre maximum de membres."
    ];
    header("Location: ../pages/compte.php");
} else {

    $query = "INSERT INTO membre_famille (nom, prenom, naissance, fk_famille) VALUES (:nom, :prenom, :naissance, (select f.id 
    from compte c
    join famille f on f.fk_compte = c.id
    where c.id = :idCompte));";


    $stmt = $db->prepare($query);
    $stmt->execute(array(
        ":nom" => $nom,
        ":prenom" => $prenom,
        ":naissance" => $naissance,
        ":idCompte" => $_SESSION["id"]
    ));

    if ($stmt->rowCount() > 0) {
        $_SESSION["error"] = [
            "success" => true,
            "message" => "Votre membre a bien été ajouté "
        ];
        header("Location: ../pages/compte.php");
    } else {
        $_SESSION['error'] = [
            "success" => false,
            "message" => "Il y a eu un problème lors de l'ajout de votre membre."
        ];
        header("Location: ../pages/compte.php");
    }
}
