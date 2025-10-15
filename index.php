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
    }

    body {
        height: 100dvh;
        background: #AA1C92;
        background: linear-gradient(45deg, rgba(170, 28, 146, 1) 0%, rgba(77, 51, 149, 1) 100%);
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
</style>

<body>
    <div class="overlay"></div>


</body>

</html>