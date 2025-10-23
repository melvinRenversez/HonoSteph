<?php
// dans la session seul l'id sera stocker
session_start();
include("./PHP/database.php");

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="./assets/css/default.css">
    <link rel="stylesheet" href="./assets/css/index.css">

    <script src="./assets/js/popup.js" defer></script>
</head>

<body>

    <?php if (isset($_SESSION["id"])): ?>
        <a class="modif" href="./pages/compte.php">
            Mon Compte
        </a>
        <a class="modif modifD" href="./PHP/logout.php">
            Se déconnecter
        </a>
    <?php else: ?>
        <a class="modif" href="./pages/login.php">
            Se connecter
        </a>
    <?php endif; ?>


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

    <div class="trailer">
        <video src="./assets/Full Trailer.mp4" autoplay loop muted></video>
    </div>

    <div class="overlay"></div>


    <div class="content">

        <section class="logo">
            <img src="./assets/images/logo.png" alt="">
        </section>

        <section class="Presentation">
            <h2>Présentation</h2>

            <p>
                Arcade Tour est une association, tenue par un passionné de jeux en tout genres, qui a voulu faire (RE)
                découvrir aux petits et grands, les grands classiques des bornes d'arcade !
                Si cette expérience vous tente n'hésitez pas à vous inscrire pour obtenir un Pass d'une journée ou à vous
                abonner
                pour l'année ci-dessous !
            </p>
        </section>

        <section class="horaires">

            <h2>Horaires</h2>

            <table class="tbU">
                <thead>
                    <tr>
                        <th>Lundi</th>
                        <th>Mardi</th>
                        <th>Mercredi</th>
                        <th>Jeudi</th>
                        <th>Vendredi</th>
                        <th>Samedi</th>
                        <th>Dimanche</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>09:30 - 12:00</td>
                        <td>09:30 - 12:00</td>
                        <td>09:30 - 12:00</td>
                        <td>09:30 - 12:00</td>
                        <td>09:30 - 12:00</td>
                        <td>09:30 - 12:00</td>
                        <td>09:30 - 12:00</td>
                    </tr>
                    <tr>
                        <td>13:30 - 19:00</td>
                        <td>13:30 - 19:00</td>
                        <td>13:30 - 19:00</td>
                        <td>13:30 - 19:00</td>
                        <td>13:30 - 19:00</td>
                        <td>13:30 - 19:00</td>
                        <td>13:30 - 19:00</td>
                    </tr>
                </tbody>
            </table>
        </section>


        <section class="tarif">

            <h2>Tarifs</h2>

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

                    $query = "SELECT libelle, prix, description FROM type_adhesion;";
                    $stmt = $db->prepare($query);
                    $stmt->execute();
                    $result = $stmt->fetchAll();

                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['libelle'] . "</td>";
                        echo "<td>" . $row['prix'] . "€</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "</tr>";
                    }
                    ?>

                </tbody>
            </table>
        </section>

        <?php if(!isset($_SESSION['id'])): ?>
        <section class="inscription">

            <h2>Inscription</h2>


            <p>
                Pour votre inscription, il vous suffit de remplir le formulaire ci dessous.
                Lors de votre première visite, présentez-vous à la personne en charge des bornes avec votre pièce
                d'identité,
                celui-ci vous fournira un exemplaire du règlement intérieur de l'association ainsi qu'une carte de
                membre
                pour les personnes qui ont pris un abonnement pour accéder aux bornes.
            </p>

            <p class="warning">
                Pour le règlement : Celui-ci se fera par chèque ou par l’appoint en espèces lors de votre première visite
                aux
                bornes.
            </p>

            <form method="post" action="./PHP/inscription.php">


                <div class="field">
                    <input type="text" name="name" id="name" required placeholder="">
                    <label for="">Nom</label>
                </div>

                <div class="field">
                    <input type="text" name="surname" id="surname" required placeholder="">
                    <label for="">Prénom</label>
                </div>

                <div class="field">
                    <input type="date" name="date" id="date" required placeholder="">
                    <label for="">Date de naissance</label>
                </div>

                <div class="field">
                    <input type="text" name="address" id="address" required placeholder="">
                    <label for="">Adresse</label>
                </div>

                <div class="field">
                    <input type="email" name="email" id="email" required placeholder="">
                    <label for="">Mail</label>
                </div>

                <div class="field">
                    <input type="tel" name="tel" id="tel" pattern="^(\+33|0)[1-9](\s?\d{2}){4}$" required placeholder="">
                    <label for="">Téléphone</label>

                </div>

                <div class="field">
                    <input type="password" name="password" id="password" required placeholder="">
                    <label for="">Mot de passe</label>
                </div>


                <button>Créer mon compte</button>

            </form>

        </section>
        <?php endif; ?>



        <section class="urgence">
            <h2>En cas d'urgence</h2>

            <p class="gapb">Si vous avez n’importe quel problème lors de votre inscription ou lors de vos sessions au
                sein
                de
                l’animation,
                vous pouvez appeler au :</p>

            <p>

                <a class="tel" href="tel:0652985786">
                    06 52 98 57 86
                </a>

            <p>
                ou
            </p>

            <div class="reseau">
                <a href="https://www.facebook.com/share/17ErZoRGjC/?mibextid=wwXIfr" target="_blank" class="field">
                    <div class="logo">
                        <svg width="800px" height="800px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="gradWhite" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" style="stop-color:white;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:white;stop-opacity:1" />
                                </linearGradient>
                                <linearGradient id="gradViolet" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:rgba(170,28,146,1)" />
                                    <stop offset="100%" style="stop-color:rgba(77,51,149,1)" />
                                </linearGradient>
                            </defs>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M20 1C21.6569 1 23 2.34315 23 4V20C23 21.6569 21.6569 23 20 23H4C2.34315 23 1 21.6569 1 20V4C1 2.34315 2.34315 1 4 1H20ZM20 3C20.5523 3 21 3.44772 21 4V20C21 20.5523 20.5523 21 20 21H15V13.9999H17.0762C17.5066 13.9999 17.8887 13.7245 18.0249 13.3161L18.4679 11.9871C18.6298 11.5014 18.2683 10.9999 17.7564 10.9999H15V8.99992C15 8.49992 15.5 7.99992 16 7.99992H18C18.5523 7.99992 19 7.5522 19 6.99992V6.31393C19 5.99091 18.7937 5.7013 18.4813 5.61887C17.1705 5.27295 16 5.27295 16 5.27295C13.5 5.27295 12 6.99992 12 8.49992V10.9999H10C9.44772 10.9999 9 11.4476 9 11.9999V12.9999C9 13.5522 9.44771 13.9999 10 13.9999H12V21H4C3.44772 21 3 20.5523 3 20V4C3 3.44772 3.44772 3 4 3H20Z"
                                fill="url(#gradWhite)" />
                        </svg>
                    </div>
                    <p>Facebook</p>
                </a>

                <a href="" class="field">
                    <div class="logo">
                        <svg width="800px" height="800px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M12 18C15.3137 18 18 15.3137 18 12C18 8.68629 15.3137 6 12 6C8.68629 6 6 8.68629 6 12C6 15.3137 8.68629 18 12 18ZM12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16Z"
                                fill="url(#gradWhite)" />
                            <path
                                d="M18 5C17.4477 5 17 5.44772 17 6C17 6.55228 17.4477 7 18 7C18.5523 7 19 6.55228 19 6C19 5.44772 18.5523 5 18 5Z"
                                fill="url(#gradWhite)" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M1.65396 4.27606C1 5.55953 1 7.23969 1 10.6V13.4C1 16.7603 1 18.4405 1.65396 19.7239C2.2292 20.8529 3.14708 21.7708 4.27606 22.346C5.55953 23 7.23969 23 10.6 23H13.4C16.7603 23 18.4405 23 19.7239 22.346C20.8529 21.7708 21.7708 20.8529 22.346 19.7239C23 18.4405 23 16.7603 23 13.4V10.6C23 7.23969 23 5.55953 22.346 4.27606C21.7708 3.14708 20.8529 2.2292 19.7239 1.65396C18.4405 1 16.7603 1 13.4 1H10.6C7.23969 1 5.55953 1 4.27606 1.65396C3.14708 2.2292 2.2292 3.14708 1.65396 4.27606ZM13.4 3H10.6C8.88684 3 7.72225 3.00156 6.82208 3.0751C5.94524 3.14674 5.49684 3.27659 5.18404 3.43597C4.43139 3.81947 3.81947 4.43139 3.43597 5.18404C3.27659 5.49684 3.14674 5.94524 3.0751 6.82208C3.00156 7.72225 3 8.88684 3 10.6V13.4C3 15.1132 3.00156 16.2777 3.0751 17.1779C3.14674 18.0548 3.27659 18.5032 3.43597 18.816C3.81947 19.5686 4.43139 20.1805 5.18404 20.564C5.49684 20.7234 5.94524 20.8533 6.82208 20.9249C7.72225 20.9984 8.88684 21 10.6 21H13.4C15.1132 21 16.2777 20.9984 17.1779 20.9249C18.0548 20.8533 18.5032 20.7234 18.816 20.564C19.5686 20.1805 20.1805 19.5686 20.564 18.816C20.7234 18.5032 20.8533 18.0548 20.9249 17.1779C20.9984 16.2777 21 15.1132 21 13.4V10.6C21 8.88684 20.9984 7.72225 20.9249 6.82208C20.8533 5.94524 20.7234 5.49684 20.564 5.18404C20.1805 4.43139 19.5686 3.81947 18.816 3.43597C18.5032 3.27659 18.0548 3.14674 17.1779 3.0751C16.2777 3.00156 15.1132 3 13.4 3Z"
                                fill="url(#gradWhite)" />
                        </svg>
                    </div>
                    <p>Instagram</p>
                </a>
            </div>

        </section>



    </div>


</body>

</html>