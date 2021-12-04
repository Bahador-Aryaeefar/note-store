<?php
    session_start();
    if(!$_SESSION["loggedInBlank"]){
        header("Location: index.php");
        die();
    }

    setcookie("cEmail",$_GET["email"],time() - 5);
    setcookie("cPass",$_GET["password"],time() - 5);
    session_destroy();
    header("Location: index.php");
