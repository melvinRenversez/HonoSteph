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

   section.logo img {
      width: 350px;

      filter:
         drop-shadow(0 0 5px #fff) drop-shadow(0 0 15px #fff) drop-shadow(0 0 25px rgba(170, 28, 146, 0.6))
         /* léger violet */
         drop-shadow(0 0 40px rgba(170, 28, 146, 0.4));
      /* très subtil */

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


   section {
      display: flex;
      flex-direction: column;
      gap: 10px;

      align-items: center;

      margin-top: 40px;
   }

   section.connection {
      margin-top: 100px;
   }

   section.connection form {
      display: flex;
      flex-direction: column;

      gap: 50px;

      width: 30%;

      min-width: 400px;
   }

   section.connection form .field {
      position: relative;

      /* background: red; */
   }

   section.connection form .field label {

      position: absolute;

      left: 5px;
      bottom: 10px;

      font-size: 20px;
      color: white;

      transition: 0.4s ease bottom;
   }

   section.connection form .field.spec label {
      bottom: 100%;
   }

   section.connection form .field input {
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

   section.connection form .field input:focus~label,
   section.connection form .field input:not(:placeholder-shown)~label,
   section.connection form .field:hover label {
      bottom: 100%;
      transition: bottom 0.4s ease;
   }

   section.connection form select {
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

   section.connection form select:focus {
      border-color: #fff;
      outline: none;
   }

   section.connection form option {
      background-color: #222;
      /* fond du menu déroulant sous Firefox */
      color: white;
      padding: 10px;
      cursor: pointer;
   }


   section.connection form button {
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

   section.connection form button:hover {
      background-color: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(12px);
   }


      .pass {
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

   .pass:hover {
      background-color: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(12px);
   }

</style>

<body>

      <a class="pass" href="./modif.php">
      pass
</a>


   <section class="logo">
      <img src="./assets/logo.png" alt="">
   </section>


   <div class="trailer">
      <video src="./assets/Full Trailer.mp4" autoplay loop muted></video>
   </div>

   <div class="overlay"></div>
   </div>

   <section class="connection">
      <form action="" method="post">
         <div class="field">
            <input type="mail" name="mail" id="mail" placeholder="" value="Test.mail@gmail.com">
            <label for="">Mail</label>
         </div>
         <div class="field">
            <input type="password" name="password" id="password" placeholder="" value="TestMDP">
            <label for="">Password</label>
         </div>

         <button>Se connecter</button>
      </form>
   </section>
</body>

</html>