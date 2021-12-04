<?php
    session_start();
    if(!isset($_SESSION["userId"]) || !isset($_GET["name"]) || !isset($_GET["subject"]) || !isset($_GET["type"])){
        header("Location: panel.php?failed=missing");
        die();
    }

    $server = "localhost";
    $uname = "root";
    $pass = "";
    $db = "blank";
    $a = mysqli_connect($server, $uname, $pass, $db);
    $p1 = $_SESSION["userId"];
    $p2 = "main";
    $p3 = $_GET["name"];
    $p4 = $_GET["type"];
    $p5 = $_GET["subject"];
    $que = "INSERT INTO notes (id,inside,name,type,topic) VALUES ('$p1','$p2','$p3','$p4','$p5')";
    if(!mysqli_query($a,$que)){
        header("Location: panel.php?failed=repeat");
        die();
    }
    else{
        header("Location: panel.php");
        die();
    }