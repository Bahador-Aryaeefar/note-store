<?php
    session_start();
    if(!isset($_SESSION["userId"]) || !isset($_GET["cont"]) || !isset($_GET["name"])){
        header("Location: panel.php?failed=missing");
        die();
    }

    $server = "localhost";
    $uname = "root";
    $pass = "";
    $db = "blank";
    $a = mysqli_connect($server, $uname, $pass, $db);
    $que = "UPDATE notes SET info='".$_GET["cont"]."' WHERE (id=".$_SESSION["userId"]." AND name='".$_GET["name"]."')";
    echo $que;
    mysqli_query($a,$que);
    header("Location: panel.php?name=".$_GET["name"]);
    die();