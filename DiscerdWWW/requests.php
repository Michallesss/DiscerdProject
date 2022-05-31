<?php 
    session_start();
    include('actions/functions.php');

    if((!isset($_SESSION['is_logged'])) || ($_SESSION['is_logged']!=true)) {
        header('Location: index.php');
        exit();
    }
    else {
        $accountID = $_SESSION['account_accountID'];
    }

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try {
        $connect = @new mysqli($host, $user, $pass, $database);
        if($connect->connect_errno!=0) {
            throw new Exception($connect->mysqli_connect_errno());
        }
    }
    catch(Exception $e) {
        echo "<i>Error:</i>";
        echo "<div class='error'><b>Dev info:</b> ".$e."</div>";
        $connect->close();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discer | Friends Requests</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/discerd.css">
    <link rel="icon" href="imgs/icon.ico">
</head>

<body>
    <div class="banner">
        <a href="discerd.php"><img src="imgs/banner.png"></a>
        <ol>
            <li><a href="createrequest.php">Send Invite</a></li>
        </ol>
    </div>
    <div class="servers">
        <?php //list of servers
            servers($accountID, $connect);
        ?>
    </div>
    <div class="friends">
        <?php //list of users
            friends($accountID, $connect);
        ?>
    </div>
    <div class="content">
        <?php 
            try {
                $accountID = $_SESSION['account_accountID'];
                if($result=$connect->query(sprintf("SELECT `account`.`accountID`, `account`.`nickname`, `account`.`activity`, `account`.`status`, `account`.`pfp`, `account`.`banner` FROM friendship 
                JOIN account ON accountID=senderID
                WHERE `friendship`.`reciverID`='$accountID' AND `friendship`.`status`=0;"))) {
                    while($row=$result->fetch_assoc()) {
                        echo "<div class='friendscontent'>";
                            echo "<a href='chat.php?chat=".$row['accountID']."'><img src='usersimgs/".$row['pfp']."' class='friendsimage'>";
                            echo $row['nickname']."#".$row['accountID']."</a><span style='float: right;'><a href='profile.php?id=".$row['accountID']."'>Profile</a></span><br>";
                            $id = $row['accountID'];
                            echo "
                            <form action='actions/requestaction.php' method='post'>
                                <input type='submit' name='action' value='accept'>
                                <input type='hidden' name='user' value='$id'>
                                <input type='submit' name='action' value='dimiss'>
                            </form>";
                        echo "</div>";
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
        ?>
    </div>
</body>

</html>
<?php 
    $connect->close();
?>