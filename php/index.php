<?php
    session_start();
    $alert = "";

    if(isset($_COOKIE["cEmail"])) {
        $server = "localhost";
        $uname = "root";
        $pass = "";
        $db = "blank";
        $a = mysqli_connect($server, $uname, $pass, $db);
        $quer = "SELECT * FROM users WHERE email='" . $_COOKIE["cEmail"] . "'";
        $result = mysqli_query($a, $quer);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($row["password"] == $_COOKIE["cPass"]) {
                $_SESSION["loggedInBlank"] = true;
                $_SESSION["blankUserName"] = $row["name"];
                $_SESSION["userId"] = $row["id"];
                $_SESSION["lay"] = $row["layout"];
                header("Location: panel.php");
                die();
            }
        }
    }

    if(isset($_GET["failed"])) {
        if($_GET["failed"] == "missing") $alert = "کمبود";
        else if($_GET["failed"] == "notfound") $alert = "اشتباه";
    }

    else if(isset($_GET["btn"])){
        if (!isset($_GET["email"]) || $_GET["email"] === "" || !isset($_GET["password"]) || $_GET["password"] === "") {
            header("Location: index.php?failed=missing");
            die();
        }

        $server = "localhost";
        $uname = "root";
        $pass = "";
        $db = "blank";
        $a = mysqli_connect($server, $uname, $pass, $db);
        $quer = "SELECT * FROM users WHERE email='" . $_GET["email"] . "'";
        $result = mysqli_query($a, $quer);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($row["password"] == $_GET["password"]) {
                setcookie("cEmail",$_GET["email"],time() + 60*60);
                setcookie("cPass",$_GET["password"],time() + 60*60);
                $_SESSION["loggedInBlank"] = true;
                $_SESSION["blankUserName"] = $row["name"];
                $_SESSION["userId"] = $row["id"];
                $_SESSION["lay"] = $row["layout"];
                header("Location: panel.php");
                die();
            }
            else {
                header("Location: index.php?failed=notfound");
                die();
            }
        }
        else {
            header("Location: index.php?failed=notfound");
            die();
        }
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="../css/main.css?version=<?php echo time();?>">
    <script src="../js/jquery.js"></script>
    <script src="../js/main.js?version=<?php echo time();?>"></script>
</head>
<body>
<div id="hold">
    <form action="index.php" autocomplete="off">
        <ul>
            <li id="sign" class="item">
                ورود
            </li>
            <li id="alert" class="item">
                <?php echo $alert; ?>
            </li>
            <li class="item">
                <input class="input" type="text" id="email" name="email" placeholder="ایمیل">
            </li>
            <li class="item">
                <div class="margb" id="eye"></div>
                <input class="input margb" type="password" id="password" name="password" placeholder="رمز عبور">
            </li>
            <li class="item">
                <input class="btn" id="log" type="submit" name="btn" value="ورود">
                <a href="signUp.php">
                    <input class="btn" id="sin" type="button" value="ثبت نام">
                </a>
            </li>
        </ul>
    </form>
</div>
</body>
</html>