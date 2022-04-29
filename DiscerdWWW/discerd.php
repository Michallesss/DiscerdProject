<?php
    session_start();

    if((!isset($_SESSION['is_logged'])) || ($_SESSION['is_logged']!=true)) {
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
</head>

<body>
    <div class="container">
        <div class="header">
            <a href="index.php"><img src="imgs/transparentlogo.png"></a>
            <ol>
                <li><a href="search.php">Search</a></li>
                <li><a href="requests.php">Invites</a></li>
                <li><a href="createrequest.php">Add Friend</a></li>
                <li><a href="logout.php">Log out</a></li>
            </ol>
        </div>
        <div class="left-menu">
            <div class="l-list-s">
                <?php //list of servers
                    $id=$_SESSION['account_accountID'];
                    try{
                        echo "<ul>";
                        if($result = $connect->query(sprintf("SELECT `account`.`accountID`, `account`.`nickname`, `account`.`status`, `account`.`activity`, `account`.`pfp`, `account`.`banner` FROM account
                        JOIN friendship ON account.accountID=friendship.reciverID
                        WHERE friendship.senderID='$id' AND friendship.status=1
                        UNION
                        SELECT `account`.`accountID`, `account`.`nickname`, `account`.`status`, `account`.`activity`, `account`.`pfp`, `account`.`banner` FROM account
                        JOIN friendship ON account.accountID=friendship.senderID
                        WHERE friendship.reciverID='$id' AND friendship.status=1
                        ORDER BY nickname"))) {
                            while($row=$result->fetch_assoc()) {
                                echo "<li>";
                                echo "<a href='chat.php?id=".$row['accountID']."'>".$row['nickname']."</a>";
                                echo "</li>";
                            }
                        }
                        else {
                            throw new Exception($connect->error);
                        }
                        
                        if($result = $connect->query(sprintf("SELECT `group`.groupID, `group`.group_name, `group`.group_icon FROM `group`
                        JOIN server_group_account ON `group`.groupID=server_group_account.groupID
                        WHERE server_group_account.accountID='$id'"))) {
                            while($row=$result->fetch_assoc()) {
                                echo "<li>";
                                echo "<a href='group.php?id=".$row['groupID']."'>".$row['group_name']."</a>";
                                echo "</li>";
                            }
                        }
                        else {
                            throw new Exception($connect->error);
                        }
                        echo "</ul>";
                    }
                    catch(Exception $e) {
                        echo "<i>Error:</i>";
                        echo "<div class='error'><b>Dev info:</b> ".$e."</div>";
                    }
                ?>
            </div>
            <div class="l-list-u">
                <?php //list of users
                    try {
                        if($result = $connect->query(sprintf("SELECT server.serverID, server.server_name, server.server_icon FROM server
                        JOIN server_group_account ON server.serverID=server_group_account.serverID
                        WHERE server_group_account.accountID='$id';"))) {
                            echo "<ul>";
                            while($row=$result->fetch_assoc()) {
                                echo "<li>";
                                echo "<a href='server.php?id=".$row['serverID']."'>".$row['server_name']."</a>";
                                echo "</li>";
                            }
                            echo "</ul>";
                        }
                        else {
                            throw new Exception($connect->error);
                        }
                    }
                    catch(Exception $e) {
                        echo "<i>Error:</i>";
                        echo "<div class='error'><b>Dev info:</b> ".$e."</div>";
                    }
                ?>
            </div>
            <div class="account">
                <?php //account data
                    $id = $_SESSION['account_accountID'];
                    $nick = $_SESSION['account_nick'];
                    $status = $_SESSION['account_status'];
                    $activity = $_SESSION['account_activity'];
                    $pfp = $_SESSION['account_pfp'];
                    $banner = $_SESSION['account_banner'];
                    
                    switch($activity) {
                        case 0:
                            $activity="<span style='color: gray;'>Offline</span>";
                            break;
                        case 1:
                            $activity="<span style='color: green;'>Online</span>";
                            break;
                        case 2:
                            $activity="<span style='color: red;'>Do not distrub</span>";
                            break;
                        case 3:
                            $activity="<span style='color: yellow;'>IDLE</span>";
                            break;
                        default:
                            $activity="<span style='color: gray;'>Offline</span>";
                            break;
                    }

                    echo "<a href='profile.php'>".$nick."#".$id."</a><br>".$activity." ".$status;
                ?>
            </div>
        </div>
        <div class="content">
            <?php 
                if($result = $connect->query(sprintf("SELECT account.`accountID`, account.`nickname`, account.`status`, account.`activity`, account.`pfp` FROM account
                JOIN friendship ON account.accountID=friendship.reciverID
                WHERE friendship.senderID='$id' AND account.activity>0 AND friendship.status=1
                UNION
                SELECT account.`accountID`, account.`nickname`, account.`status`, account.`activity`, account.`pfp` FROM account
                JOIN friendship ON account.accountID=friendship.senderID
                WHERE friendship.reciverID='$id' AND account.activity>0 AND friendship.status=1
                ORDER BY nickname;"))) {
                    echo "<ul>";
                    while($row=$result->fetch_assoc()) {
                        switch($row['activity']) {
                            case 0:
                                $activity="<span style='color: gray;'>Offline</span>";
                                break;
                            case 1:
                                $activity="<span style='color: green;'>Online</span>";
                                break;
                            case 2:
                                $activity="<span style='color: red;'>Do not distrub</span>";
                                break;
                            case 3:
                                $activity="<span style='color: yellow;'>IDLE</span>";
                                break;
                            default:
                                $activity="<span style='color: gray;'>Offline</span>";
                                break;
                        }
                        echo "<li>";
                        echo "<a href='profile.php?id=".$row['accountID']."'>".$row['nickname']."</a><br>";
                        echo $activity." ".$row['status'];
                        echo "</li>";
                    }
                    echo "</ul>";
                }
                else {
                    throw new Exception($connect->error);
                }
            ?>
        </div>
    </div>
</body>

</html>
<?php
    $connect->close();
?>