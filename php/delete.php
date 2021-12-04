<?php
    session_start();
    if(!$_SESSION["loggedInBlank"]){
        header("Location: index.php");
        die();
    }

    if(isset($_GET["in"]) && $_GET["name"]) {
        $server = "localhost";
        $uname = "root";
        $pass = "";
        $db = "blank";
        $a = mysqli_connect($server, $uname, $pass, $db);
        $que = "DELETE FROM notes WHERE (id = " . $_SESSION["userId"] . " AND inside = '" . $_GET["in"] . "' AND name = '" . $_GET["name"] . "')";
        mysqli_query($a,$que);
    }
    header("Location: panel.php");
    die();