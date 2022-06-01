<!--sending message-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discer | Sending Message</title>
    
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="icon" href="../imgs/icon.ico">
</head>

<body></body>

</html>
<?php 
    session_start();

    if((!isset($_SESSION['is_logged'])) || (!$_SESSION['is_logged'])) {
        header('Location: ../index.php');
        exit();
    }
    else {
        $accountID = $_SESSION['account_accountID'];
    }

    if(isset($_POST['chat'])) {
        $chatid=$_POST['chat'];
        $option="chat";
    }
    else {
        $chatid="NULL";
    }

    if(isset($_POST['group'])) {
        $groupid=$_POST['group'];
        $option="group";
    }
    else {
        $groupid="NULL";
    }
    
    if(isset($_POST['channel'])) {
        $channelid=$_POST['channel'];
        $serverid=$_POST['server'];
        $option="server";
    }
    else {
        $channelid="NULL";
    }

    require_once "../connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try {
        $connect = @new mysqli($host, $user, $pass, $database);
        if($connect->connect_errno!=0) {
            throw new Exception($connect->mysqli_connect_errno());
        }

        $content=$_POST['content'];
        $time=time();
        $time=date ('Y-m-d H:i', $time);
        if($connect->query("INSERT INTO `message`(`senderID`, `recipientID`, `groupID`, `channelID`, `message_date`, `content`) VALUES ('$accountID', $chatid, $groupid, $channelid, '$time', '$content')")) {
            switch($option) {
                case "chat":
                    header('Location: ../chat.php?chat='.$chatid);
                    break;
                case "group":
                    header('Location: ../group.php?group='.$groupid);
                    break;
                case "server":
                    header('Location: ../server.php?server='.$serverid.'&channel='.$channelid);
                    break;
            }
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
    $connect->close();
    exit();
?>