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

    <link rel="stylesheet" href="../assets/css/default.css">
    <link rel="stylesheet" href="../assets/css/compte.css">

    <script src="../assets/js/popup.js" defer></script>
</head>

<style>
</style>

<body>



    <div class="trailer">
        <video src="./assets/Full Trailer.mp4" autoplay loop muted></video>
    </div>

    <div class="overlay"></div>


    <a class="modif" href="../index.php">
        Retour
    </a>



    <div class="addMemberForm" id="addMemberForm">
        <form action="../PHP/addMember.php" method="post">
            <div class="field">
                <input type="text" name="name" id="name" placeholder="" required>
                <label for="">Nom</label>
            </div>

            <div class="field">
                <input type="text" name="surname" id="surname" placeholder="" required>
                <label for="">Prénom</label>
            </div>

            <div class="field">
                <input type="date" name="date" id="date" placeholder="" required>
                <label for="">Date de naissance</label>
            </div>

            <button type="submit">Ajouter</button>
            <button id="annAddMember">Annuler</button>
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

        <a href="../PHP/creerFamille.php">Créer une famille</a>

    <?php endif; ?>



    <div class="content">
        <!-- tttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttt -->

        <section class="logo">
            <img src="../assets/images/logo.png" alt="">
        </section>


        <section class="famille">



            <?php if ($haveFamilly): ?>

                <h2>Ma famille</H2>

                <table>
                    <thead>
                        <tr>
                            <th>Catégorie</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Age</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php

                        $query = "
                        (select c.id, nom, prenom, 'vous' as role, calculateAge(naissance) as age
                            from compte c
                            join famille f on f.fk_compte = c.id
                            where c.id = :idCompte)
                            union all
                            (select mf.id, nom, prenom, 'membre' as role, calculateAge(naissance) as age
                            from membre_famille mf
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
                            if ($row['role'] !== 'vous') {
                                echo "<td class='tb'>" . $row['age'] . " <a href='../PHP/deleteMembre.php?memberId=" . $row['id'] . "'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='24px' height='24px' viewBox='0 0 24 24'
                            fill='none'>
                            <path
                                d='M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6M14 10V17M10 10V17'
                                stroke='#000000' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' />
                        </svg>
                    </a></td>";
                            } else {
                                echo "<td>" . $row['age'] . "</td>";
                            }
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
        </section>

        <section class="compte">



            <h2>
                Mon compte
            </h2>

            <?php

            $query = "select nom, prenom, naissance, adresse, mail, tel 
        from compte 
        where id = :idCompte";

            $stmt = $db->prepare($query);
            $stmt->execute(
                array(
                    ':idCompte' => $_SESSION["id"]
                )
            );
            $compte = $stmt->fetch();

            ?>

            <form method="post" action="../PHP/updateCompte.php">


                <div class="field">
                    <input type="text" name="surname" id="surname" value="<?php echo $compte["prenom"] ?>" required
                        placeholder="">
                    <label for="">Prénom</label>
                </div>

                <div class="field">
                    <input type="text" name="name" id="name" value="<?php echo $compte["nom"]; ?>" required
                        placeholder="">
                    <label for="">Nom</label>
                </div>

                <div class="field">
                    <input type="date" name="date" id="date" value="<?php echo $compte["naissance"] ?>" required
                        placeholder="">
                    <label for="">Date de naissance</label>
                </div>

                <div class="field">
                    <input type="text" name="address" id="address" value="<?php echo $compte["adresse"] ?>" required
                        placeholder="">
                    <label for="">Adresse</label>
                </div>

                <div class="field">
                    <input type="email" name="email" id="email" value="<?php echo $compte["mail"] ?>" required
                        placeholder="">
                    <label for="">Mail</label>
                </div>

                <div class="field">
                    <input type="tel" name="tel" id="tel" value="<?php echo $compte["tel"] ?>"
                        pattern="^(\+33|0)[1-9](\s?\d{2}){4}$" required placeholder="">
                    <label for="">Téléphone</label>

                </div>


                <button>Modifier mon compte</button>

            </form>




        </section>



        <section class="tarif">

            <h2>Abonnements</h2>

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

            <p class="warning">
                Une fois votre abonnement commandé, vous le réglerez sur place.
            </p>



            <form action="../PHP/addMembership.php" method="post">

                <select name="typeAdhesion" id="typeAdhesionSelect" required>

                    <option value="" disabled selected>Choisir un abonnement</option>

                    <?php

                    foreach ($typeAdhesion as $row) {
                        echo "<option value=' " . $row["id"] . " '> " . $row["libelle"] . " - " . $row["prix"] . "€ </option>";
                    }

                    ?>

                </select>


                <select name="enfantMember" id="enfantMemberSelect">

                    <option value="" disabled selected>Enfant concerné</option>

                    <?php

                    foreach ($famillyMember as $row) {
                        if ($row["age"] <= 12) {
                            echo "<option value=' " . $row["id"] . " '> " . $row["nom"] . " - " . $row["prenom"] . " </option>";
                        }
                    }

                    ?>
                </select>

                <select name="Member" id="memberSelect">

                    <option value="" disabled selected>Personne concerné</option>

                    <?php

                    foreach ($famillyMember as $row) {
                        echo "<option value=' " . $row["id"] . " '> " . $row["nom"] . " - " . $row["prenom"] . " </option>";

                    }

                    ?>
                </select>

                <div id="radios">
                    <div>

                        <input type="radio" name="Who" id="ForMe" value="1" checked>
                        <label for="ForMe">Pour moi</label>
                    </div>
                    <div>
                        <input type="radio" name="Who" id="ForOther" value="2">
                        <label for="ForOther">Pour mon enfant</label>
                    </div>
                </div>

                <select name="memberOneDay" id="MemberOneDaySelect">

                    <option value="" disabled selected>Personne concerné</option>

                    <?php

                    foreach ($famillyMember as $row) {
                        if ($row["age"] <= 12) {
                            echo "<option value=' " . $row["id"] . " '> " . $row["nom"] . " - " . $row["prenom"] . " </option>";
                        }
                    }

                    ?>

                </select>


                <button type="submit">Commander cet abonnement</button>

            </form>

        </section>


        <section class="abonnement">


            <h2>Mes Abonnements</h2>

            <div class="allAbonnements">


                <?php
                $query = "select 'a' as origine, a.id, t.libelle, a.created_at as date, verifyMemberShipValidity(a.payed_at, t.duree) as validity,  t.id as idType, a.payed_at as payed, t.duree
                from adhesion a 
                join type_adhesion t on t.id = a.fk_type_adhesion
                where fk_compte = :idCompte";


                $stmt = $db->prepare($query);
                $stmt->execute(
                    array(
                        ':idCompte' => $_SESSION["id"]
                    )
                );
                $adhesion = $stmt->fetchAll();




                $query = "select 'ap' as origine, ap.id, t.libelle, mf.nom, mf.prenom, ap.created_at as date, verifyMemberShipValidity(ap.payed_at, t.duree) as validity, t.id as idType, ap.payed_at as payed, t.duree
                from adhesion_parrainee ap
                join type_adhesion t on t.id = ap.fk_type_adhesion
                join membre_famille mf on mf.id = ap.fk_membre_famille
                where fk_compte = :idCompte;";

                $stmt = $db->prepare($query);
                $stmt->execute(
                    array(
                        ':idCompte' => $_SESSION["id"]
                    )
                );
                $adhesionParrainee = $stmt->fetchAll();



                $allAdhesion = array_merge($adhesion, $adhesionParrainee);

                usort($allAdhesion, function ($a, $b) {
                    return strtotime($b["date"]) <=> strtotime($a["date"]);
                });



                foreach ($allAdhesion as $row) {


                    $payed = new DateTime($row["payed"]);
                    $duree = (int) $row["duree"];
                    $payed->modify("+{$duree} days");

                    $unvalidity = $payed->format("d-m-Y");
                    $payedFormat = $payed->format("d-m-Y");

                    $datetime = new DateTime($row["date"]);
                    $commandformatted = "le " . $datetime->format("d-m-Y") . " à " . $datetime->format("H:i:s");


                    if ($row["idType"] == 1) {

                        if ($row["validity"] == "inactif") {

                            $button = '
                                <a href="../PHP/deleteAdhesion.php?adsId=' . $row["id"] . ' " class="delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                        fill="none">
                                        <path
                                            d="M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6M14 10V17M10 10V17"
                                            stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                                ';
                            $status = "
                            
                                <div class='status'>
                                    <span>Inactif</span>
                                    <div class='circle in'></div>
                                </div>
                            
                            ";

                            $date = '

                                <div class="bottom">
                                    <p>Commandé ' . $commandformatted . '</p>
                                </div>

                                ';


                        } else if ($row["validity"] == "actif") {

                            $button = '';

                            $status = "
                            
                                <div class='status'>
                                    <span>Actif</span>
                                    <div class='circle ac'></div>
                                </div>
                            
                            ";

                            $date = "

                                    <div class='bottom'>
                                        <p>Acheté le " . $payedFormat . "</p>
                                        <p>Valable jusqu'au " . $unvalidity . " </p>
                                    </div>

                                ";

                        } else {

                            $button = '';
                            $status = "
                            
                                <div class='status'>
                                    <span>Expiré</span>
                                    <div class='circle ex'></div>
                                </div>
                            
                            ";
                            $date = "

                                    <div class='bottom'>
                                        <p>Acheté le " . $payedFormat . "</p>
                                        <p>Valable jusqu'au " . $unvalidity . " </p>
                                    </div>

                                ";

                        }




                        echo "
                        
                        <div class='box'>

                            " . $button . "

                            <div class='top'>
                                <h3>Abonnement <span>" . $row['libelle'] . "</span></h3>
                                <h5>Pour Vous</h5>
                            </div>

                            " . $date . "

                            " . $status . "
                        </div>

                        ";

                    }


                    if ($row["idType"] == 2) {


                        if ($row["validity"] == "inactif") {
                            $button = '
                                <a href="../PHP/deleteAdhesionParrainer.php?adsId=' . $row["id"] . ' " class="delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                        fill="none">
                                        <path
                                            d="M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6M14 10V17M10 10V17"
                                            stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                            ';

                            $status = "
                            
                                <div class='status'>
                                    <span>Inactif</span>
                                    <div class='circle in'></div>
                                </div>
                            
                            ";

                            $date = '
                                <div class="bottom">
                                    <p>Commandé ' . $commandformatted . '</p>
                                </div>
                            ';

                        } else if ($row["validity"] == "actif") {
                            $button = '';

                            $status = "
                            
                                <div class='status'>
                                    <span>Actif</span>
                                    <div class='circle ac'></div>
                                </div>
                            
                            ";

                            $date = "
                                <div class='bottom'>
                                        <p>Acheté le " . $payedFormat . "</p>
                                        <p>Valable jusqu'au " . $unvalidity . " </p>
                                    </div>
                            ";

                        } else {
                            $button = '';

                            $status = "
                            
                                <div class='status'>
                                    <span>Expiré</span>
                                    <div class='circle ex'></div>
                                </div>
                            
                            ";

                            $date = "
                                <div class='bottom'>
                                        <p>Acheté le " . $payedFormat . "</p>
                                        <p>Valable jusqu'au " . $unvalidity . " </p>
                                    </div>
                            ";

                        }






                        echo "<div class='box'>

                                " . $button . "

                                <div class='top'>
                                    <h3>Abonnement <span>" . $row["libelle"] . "</span></h3>
                                    <h5>Pour " . $row["prenom"] . " " . $row["nom"] . "</h5>
                                </div>

                                " . $date . "


                                " . $status . "
                            </div>";

                    }


                    if ($row["idType"] == 3) {



                        if ($row["validity"] == "inactif") {
                            $button = '
                                <a href="../PHP/deleteAdhesion.php?adsId=' . $row["id"] . ' " class="delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                        fill="none">
                                        <path
                                            d="M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6M14 10V17M10 10V17"
                                            stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                                ';


                            $status = '
                                    <div class="status">
                                    <span>Inactif</span>
                                    <div class="circle in"></div>
                                </div>
                                ';

                            $date = '

                                <div class="bottom">
                                    <p>Commandé ' . $commandformatted . '</p>
                                </div>

                                ';

                        } else if ($row["validity"] == "actif") {
                            $button = '';
                            $status = '
                                    <div class="status">
                                    <span>Actif</span>
                                    <div class="circle ac"></div>
                                </div>
                                ';

                            $date = "

                                    <div class='bottom'>
                                        <p>Acheté le " . $payedFormat . "</p>
                                        <p>Valable jusqu'au " . $unvalidity . " </p>
                                    </div>

                                ";

                        } else {
                            $button = '';
                            $status = '
                                    <div class="status">
                                    <span>Expiré</span>
                                    <div class="circle ex"></div>
                                </div>
                                ';
                            $date = "

                                    <div class='bottom'>
                                        <p>Acheté le " . $payedFormat . "</p>
                                        <p>Valable jusqu'au " . $unvalidity . " </p>
                                    </div>

                                ";
                        }

                        echo '
                        
                        
                            <div class="box">

                                '
                            .

                            $button
                            .

                            '

                                <div class="top">
                                    <h3>Abonnement <span>' . $row["libelle"] . '</span></h3>
                                    <div class="concerner">
                                        ';



                        foreach ($famillyMember as $member) {

                            if ($member["role"] == "vous") {
                                echo " <h5> Pour vous </h5>";
                            } else {
                                echo " <h5> Pour " . $member['prenom'] . " " . $member['nom'] . '</h5>';
                            }
                        }
                        echo '
                                    </div>
                                </div>
                                '
                            .
                            $date
                            .
                            '
                                    '
                            .
                            $status
                            .
                            '
                            </div>
                        ';

                    }

                    if ($row["idType"] == 4) {


                        if ($row["origine"] == "a") {
                            $pour = 'Pour vous';

                            $url = '../PHP/deleteAdhesion.php?adsId=' . $row["id"];


                        } else {
                            $pour = 'Pour ' . $row["prenom"] . ' ' . $row["nom"];

                            $url = '../PHP/deleteAdhesionParrainer.php?adsId=' . $row["id"];
                        }


                        if ($row["validity"] == "inactif") {

                            $button = '
                                <a href="'. $url .'" class="delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                        fill="none">
                                        <path
                                            d="M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6M14 10V17M10 10V17"
                                            stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                                ';


                            $date = '

                                <div class="bottom">
                                    <p>Commandé ' . $commandformatted . '</p>
                                </div>

                                ';


                            $status = '
                                    <div class="status">
                                    <span>Inactif</span>
                                    <div class="circle in"></div>
                                </div>
                                ';




                        } else if ($row["validity"] == "actif") {

                            $button = '';

                            $date = "

                                    <div class='bottom'>
                                        <p>Acheté le " . $payedFormat . "</p>
                                        <p>Valable jusqu'au " . $unvalidity . " </p>
                                    </div>

                                ";


                            $status = '
                                    <div class="status">
                                    <span>Actif</span>
                                    <div class="circle ac"></div>
                                </div>
                                ';


                        } else {

                            $button = '';

                            $date = "

                                    <div class='bottom'>
                                        <p>Acheté le " . $payedFormat . "</p>
                                        <p>Valable jusqu'au " . $unvalidity . " </p>
                                    </div>

                                ";

                            $status = '
                                    <div class="status">
                                    <span>Expiré</span>
                                    <div class="circle ex"></div>
                                </div>
                                ';
                        }







                        echo '
                        
                            <div class="box">

                                ' . $button . '

                                <div class="top">
                                    <h3>Abonnement <span>Pass une journée</span></h3>
                                    ' . $pour . '
                                </div>

                                ' . $date . '


                                ' . $status . '
                            </div>

                        ';

                    }
                }
                ?>























































                <!-- <div class="box">

                    <a href="" class="delete">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                            fill="none">
                            <path
                                d="M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6M14 10V17M10 10V17"
                                stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>

                    <div class="top">
                        <h3>Abonnement <span>Annuel famille</span></h3>
                        <div class="concerner">
                            <h5>Pour Vous</h5>
                            <h5>Pour Truc Machin</h5>
                            <h5>Pour Truc Machin</h5>
                            <h5>Pour Truc Machin</h5>
                        </div>
                    </div>

                    <div class="bottom">
                        <p>Commandé le 20/11/2022</p>
                    </div>

                    <div class="status">
                        <span>Inactif</span>
                        <div class="circle in"></div>
                    </div>
                </div>


                <div class="box">
                    <div class="top">
                        <h3>Abonnement <span>Annuel famille</span></h3>
                    </div>

                    <div class="bottom">
                        <p>Acheter le 30/11/2022</p>
                        <p>Valable jusqu'au 30/11/2023</p>
                    </div>

                    <div class="status">
                        <span>Actif</span>
                        <div class="circle ac"></div>
                    </div>
                </div>


                <div class="box">
                    <div class="top">
                        <h3>Abonnement <span>Annuel famille</span></h3>
                    </div>

                    <div class="bottom">
                        <p>Acheter le 30/11/2022</p>
                        <p>Valable jusqu'au 30/11/2023</p>
                    </div>

                    <div class="status">
                        <span>Expiré</span>
                        <div class="circle ex"></div>
                    </div>
                </div>




                <div class="box">
                    <div class="top">
                        <h3>Abonnement <span>Annuel adulte</span></h3>
                        <h5>Pour Vous</h5>
                    </div>


                    <div class="status">
                        <span>Actif</span>
                        <div class="circle in"></div>
                    </div>
                </div>


                <div class="box">
                    <div class="top">
                        <h3>Abonnement <span>Annuel adulte</span></h3>
                        <h5>Pour Vous</h5>
                    </div>

                    <div class="bottom">
                        <p>Acheter le 30/11/2022</p>
                        <p>Valable jusqu'au 30/11/2023</p>
                    </div>

                    <div class="status">
                        <span>Actif</span>
                        <div class="circle ac"></div>
                    </div>
                </div>


                <div class="box">
                    <div class="top">
                        <h3>Abonnement <span>Annuel adulte</span></h3>
                        <h5>Pour Vous</h5>
                    </div>

                    <div class="bottom">
                        <p>Acheter le 30/11/2022</p>
                        <p>Valable jusqu'au 30/11/2023</p>
                    </div>

                    <div class="status">
                        <span>Expiré</span>
                        <div class="circle ex"></div>
                    </div>
                </div>




                <div class="box">
                    <div class="top">
                        <h3>Abonnement <span>Annuel enfant</span></h3>
                        <h5>Pour truc machin</h5>
                    </div>

                    <div class="bottom">
                        <p>commander le 30/11/2022</p>
                    </div>


                    <div class="status">
                        <span>Inactif</span>
                        <div class="circle in"></div>
                    </div>
                </div>

                <div class="box">
                    <div class="top">
                        <h3>Abonnement <span>Annuel enfant</span></h3>
                        <h5>Pour truc machin</h5>
                    </div>

                    <div class="bottom">
                        <p>Acheter le 30/11/2022</p>
                        <p>Valable jusqu'au 30/11/2023</p>
                    </div>


                    <div class="status">
                        <span>Actif</span>
                        <div class="circle ac"></div>
                    </div>
                </div>

                <div class="box">
                    <div class="top">
                        <h3>Abonnement <span>Annuel enfant</span></h3>
                        <h5>Pour truc machin</h5>
                    </div>

                    <div class="bottom">
                        <p>Acheter le 30/11/2022</p>
                        <p>Valable jusqu'au 30/11/2023</p>
                    </div>


                    <div class="status">
                        <span>Exprier</span>
                        <div class="circle ex"></div>
                    </div>
                </div>







                <div class="box">
                    <div class="top">
                        <h3>Abonnement <span>Pass une journée</span></h3>
                        <h5>Pour truc machin</h5>
                    </div>

                    <div class="bottom">
                        <p>commander le 30/11/2022</p>
                    </div>


                    <div class="status">
                        <span>Inactif</span>
                        <div class="circle in"></div>
                    </div>
                </div>

                <div class="box">
                    <div class="top">
                        <h3>Abonnement <span>Pass une journée</span></h3>
                        <h5>Pour truc machin</h5>
                    </div>

                    <div class="bottom">
                        <p>Acheter le 30/11/2022</p>
                        <p>Valable jusqu'au 30/11/2023</p>
                    </div>


                    <div class="status">
                        <span>Actif</span>
                        <div class="circle ac"></div>
                    </div>
                </div>

                <div class="box">
                    <div class="top">
                        <h3>Abonnement <span>Pass une journée</span></h3>
                        <h5>Pour Vous</h5>
                    </div>

                    <div class="bottom">
                        <p>Acheter le 30/11/2022</p>
                        <p>Valable jusqu'au 30/11/2023</p>
                    </div>


                    <div class="status">
                        <span>Actif</span>
                        <div class="circle ac"></div>
                    </div>
                </div>

                <div class="box">
                    <div class="top">
                        <h3>Abonnement <span>Pass une journée</span></h3>
                        <h5>Pour truc machin</h5>
                    </div>

                    <div class="bottom">
                        <p>Acheter le 30/11/2022</p>
                        <p>Valable jusqu'au 30/11/2023</p>
                    </div>


                    <div class="status">
                        <span>Exprier</span>
                        <div class="circle ex"></div>
                    </div>
                </div>



 -->

            </div>


        </section>


    </div>


</body>

<script defer>
    const addMemberForm = document.getElementById("addMemberForm");

    const typeAdhesionSelect = document.getElementById("typeAdhesionSelect");
    const enfantMemberSelect = document.getElementById("enfantMemberSelect");
    const memberSelect = document.getElementById("memberSelect");

    const MemberOneDaySelect = document.getElementById("MemberOneDaySelect");

    const radios = document.getElementById("radios");
    const radiosInput = document.querySelectorAll('input[name="Who"]');

    const annAddMember = document.getElementById("annAddMember");

    function toggleAddMemberForm() {
        addMemberForm.classList.toggle("active");
    }

    typeAdhesionSelect.addEventListener('change', () => {
        const value = typeAdhesionSelect.value;
        console.log(value);

        if (value == 1) {
            radios.style.display = "none";
            enfantMemberSelect.style.display = "none";
            memberSelect.style.display = "none";
            MemberOneDaySelect.style.display = "none"
        }
        if (value == 2) {
            // enfantMember
            enfantMemberSelect.style.display = "flex";
            memberSelect.style.display = "none";
            radios.style.display = "none";
            MemberOneDaySelect.style.display = "none"
        }
        if (value == 3) {
            radios.style.display = "none";
            enfantMemberSelect.style.display = "none";
            memberSelect.style.display = "none";
            MemberOneDaySelect.style.display = "none"
        }
        if (value == 4) {
            enfantMemberSelect.style.display = "none";
            memberSelect.style.display = "none";
            radios.style.display = "flex";
        }
    })

    radiosInput.forEach(radio => {
        radio.addEventListener('change', () => {
            const radioValue = document.querySelector('input[name="Who"]:checked').value;
            const selectValue = typeAdhesionSelect.value;

            if (selectValue == 4) {
                if (radioValue == 1) {
                    MemberOneDaySelect.style.display = "none";
                } else {
                    MemberOneDaySelect.style.display = "flex";
                }
            }

            console.log("Valeur sélectionnée :", radioValue);
        });
    });

    annAddMember.addEventListener("click", (e) => {
        e.preventDefault();
        addMemberForm.classList.remove("active");
    })


</script>

</html>