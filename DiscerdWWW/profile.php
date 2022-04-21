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
            //here...
        }
    }
    catch(Exception $e) {
        echo "<i>Error:</i>";
        echo "<div class='error'><b>Dev info:</b> ".$e."</div>";
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discer | Profile</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="icon" href="imgs/icon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;1,300;1,400&display=swap" rel="stylesheet">
</head>

<body>
    <div class="form">
        <div class="banner">
            <style>
                .banner {
                    background-image: url('');
                    border-radius: 15px; /*change to %*/
                    width: 25%; /*probably not to change*/
                    height: 5%; /*probably to change*/
                }
            </style>
        <div>
        <div class="pfp">
            <style>
                .banner {
                    background-image: url('');
                    border-radius: 100%;
                    width: 2%; /*probably to change*/
                    height: 2%; /*probably to change*/
                }
            </style>
        </div>

        <a href="index.php" style="float: left;">Back</a>
    </div>
</body>

</html>