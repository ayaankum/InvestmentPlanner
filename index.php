<?php

?>


<html>

<head>
    <title>Investment Calculator</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link type="text/css" rel="stylesheet" href="css/style.css">
</head>
<style>
    body {
        background-image: url("img/Background.jpg");
        margin: 0;
        padding: 0;
        font-family: New Century Schoolbook, TeX Gyre Schola, serif;
        background-size: cover;
    }

    .heading h1 {
        color: white;
        font-size: 50px;
        font-style: normal;
        font-family: Garamond, serif;
        padding-right: 40px;
        padding-bottom: 10px;
        float: right;
        padding-top: 70px;
        border-bottom: 1px white;
    }

    .heading:hover {
        color: white;
        transition: 0.3s ease;
    }

    .footer {
        color: grey;
        font-size: 10px;
        font-family: Arial;
        position: absolute;
        bottom: 15px;
        right: 45px;

    }

    .centered {
        position: fixed;
        /* or absolute */
        top: 25%;
        left: 78%;
    }

    .buttonblock {
        border-radius: 25px;
        border-color: white;
        width: 100%;
        padding: 10px 18px;
        background-color: #Fdfff5;
        font-size: 16px;
        cursor: pointer;
        font-style: bold;
        font-family: Arial, sans-serif;
        text-align: center;
    }
</style>

<body>
    <div class="heading">
        <h1>Investments Calculator</h1>
    </div>
    <div class="centered">
        <a href="login.php">
            <input type="button" class="buttonblock" value="Get Started">
        </a>
    </div>
    <div class="footer">
        All rights reserved @ Amandeep & Amulya</a>
    </div>
</body>

</html>