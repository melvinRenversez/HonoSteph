<?php

function recupFamille($id, $db)
{
    $query = "SELECT id from famille where fk_compte = :id";
    $stmt = $db->prepare($query);
    $stmt->execute(
        array(
            ':id' => $id
        )
    );
    $result = $stmt->fetchColumn();
    return $result;
}