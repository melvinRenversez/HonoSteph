<?php 


include("php/database.php");

$query = "select libelle, prix, description from typeAdhesion;";
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

   body {
      height: 100dvh;
      display: flex;

      flex-direction: column;
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

   section.logo {
      display: flex;
      flex-direction: column;
      gap: 10px;

      align-items: center;

      margin-top: 20px;
   }

   section.logo img {
      width: 250px;

      filter:
         drop-shadow(0 0 5px #fff) drop-shadow(0 0 15px #fff) drop-shadow(0 0 25px rgba(170, 28, 146, 0.6))
         /* léger violet */
         drop-shadow(0 0 40px rgba(170, 28, 146, 0.4));
      /* très subtil */

   }

   section.info {
      display: flex;
      flex: 1;
   }

   .modif,
   .add,
   .abonnements {
      flex: 1;

      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
   }

   .content {
      flex: 1;
      /* background: red; */

      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: space-evenly;
   }



   h2 {

      color: white;
      margin-bottom: 20px;
   }

   form {
      display: flex;
      flex-direction: column;

      gap: 50px;

      width: 30%;

      min-width: 400px;
   }

   form .field {
      position: relative;

      /* background: red; */
   }

   form .field label {

      position: absolute;

      left: 5px;
      bottom: 10px;

      font-size: 20px;
      color: white;

      transition: 0.4s ease bottom;
   }

   form .field.spec label {
      bottom: 100%;
   }

   form .field input {
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

   form .field input:focus~label,
   form .field input:not(:placeholder-shown)~label,
   form .field:hover label {
      bottom: 100%;
      transition: bottom 0.4s ease;
   }

   form select {
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

   form select:focus {
      border-color: #fff;
      outline: none;
   }

   form option {
      background-color: #222;
      /* fond du menu déroulant sous Firefox */
      color: white;
      padding: 10px;
      cursor: pointer;
   }


   form button {
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

   form button:hover {
      background-color: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(12px);
   }

   .left {
      border-right: 1px solid #aaa;
   }



   table,
   th,
   td {
      border-collapse: collapse;

      border: 1px solid #fff;
      color: white;

      font-size: 20px;

      padding: 10px 20px;

   }

   .decconnect {
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

   .decconnect:hover {
      background-color: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(12px);
   }

   .abonnements .content{
      width: 80%;

      justify-content: start;

      gap: 30px;

      margin-top: 50px;
   }

   .card{
      border: 1px solid white;

      background-color: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(12px);

      color: white;

      width: 100%;

      padding: 20px;

      border-radius: 7px;

      height: 150px;

      display: flex;
      flex-direction: column;
   }

   .gap{
      flex: 1;
   }

</style>

<body>

   <a class="decconnect" href="./index.php">
      Déconnexion
   </a>

   <section class="logo">
      <img src="./assets/logo.png" alt="">
   </section>


   <div class="trailer">
      <video src="./assets/Full Trailer.mp4" autoplay loop muted></video>
   </div>

   <div class="overlay"></div>
   </div>

   <section class="info">


      <div class="modif left">
         <h2>Modifier mon Compte</h2>

         <div class="content">
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
                  <label for="address">Adresse</label>
               </div>

               <div class="field">
                  <input type="email" name="mail" id="mail" placeholder="">
                  <label for="mail">Mail</label>
               </div>

               <div class="field">
                  <input type="tel" name="tel" id="tel" placeholder="">
                  <label for="tel">Téléphone</label>
               </div>

               <button>Modifier</button>
            </form>
         </div>
      </div>


      <div class="add left">

         <h2>Ajouter un abonnement</h2>

         <div class="content">


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


            <form action="">
               <select name="" id="">
                  <option value="">Type d'adhésion</option>

                  <?php 
   
                  foreach ($rowsAdhesion as $row) {
                     echo "<option>" . $row["libelle"] . " - " . $row["prix"] . "€</option>";
                  };
   
   ?>

               </select>

               <button>Ajouter cet abonnement</button>
            </form>
         </div>

      </div>

      <div class="abonnements">

         <h2>Mes Abonnements</h2>

         <div class="content">

            <div class="card">
               <h3>Abonnement - Famille anuel</h3>
               <h4>accheter le 30/11/2022</h4>

               <div class="gap"></div>

               <p>Valable jusqu'au 30/11/2023</p>

            </div>

            <div class="card">
               <h3>Abonnement - Famille anuel</h3>
               <h4>ajouter le 30/11/2022</h4>

               <div class="gap"></div>

               <p>en attente de payant</p>
               <p>Le payement se fait sur place</p>
               
            </div>

         </div>

   </section>

</body>

</html>