<?php
    session_start();

    if((!isset($_SESSION['is_logged'])) || ($_SESSION['is_logged']==false)) {
        header('Location: index.php');
        exit();
    }

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try {
        $connect = @new mysqli($host, $user, $pass, $database);

        if($connect->connect_errno!=0) {
            throw new Exception(mysqli_connect_errno());
        }
        else {
            //here... query to db
        }
    }
    catch (Exception $e) {
        echo "<i>Error:</i>";
        echo "<div class='error'><b>Dev info:</b> ".$e."</div>";
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discerd</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/discerd.css">
    <link rel="icon" href="imgs/icon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;1,300;1,400&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="header">
            <a href="index.php"><img src="imgs/transparentlogo.png"></a>
            <ol><li><a href="logout.php">Log out</a></li></ol>
        </div>
        <div class="left-menu">
            <div class="l-list-s">
                <?php

                ?>
            </div>
            <div class="l-list-u">list of users</div>
            <div class="account">account</div>
        </div>
        <div class="content">
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Accusantium beatae dicta earum! Sit qui perspiciatis eos obcaecati quaerat enim hic repellendus animi sed. Ab ad nemo placeat vel cumque magnam.
        </div>
    </div>
</body>

</html>