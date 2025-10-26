<?php

include("./verifyUser.php");
include("./database.php");


$adsId = isset($_GET["adsId"]) ? trim($_GET["adsId"]) : "";
$idCompte = $_SESSION["id"];

if (empty($adsId)) {
    die("Veuillez choisir une adhesion");
}


$query = "select id
from adhesion_parrainee 
where fk_compte=:idCompte and id = :adsId;";

$stmt = $db->prepare($query);
$stmt->execute(array(
    ':idCompte' => $idCompte,
    ':adsId' => $adsId
));

$result = $stmt->fetchColumn();


if ($result) {
    $query = "delete from adhesion_parrainee where id = :adsId";
    $stmt = $db->prepare($query);
    $stmt->execute(array(
        ':adsId' => $adsId
    ));

    if ($stmt->rowCount() > 0) {
        $_SESSION["error"] = [
            "success" => true,
            "message" => "Abonnement supprimé"
        ];
        header("Location: ../pages/compte.php");
    } else {
        $_SESSION["error"] = [
            "success" => false,
            "message" => "Abonnement non supprimé"
        ];
        header("Location: ../pages/compte.php");
    }
} else {
    $_SESSION["error"] = [
        "success" => false,
        "message" => "abonnement non supprimé vous ne pouvez pas supprimer un abonnement qui ne vous appartient pas"
    ];
    header("Location: ../pages/compte.php");
}
