<?php
    session_start();
    
    require_once "connect.php";
    $connect = @new mysqli($host, $user, $password, $database);

    if((isset($_SESSION["is_logged"])) || ($_SESSION["is_logged"]==true)) {
        header('Location:discerd.php');
        exit();
    }
    else {

        if($connect->connect_errno!=0) {
            echo "error: ".$connect->connect_errno;
        }
        else {
            $login = $_SESSION["login"];
            $pass = $_SESSION["password"];

            $login = htmlentities($login, ENT_QUOTES, "UTF-8");
            //...
        }
        /*line 28-70 login.php repository forum*/
    }
    


    $connect->close();
?>
<!--sprawdzanie danych z formularza w loginie-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discer | Connecting</title>
    
    <link rel="icon" href="">
</head>

<body></body>

</html>