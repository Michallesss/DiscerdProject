<!--deleteing message-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discer | Delete Message</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="icon" href="imgs/icon.ico">
</head>

<body></body>

</html>

<?php
    session_start();

    if((!isset($_SESSION['is_logged'])) && ($_SESSION['is_logged']==false)) {
        echo "<script>window.close(); location.reload(true);</script>";
        exit();
    }

    if((!isset($_GET['id'])) || ($_GET['id']=="")) {
        echo "<script>window.close(); location.reload(true);</script>";
        exit();
    }
    else {
        $id=$_GET['id'];
        $accountID=$_SESSION['account_accountID'];
    }

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try {
        $connect = @new mysqli($host, $user, $pass, $database);
        if($connect->connect_errno!=0) {
            throw new Exception($connect->mysqli_connect_errno());
        }

        if($result=$connect->query(sprintf("DELETE FROM `message` WHERE `senderID`='$accountID' AND `messageID`='$id'"))) {
            echo "<script>window.close(); location.reload(true);</script>";
            exit();
        }
        else {
            throw new Exception($connect->error);
        }
    }
    catch(Exception $e) {
        echo "<i>Error:</i>";
        echo "<div class='error'><b>Dev info:</b> ".$e."</div>";
    }
    echo "<script>window.close(); location.reload(true);</script>";
    exit();
?>