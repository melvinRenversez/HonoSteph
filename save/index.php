<?php


include("php/database.php");

$query = "select libelle, prix, description from type_adhesion;";
$result = $db->query($query);

$rowsAdhesion = $result->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>

<style>
   * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;

      /* Épaisseur de la barre */
      scrollbar-width: thin;
      /* options: auto | thin | none */

      /* Couleurs : (thumb, track) */
      scrollbar-color: rgba(170, 28, 146, 1) #111;

      font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
   }

   ::-webkit-scrollbar {
      width: 5px;
      background-color: #111;
   }

   ::-webkit-scrollbar-track {
      background: #111;
      border-radius: 10px;
      box-shadow: inset 0 0 5px rgba(170, 28, 146, 0.5);
   }

   ::-webkit-scrollbar-thumb {
      background: linear-gradient(45deg, rgba(170, 28, 146, 1) 0%, rgba(77, 51, 149, 1) 100%);
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(170, 28, 146, 1), 0 0 20px rgba(77, 51, 149, 1);
   }

   ::-webkit-scrollbar-thumb:hover {
      filter: brightness(1.2);
      box-shadow: 0 0 15px rgba(170, 28, 146, 1), 0 0 25px rgba(77, 51, 149, 1);
   }

   /* Variante : effet dégradé sur Firefox via fallback */
   @supports not selector(::-webkit-scrollbar) {
      * {
         scrollbar-color: #aa1c92 #111;
      }
   }


   body {
      display: flex;
      justify-content: center;

   }

   .trailer {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100dvh;

      background: #AA1C92;
      background: linear-gradient(45deg, rgba(170, 28, 146, 1) 0%, rgba(77, 51, 149, 1) 100%);

      z-index: -2;
   }

   .overlay {

      position: fixed;
      top: 0;
      left: 0;

      width: 100%;
      height: 100dvh;

      background: rgba(0, 0, 0, 0.7);

      z-index: -1;
   }

   .trailer video {
      width: 100%;
      height: 100%;
      object-fit: cover;
   }

   .content {
      /* background: rgba(255, 255, 255, 0.6); */
      width: 50%;

      display: flex;
      flex-direction: column;

      gap: 30px;
   }

   section {
      display: flex;
      flex-direction: column;
      gap: 10px;

      align-items: center;

      margin-top: 40px;
   }

   h2 {
      margin-bottom: 50px;
      font-size: 50px;
      color: white;
   }

   section.logo img {
      width: 450px;

      filter:
         drop-shadow(0 0 5px #fff) drop-shadow(0 0 15px #fff) drop-shadow(0 0 25px rgba(170, 28, 146, 0.6))
         /* léger violet */
         drop-shadow(0 0 40px rgba(170, 28, 146, 0.4));
      /* très subtil */

   }

   section.Presentation p {
      font-size: 25px;
      color: white;

      text-align: center;
   }

   section.horaires table,
   section.horaires th,
   section.horaires td {
      border-collapse: collapse;
      padding: 15px;
      width: min-content;
   }

   section.horaires tr th,
   section.horaires tr td {
      border-left: 2px solid #fff;
      color: white;
      font-size: 20px;
   }

   section.horaires tr th:first-child,
   section.horaires tr td:first-child {
      border-left: none !important;
   }

   tr {
      white-space: nowrap;
   }

   section.tarif table,
   section.tarif th,
   section.tarif td {
      border-collapse: collapse;
      width: min-content;
      border: 1px solid #fff;
      color: white;

      font-size: 20px;

      padding: 20px 30px;

   }

   section.inscription p {
      font-size: 25px;

      color: white;

      text-align: center;

      margin-bottom: 50px;
   }

   .warning {
      color: rgb(202, 39, 39) !important;
   }

   section.inscription form {
      display: flex;
      flex-direction: column;

      gap: 50px;

      /* background: green; */

      width: 40%;

      min-width: 400px;
   }

   section.inscription form .field {
      position: relative;

      /* background: red; */
   }

   section.inscription form .field label {

      position: absolute;

      left: 5px;
      bottom: 10px;

      font-size: 20px;
      color: white;

      transition: 0.4s ease bottom;
   }

   section.inscription form .field.spec label {
      bottom: 100%;
   }

   section.inscription form .field input {
      padding: 10px;
      font-size: 15px;
      background: transparent;
      border: none;
      border-bottom: 1px solid #fff;

      color: white;

      width: 100%;

      outline: none;
   }

   input[type="date"]::-webkit-calendar-picker-indicator {
      filter: brightness(0) invert(1);
      /* rend l'icône blanche */
   }

   section.inscription form .field input:focus~label,
   section.inscription form .field input:not(:placeholder-shown)~label,
   section.inscription form .field:hover label {
      bottom: 100%;
      transition: bottom 0.4s ease;
   }

   section.inscription form select {
      padding: 10px 15px;
      border-radius: 7px;
      color: white;
      border: 1px solid #aaa;
      cursor: pointer;
      background: rgba(255, 255, 255, 0.1);
      /* fond transparent flouté */
      backdrop-filter: blur(12px);
      font-size: 1rem;

      /* Désactive le style natif du navigateur */
      appearance: none;
      -webkit-appearance: none;
      /* Chrome, Safari */
      -moz-appearance: none;
      /* Firefox */
      background-image: url("data:image/svg+xml;utf8,<svg fill='white' height='14' viewBox='0 0 24 24' width='14' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
      background-repeat: no-repeat;
      background-position: right 10px center;
   }

   section.inscription form select:focus {
      border-color: #fff;
      outline: none;
   }

   section.inscription form option {
      background-color: #222;
      /* fond du menu déroulant sous Firefox */
      color: white;
      padding: 10px;
      cursor: pointer;
   }


   section.inscription form button {
      padding: 12px;

      font-size: 1rem;

      background-color: transparent;
      color: white;

      border: none;

      border-radius: 5px;

      cursor: pointer;

      border: 1px solid #aaa;

      backdrop-filter: blur(0px);
      transition: backdrop-filter 0.2s ease, background 0.2s ease;
   }

   section.inscription form button:hover {
      background-color: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(12px);
   }

   section.urgence {
      margin-bottom: 150px;
   }

   section.urgence p {
      font-size: 25px;
      color: white;
      text-align: center;
   }

   .reseau {
      display: flex;

      gap: 80px;
   }

   .gapb {
      margin-bottom: 30px;
   }

   .tel {
      font-size: 44px;
      text-decoration: none;
      color: white;
   }

   .reseau .field {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
      font-size: 22px;
   }

   .reseau .field {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      text-decoration: none;
      font-size: 22px;
   }

   .reseau .field .logo {
      display: flex;
      align-self: center;
      justify-content: center;
   }

   .reseau .field .logo svg {
      width: 35px;
      height: 35px;
   }

   .modif {
      position: fixed;
      top: 20px;
      right: 20px;

      color: #fff;
      font-size: 20px;

      cursor: pointer;

      z-index: 100000;

      text-decoration: none;

      padding: 12px;

      font-size: 1rem;

      background-color: transparent;
      color: white;

      border: none;

      border-radius: 5px;

      cursor: pointer;

      border: 1px solid #aaa;

      backdrop-filter: blur(0px);
      transition: backdrop-filter 0.2s ease, background 0.2s ease;
   }

   .modif:hover {
      background-color: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(12px);
   }
</style>

<body>

   <a class="modif" href="./login.php">
      Modifier mon Compte
   </a>


   <div class="trailer">
      <video src="./asets/Full Trailer.mp4" autoplay loop muted></video>
   </div>

   <div class="overlay"></div>

   <div class="content">

      <section class="logo">
         <img src="./assets/logo.png" alt="">
      </section>

      <section class="Presentation">
         <h2>Presentation</h2>

         <p>
            Arcade Tour est une association, tenue par un passionne de jeux en tout genres, qui à voulue faire (RE)
            decouvrir aux petits et grands, les grands classiques des bornes d'arcade!
            Si cette experrience vous tente n'hesite pas a vous inscrire pour un pass d'une journee ou a vous abonner
            pour l'annee ci-dessous!
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

         <h2>Tarifes</h2>

         <table>
            <thead>
               <tr>
                  <th>Type d'adhesion</th>
                  <th>Prix</th>
                  <th>Condition</th>
               </tr>
            </thead>

            <tbody>

               <?php
               foreach ($rowsAdhesion as $row) {
                  echo "<tr>";
                  echo "<td>" . $row["libelle"] . "</td>";
                  echo "<td>" . $row["prix"] . "€</td>";
                  echo "<td>" . $row["description"] . "</td>";
                  echo "</tr>";
               }


               ?>

            </tbody>
         </table>
      </section>

      <section class="inscription">

         <h2>Inscription</h2>

         <p>
            Pour votre inscription il vous suffit de remplir le formulaire ci dessous.
            Lors de votre première visite présentez vous à la personne en charge des borne avec votre pièce d'identité,
            celui-ci vous fournira un exemplaire du règlement intérieur de l'association ainsi qu'une carte de membre
            pour les personnes qui ont pris un abonnement pour accéder aux bornes.
         </p>

         <p class="warning">
            Pour le règlement : Celui-ci ce fera par chèque ou par l’appoint en espèce lors de votre première visite au
            bornes.
         </p>

         <form action="">
            <div class="field">
               <input type="text" name="name" id="name" placeholder="">
               <label for="name">Nom</label>
            </div>

            <div class="field">
               <input type="text" name="prenom" id="prenom" placeholder=" ">
               <label for="prenom">Prénom</label>
            </div>

            <div class="field spec">
               <label for="borne">Date de naissance</label>
               <input type="date" name="borne" id="borne" placeholder="">
            </div>

            <div class="field">
               <input type="text" name="address" id="address" placeholder="">
               <label for="address">Address</label>
            </div>

            <div class="field">
               <input type="email" name="mail" id="mail" placeholder="">
               <label for="mail">Mail</label>
            </div>

            <div class="field">
               <input type="tel" name="tel" id="tel" placeholder="">
               <label for="tel">Téléphone</label>
            </div>

            <select name="" id="">
               <option value="">Type d'adhesion</option>

               <?php

               foreach ($rowsAdhesion as $row) {
                  echo "<option>" . $row["libelle"] . " - " . $row["prix"] . "€</option>";
               }
               ;

               ?>

            </select>

            <button>Envoyer mon inscription</button>
         </form>

      </section>

      <section class="urgence">
         <h2>En cas d'urgence</h2>

         <p class="gapb">Si vous avez n’importe quel problème lors de votre inscription ou lors de vos sessions au sein
            de
            l’animation,
            Vous pouvez appelez au :</p>

         <p>

            <a class="tel" href="/tel:0652985786">
               06 52 98 57 86
            </a>

         <p>
            ou
         </p>

         <div class="reseau">
            <a href="https://www.facebook.com/share/17ErZoRGjC/?mibextid=wwXIfr" target="_blank" class="field">
               <div class="logo">
                  <svg width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                  <svg width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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