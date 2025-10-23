<?php

include("./verifyUser.php");
include("./database.php");

$id_compte = $_SESSION["id"];

$typeAdhesion = isset($_POST["typeAdhesion"]) ? trim($_POST["typeAdhesion"]) : "";
// $enfantMember = isset($_POST["enfantMember"]) ? trim($_POST["enfantMember"]) : "";
// $member = isset($_POST["member"]) ? trim($_POST["member"]) : "";


if (empty($typeAdhesion)) {
    die("Veuillez choissir un abonnement");
}


var_dump($typeAdhesion);


if ($typeAdhesion == 1) {
    $query = "INSERT INTO adhesion (fk_type_adhesion, fk_compte)
                VALUES (:typeAdhesion, :id_compte)";
    $stmt = $db->prepare($query);
    $stmt->execute(array(
        ':typeAdhesion' => $typeAdhesion,
        ':id_compte' => $id_compte
    ));

    if ($stmt->rowCount() > 0) {
        $_SESSION["error"] = [
            "success" => true,
            "message" => "Abonnement commandé"
        ];
        header("Location: ../pages/compte.php");
    } else {
        $_SESSION["error"] = [
            "success" => false,
            "message" => "Abonnement non commandé"
        ];
        header("Location: ../pages/compte.php");
    }
}




if ($typeAdhesion == 2) {

    $enfantMember = isset($_POST["enfantMember"]) ? trim($_POST["enfantMember"]) : "";

    if (empty($enfantMember)) {
        die("Veuillez choisir un enfant");
    }

    $query = "INSERT INTO adhesion_parrainee (fk_type_adhesion, fk_membre_famille, fk_compte)
                VALUES (:typeAdhesion, :enfantMember, :id_compte)";
    $stmt = $db->prepare($query);
    $stmt->execute(array(
        ':typeAdhesion' => $typeAdhesion,
        ':enfantMember' => $enfantMember,
        ':id_compte' => $id_compte
    ));

    if ($stmt->rowCount() > 0) {
        $_SESSION["error"] = [
            "success" => true,
            "message" => "Abonnement commandé"
        ];
        header("Location: ../pages/compte.php");
    } else {
        $_SESSION["error"] = [
            "success" => false,
            "message" => "Abonnement non commandé"
        ];
        header("Location: ../pages/compte.php");
    }

}

if ($typeAdhesion == 3) {
    $query = "INSERT INTO adhesion (fk_type_adhesion, fk_compte)
                VALUES (:typeAdhesion, :id_compte)";
    $stmt = $db->prepare($query);
    $stmt->execute(array(
        ':typeAdhesion' => $typeAdhesion,
        ':id_compte' => $id_compte
    ));

    if ($stmt->rowCount() > 0) {
        $_SESSION["error"] = [
            "success" => true,
            "message" => "Abonnement commandé"
        ];
        header("Location: ../pages/compte.php");
    } else {
        $_SESSION["error"] = [
            "success" => false,
            "message" => "Abonnement non commandé"
        ];
        header("Location: ../pages/compte.php");
    }
}

if ($typeAdhesion == 4) {

    $Who = isset($_POST["Who"]) ? trim($_POST["Who"]) : "";

    if (empty($Who)) {
        die("Veuillez choisir un enfant");
    }

    echo $Who;

    if ($Who == "1") {
        $query = "INSERT INTO adhesion (fk_type_adhesion, fk_compte)
                    VALUES (:typeAdhesion, :id_compte)";
        $stmt = $db->prepare($query);
        $stmt->execute(array(
            ':typeAdhesion' => $typeAdhesion,
            ':id_compte' => $id_compte
        ));

        if ($stmt->rowCount() > 0) {
            $_SESSION["error"] = [
                "success" => true,
                "message" => "Abonnement commandé"
            ];
            header("Location: ../pages/compte.php");
        } else {
            $_SESSION["error"] = [
                "success" => false,
                "message" => "Abonnement non commandé"
            ];
            header("Location: ../pages/compte.php");
        }
    }
    if ($Who == "2") {
        
        $memberOneDay = isset($_POST["memberOneDay"]) ? trim($_POST["memberOneDay"]) : "";

        if (empty($memberOneDay)) {
            die("Veuillez choisir un enfant");
        }

        $query = "INSERT INTO adhesion_parrainee (fk_type_adhesion, fk_membre_famille, fk_compte)
                    VALUES (:typeAdhesion, :memberOneDay, :id_compte)";
        $stmt = $db->prepare($query);
        $stmt->execute(array(
            ':typeAdhesion' => $typeAdhesion,
            ':memberOneDay' => $memberOneDay,
            ':id_compte' => $id_compte
        ));
    
        if ($stmt->rowCount() > 0) {
            $_SESSION["error"] = [
                "success" => true,
                "message" => "Abonnement commandé"
            ];
            header("Location: ../pages/compte.php");
        } else {
            $_SESSION["error"] = [
                "success" => false,
                "message" => "Abonnement non commandé"
            ];
            header("Location: ../pages/compte.php");
        }

    }


}











