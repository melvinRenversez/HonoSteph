<?php

include("../PHP/verifyUser.php");

include("../PHP/getFamille.php");
include("../PHP/database.php");

$haveFamilly = recupFamille($_SESSION["id"], $db);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="../assets/js/popup.js" defer></script>
</head>

<style>

    .addMemberForm{
        opacity: 0;
        display: none;

        transition:  0.3s ease;
    }

    .addMemberForm.active{
        opacity: 1;
        display: block;
        
        transition: 0.3s ease;
    }

</style>

<body>


    <div class="addMemberForm" id="addMemberForm">
        <form action="../PHP/addMember.php" method="post">
            <div class="field">
                <input type="text" name="name" id="name" required>
                <label for="">Nom</label>
            </div>

            <div class="field">
                <input type="text" name="surname" id="surname" required>
                <label for="">Prénom</label>
            </div>

            <div class="field">
                <input type="date" name="date" id="date" required>
                <label for="">Date de naissance</label>
            </div>

            <button type="submit">Ajouter</button>
        </form>
    </div>

    <?php if (isset($_SESSION["error"])): ?>
        <div class="popup" id="popup">
            <span>
                <?php
                echo $_SESSION["error"]["message"];
                unset($_SESSION["error"]);
                ?>
            </span>
        </div>
    <?php endif; ?>




    <?php if (!$haveFamilly): ?>

        <a href="../PHP/creerFamille.php">creer un famille</a>

    <?php endif; ?>





    <?php if ($haveFamilly): ?>

        <h2>Ma famille</H2>

        <table>
            <thead>
                <tr>
                    <th>type</th>
                    <th>nom</th>
                    <th>prenom</th>
                    <th>age</th>
                </tr>
            </thead>

            <tbody>

                <?php

                $query = "
                        (select nom, prenom, 'vous' as role, calculateAge(naissance) as age
                            from compte c
                            join famille f on f.fk_compte = c.id
                            where c.id = :idCompte)
                            union all
                            (select nom, prenom, 'membre' as role, calculateAge(naissance) as age
                            from membre_famille
                            where fk_famille = (select f.id 
                            from compte c
                            join famille f on f.fk_compte = c.id
                            where c.id = :idCompte));
                    ";
                $stmt = $db->prepare($query);
                $stmt->execute(
                    array(
                        ':idCompte' => $_SESSION["id"]
                    )
                );
                $famillyMember = $stmt->fetchAll();

                foreach ($famillyMember as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['role'] . "</td>";
                    echo "<td>" . $row['nom'] . "</td>";
                    echo "<td>" . $row['prenom'] . "</td>";
                    echo "<td>" . $row['age'] . "</td>";
                    echo "</tr>";
                }


                ?>

            </tbody>
        </table>


        <?php

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

        if ($result < 3) {
            echo "<button onclick='toggleAddMemberForm()' >Ajouter un membre</button>";
        }

        ?>

    <?php endif; ?>




    <h2>Abbonement</h2>

    <table>
                <thead>
                    <tr>
                        <th>Type d'adhésion</th>
                        <th>Prix</th>
                        <th>Condition</th>
                    </tr>
                </thead>

                <tbody>

                    <?php

                    $query = "SELECT id, libelle, prix, description FROM type_adhesion;";
                    $stmt = $db->prepare($query);
                    $stmt->execute();
                    $typeAdhesion = $stmt->fetchAll();

                    foreach ($typeAdhesion as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['libelle'] . "</td>";
                        echo "<td>" . $row['prix'] . "€</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "</tr>";
                    }
                    ?>

                </tbody>
            </table>

    
    
            <form action="">

            <select name="" id="">
            
                <?php 
                
                    foreach ($typeAdhesion as $row) {
                        echo "<option value=' " . $row["id"] . " '> ". $row["libelle"] ."  </option>";
                    }
                    
                ?>

            </select>

            </form>
    



</body>

<script>
    const addMemberForm = document.getElementById("addMemberForm");
    function toggleAddMemberForm(){
        addMemberForm.classList.toggle("active");
    }

</script>

</html>