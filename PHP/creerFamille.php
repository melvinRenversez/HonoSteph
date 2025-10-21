<?php
include("./verifyUser.php");

include("./database.php");
include("./getFamille.php");

session_start();

$id_compte = $_SESSION['id'];


if (recupFamille($id_compte, $db)) {
    echo "Déjà dans une famille";
    $_SESSION['error'] = [
            "success" => false,
            "message" => "Vous avez déjà une famille."
        ];
        header("Location: ../pages/compte.php");

} else {
    echo "pas de famille";
    createFamille($id_compte, $db);
}






function createFamille($id_compte, $db)
{
    $query = "INSERT INTO famille (fk_compte) VALUES (:id_compte);";
    $stmt = $db->prepare($query);
    $stmt->execute(array(
        ":id_compte" => $id_compte
    ));
    
    
    if ($stmt->rowCount() > 0) {
        $_SESSION["error"] = [
            "success" => true,
            "message" => "Votre famille a bien été créé "
        ];
        header("Location: ../pages/compte.php");
    } else {
        $_SESSION['error'] = [
            "success" => false,
            "message" => "Il y a eu un problème lors de la création de votre famille."
        ];
        header("Location: ../pages/compte.php");
    }
}














