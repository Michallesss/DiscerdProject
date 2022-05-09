<?php
    session_start();

    if((!isset($_SESSION['is_logged'])) || ($_SESSION['is_logged']!=true)) {
        header('Location: index.php');
        exit();
    }

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    if((isset($_GET['id'])) && ($_GET['id']!="")) {
        try {
            $connect = @new mysqli($host, $user, $pass, $database);
            if($connect->connect_errno!=0) {
                throw new Exception(mysqli_connect_errno());
            }
            else {
                $id = $_GET['id'];
                if($result = $connect->query(sprintf("SELECT `nickname`, `phone`, `email`, `aboutme`, `status`, `activity`, `pfp`, `banner` FROM `account` WHERE accountID='$id'"))) {
                    $how_many=$result->num_rows;
                    if($how_many>0) {
                        $profile=$result->fetch_assoc();

                        $nick = $profile['nickname'];
                        $phone = $profile['phone'];
                        $email = $profile['email'];
                        $aboutme = $profile['aboutme'];
                        $status = $profile['status'];
                        $activity = $profile['activity'];
                        $pfp = $profile['pfp'];
                        $banner = $profile['banner'];
                    }
                    else {
                        $pf_error="Incorrect user ID";
                    }
                }
                else {
                    throw new Exception($connect->error);
                }
            }
        }
        catch(Exception $e) {
            echo "<i>Error:</i>";
            echo "<div class='error'><b>Dev info:</b> ".$e."</div>";
        }
        $connect->close();
    }
    else {
        $nick = $_SESSION['account_nick'];
        $phone = $_SESSION['account_phone'];
        $email = $_SESSION['account_email'];
        $aboutme = $_SESSION['account_aboutme'];
        $status = $_SESSION['account_status'];
        $activity = $_SESSION['account_activity'];
        $pfp = $_SESSION['account_pfp'];
        $banner = $_SESSION['account_banner'];
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

    <style>
        .banner {
            background-image: url('imgs/icon.ico');
            background-size: cover;
            min-width: 25%;
            width: 25%;
            max-width: 25%;
        }

        .pfp {
            background-image: url('imgs/icon.ico');
            background-size: cover;
            min-width: 5%;
            width: 5%;
            max-width: 5%;
        }
    </style>
</head>

<body>
    <div class="form">
        <div class="banner"></div>
        <div class="pfp"></div>
        <?php
            if(isset($pf_error)) {
                echo "<div class='error'>".$pf_error."</div>";
                unset($pf_error);
            }
            echo $nick;
        ?>
        <a href="discerd.php" style="float: left;">Back</a>
    </div>
</body>

</html>