<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../assets/css/default.css">
    <link rel="stylesheet" href="../assets/css/login.css">
</head>


<body>


    <div class="trailer">
        <video src="./assets/Full Trailer.mp4" autoplay loop muted></video>
    </div>

    <div class="overlay"></div>
    </div>

    <div class="content">


        <section class="logo">
            <img src="../assets/images/logo.png">
        </section>




        <section class="connection">
            <form action="../PHP/connexion.php" method="post">
                <div class="field">
                    <input type="mail" name="mail" id="mail" placeholder="">
                    <label for="">Mail</label>
                </div>
                <div class="field">
                    <input type="password" name="password" id="password" placeholder="">
                    <label for="">Mot de Passe</label>
                </div>

                <button>Se connecter</button>
            </form>
        </section>


    </div>


</body>

</html>