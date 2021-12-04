<?php
    session_start();
    if(!$_SESSION["loggedInBlank"]){
        header("Location: index.php");
        die();
    }

    $pick = "not found";
    $isOpen = false;
    if(isset($_GET["name"]))
    {
        $server = "localhost";
        $uname = "root";
        $pass = "";
        $db = "blank";
        $a = mysqli_connect($server, $uname, $pass, $db);
        $que = "SELECT * FROM notes WHERE name='" . $_GET["name"] . "' AND id=" . $_SESSION["userId"];
        $result = mysqli_query($a, $que);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $pick = $row["name"];
            $isOpen = true;
        }
        else{
            header("Location: panel.php");
            die();
        }
    }

    if(isset($_GET["layout"]) && ($_GET["layout"]==1||$_GET["layout"]==2)){
        $server = "localhost";
        $uname = "root";
        $pass = "";
        $db = "blank";
        $a = mysqli_connect($server, $uname, $pass, $db);
        $que = "UPDATE users SET layout=".$_GET["layout"]." WHERE id=".$_SESSION["userId"];
        mysqli_query($a,$que);
        $_SESSION["lay"] = $_GET["layout"];
    }

    $usernam = $_SESSION["blankUserName"];

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <link rel="stylesheet" href="../css/panel.css?version=<?php echo time();?>">
        <script src="../js/jquery.js"></script>
        <script src="../js/scroll.js?version=<?php echo time();?>"></script>
        <script src="../js/panel.js?version=<?php echo time();?>"></script>
    </head>
    <body>
        <div id="head">
            <div id="prof"></div>
            <div id="username"><?php echo $usernam; ?></div>
            <div id="sic"></div>
            <div id="sui">
                <div id="sui2">
                </div>
                <div id="sui1">
                </div>
            </div>
        </div>

        <div id="hold">
            <div style="<?php if($isOpen) echo "padding : 0px !important"; ?>" id="cont">
                <?php if($isOpen) echo "<textarea name='".$_GET["name"]."' id='noteF' ></textarea>"; ?>
            </div>
            <?php
                if($isOpen) echo "<div  id='controls' ><div id='fileN'>".$_GET["name"]."</div></div>";
            ?>
            <div id="addp">
                <ul>
                    <li id="sign" class="item">جدید</li>
                    <li id="err" class="item"> </li>
                    <li class="item"><input type="text" class="input" id="name" placeholder="نام" autocomplete="off"></li>
                    <li class="item"><input type="text" class="input" id="subject" placeholder="موضوع" autocomplete="off"></li>
                    <li class="item">
                        <div class="input" id="select">
                            <ul id="insel">
                                <li id="licon"></li>
                                <li  id="first">نوع</li>
                                <li id="second" class="option">جعبه</li>
                                <li id="third" class="option">تودو</li>
                                <li id="fourth" class="option">هفته</li>
                            </ul>
                        </div>
                    </li>
                    <li class="item" id="btns">
                        <a id="addLink" href="">
                            <input type="button" class="btn" id="addb" value="اضافه">
                        </a>
                        <input type="button" class="btn" id="cancel" value="لغو">
                    </li>
                </ul>
            </div>

            <div id="ms">
                <div id="ins"></div>
            </div>

            <?php if($isOpen) echo "<a id='aSave' href='save.php'>"; ?>
            <div id="<?php echo (($isOpen) ? "save" : "add");?>"></div>
            <?php if($isOpen) echo "</a>"; ?>

            <?php if($isOpen) echo "<a href='panel.php'><div id='goBack'></div></a>";?>

        </div>

        <div id="pad">
            <ul class="opt">
                <li class="layof">
                    <div class="opic" id="laypic"></div>
                    چیدمان
                </li>
                <a href="panel.php?layout=1">
                    <li class="layo" id="hoba">
                        <div class="laysel"></div>
                        حباب
                    </li>
                </a>
                <a href="panel.php?layout=2">
                    <li class="layo" id="list">
                        <div class="laysel"></div>
                        لیست
                    </li>
                </a>
            </ul>
            <ul class="opt">
                <div class="opic"></div>

            </ul>
            <ul class="opt">
                <div class="opic"></div>

            </ul>
            <a href="out.php">
                <div id="logout">
                    <img id="logpic" src="../img/logout.png" alt="خروج">
                    خروج
                </div>
            </a>
        </div>
        <script>
            <?php
                $server = "localhost";
                $uname = "root";
                $pass = "";
                $db = "blank";
                $a = mysqli_connect($server, $uname, $pass, $db);
                $quer = "SELECT * FROM notes WHERE id='" . $_SESSION["userId"] . "'";
                $result = mysqli_query($a, $quer);
                if($_SESSION["lay"] == 1) {
                    $ll = "";
                    $elid = "#hoba > .laysel";
                }
                else {
                    $ll = "2";
                    $elid = "#list > .laysel";
                }
                if(!$isOpen) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "addEl('" . $ll . "','" . $row["name"] . "','" . $row["type"] . "','" . $row["topic"] . "','../php/delete.php?in=" . $row["inside"] . "&name=" . $row["name"] . "');";
                    }
                }
                else{
                    $que = "SELECT * FROM notes WHERE (id='" . $_SESSION["userId"] . "' AND name='".$_GET["name"]."')";
                    $result = mysqli_query($a, $que);
                    $row = mysqli_fetch_assoc($result);
                    echo "$('#noteF').text('".str_replace(",,n","\\n",$row["info"])."');";
                }
            ?>
            $("<?php echo $elid;?>").css("background-image","url('../img/select.png')");
            $("a").not("#aSave").click(function(event){
                if(!isSaved ){
                    let conf = confirm("فایل خود را ذخیره نکرده اید");
                    if(!conf) event.preventDefault();
                }
            });
        </script>
    </body>
</html>
