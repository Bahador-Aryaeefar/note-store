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
        if ($_GET["failed"] == "repeat") $alert = "تکرار";
        else if($_GET["failed"] == "missing") $alert = "کمبود";
        else if($_GET["failed"] == "badpass") $alert = "پسورد";
    }
    else if(isset($_GET["btn"])) {
        if( !isset($_GET["name"]) || $_GET["name"]==="" || !isset($_GET["email"]) || $_GET["email"]==="" || !isset($_GET["password"]) || $_GET["password"]==="" || !isset($_GET["repass"])) {
            header("Location: signUp.php?failed=missing");
            die();
        }
        if($_GET["password"] !== $_GET["repass"]) {
            header("Location: signUp.php?failed=badpass");
            die();
        }
        $server = "localhost";
        $uname = "root";
        $pass = "";
        $db = "blank";
        $a = mysqli_connect($server, $uname, $pass, $db);
        $p1 = $_GET["name"];
        $p2 = $_GET["email"];
        $p3 = $_GET["password"];
        $que = "INSERT INTO users (name,email,password) VALUES ('$p1','$p2','$p3')";
        if(!mysqli_query($a,$que))
        {
            header("Location: signUp.php?failed=repeat");
            die();
        }
        setcookie("cEmail",$p2,time() + 60*60);
        setcookie("cPass",$p3,time() + 60*60);
        header("Location: index.php");
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
    <form action="signUp.php" autocomplete="off">
        <input type="hidden" name="loc" value="signUp" />
        <ul style="padding: 0">
            <li id="sign" class="item">
                ثبت نام
            </li>
            <li id="alert" class="item">
                <?php echo $alert; ?>
            </li>
            <li class="item">
                <input class="input" type="text" id="name" name="name" placeholder="نام">
            </li>
            <li class="item">
                <input class="input" type="text" id="email" name="email" placeholder="ایمیل">
            </li>
            <li class="item">
                <div id="eye"></div>
                <input class="input" type="password" id="password" name="password" placeholder="رمز عبور">
            </li>
            <li class="item">
                <input class="input margb" type="password" id="repass" name="repass" placeholder="تکرار رمز عبور">
            </li>
            <li class="item">
                <input class="btn" id="log" type="submit" name="btn" value="ثبت نام">
                <a href="index.php">
                    <input class="btn" id="sin"  type="button" value="ورود">
                </a>
            </li>
        </ul>
    </form>

</div>
</body>
</html>
