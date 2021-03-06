<!--deleteing message-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discer | Deleteing Message</title>
    
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="icon" href="../imgs/icon.ico">
</head>

<body></body>

</html>

<?php
    session_start();

    function back() {
        if(isset($_GET['chat'])) {
            $id=$_GET['chat'];
            header('Location: ../chat.php?chat='.$id);
        }
        else if(isset($_GET['group'])) {
            $id=$_GET['group'];
            header('Location: ../group.php?group='.$id);
        }
        else if(isset($_GET['channel'])) {
            $channelid=$_GET['channel'];
            $serverid=$_GET['server'];
            header('Location: ../server.php?server='.$serverid.'&channel='.$channelid);
        }
    }

    if((!isset($_SESSION['is_logged'])) && (!$_SESSION['is_logged'])) {
        header('Location: index.php');
        exit();
    }

    if((!isset($_GET['id'])) || ($_GET['id']=="")) {
        back();
        exit();
    }
    else {
        $id=$_GET['id'];
        $accountID=$_SESSION['account_accountID'];
    }

    require_once "../connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try {
        $connect = @new mysqli($host, $user, $pass, $database);
        if($connect->connect_errno!=0) {
            throw new Exception($connect->mysqli_connect_errno());
        }

        if($result=$connect->query(sprintf("DELETE FROM `message` WHERE `senderID`='$accountID' AND `messageID`='$id'"))) {
            back();
            $connect->close();
            exit();
        }
        else {
            throw new Exception($connect->error);
        }
    }
    catch(Exception $e) {
        echo "<i>Error:</i>";
        echo "<div class='error'><b>Dev info:</b> ".$e."</div>";
        $connect->close();
    }
?>