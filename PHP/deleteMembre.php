<?php


include("./verifyUser.php");
include("./database.php");


$memberId = isset($_GET["memberId"]) ? trim($_GET["memberId"]) : "";
$idCompte = $_SESSION["id"];


$query = "select mf.id
from compte c
join famille f on f.fk_compte = c.id
join membre_famille mf on mf.fk_famille = f.id 
where c.id = :idCompte and mf.id=:memberId;";


$stmt = $db->prepare($query);
$stmt->execute(array(
    ':idCompte' => $idCompte,
    ':memberId' => $memberId
));

$result = $stmt->fetchColumn();


if ($result) {
    $query = "delete from membre_famille where id = :memberId";
    $stmt = $db->prepare($query);
    $stmt->execute(array(
        ':memberId' => $memberId
    ));

    if ($stmt->rowCount() > 0) {
        $_SESSION["error"] = [
            "success" => true,
            "message" => "Membre supprimé"
        ];
        header("Location: ../pages/compte.php");
    } else {
        $_SESSION["error"] = [
            "success" => false,
            "message" => "Membre non supprimé"
        ];
        header("Location: ../pages/compte.php");
    }
} else {
    $_SESSION["error"] = [
        "success" => false,
        "message" => "Membre non supprimé vous ne pouvez pas supprimer un membre qui ne vous appartient pas"
    ];
    header("Location: ../pages/compte.php");
}















