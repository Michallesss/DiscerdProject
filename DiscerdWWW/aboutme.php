<?php
    session_start();

    if((!isset($_SESSION['is_logged'])) || ($_SESSION['is_logged']!=true)) {
        header('Location" index.php');
        exit();
    }
    else {
        $accountID=$_SESSION['account_accountID'];
    }
    
    $id=$_SESSION['account_accountID'];

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);
    try {
        $connect = @new mysqli($host, $user, $pass, $database);
        if($connect->connect_errno!=0) {
            throw new Exception(mysqli_connect_errno());
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
    <title>Discer | About me</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/discerd.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="icon" href="imgs/icon.ico">
</head>

<body>
<body>
    <div class="banner">
        <a href="discerd.php"><img src="imgs/banner.png"></a>
    </div>
    <div class="servers">
        <?php //list of servers
            try {
                if($result = $connect->query(sprintf("SELECT server.serverID, server.server_name, server.server_icon FROM server
                JOIN server_group_account ON server.serverID=server_group_account.serverID
                WHERE server_group_account.accountID='$accountID';"))) { 
                    while($row=$result->fetch_assoc()) {
                        echo "<div class='servercontent'>";
                            echo "<a href='server.php?server=".$row['serverID']."'><img alt='".$row['server_name']."' src='usersimgs/".$row['server_icon']."' class='serverimage' title='".$row['server_name']."'></a>";
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
            }
        ?>
    </div>
    <div class="friends">
        <?php //list of users
            try {
                if($result = $connect->query(sprintf("SELECT `account`.`accountID`, `account`.`nickname`, `account`.`status`, `account`.`activity`, `account`.`aboutme`, `account`.`pfp`, `account`.`banner` FROM account
                JOIN friendship ON account.accountID=friendship.reciverID
                WHERE friendship.senderID='$accountID' AND friendship.status!=0
                UNION
                SELECT `account`.`accountID`, `account`.`nickname`, `account`.`status`, `account`.`activity`, `account`.`aboutme`, `account`.`pfp`, `account`.`banner` FROM account
                JOIN friendship ON account.accountID=friendship.senderID
                WHERE friendship.reciverID='$accountID' AND friendship.status!=0
                ORDER BY nickname"))) {
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
                        echo "<div class='friendslistcontent'>";
                            echo "<a href='chat.php?chat=".$row['accountID']."'><img src='usersimgs/".$row['pfp']."' class='friendslistimage'>";
                            echo $row['nickname']."#".$row['accountID']."</a><br>";
                            echo $activity." ".$row['status'];
                        echo "</div>";
                    }
                }
                else {
                    throw new Exception($connect->error);
                }
                        
                if($result = $connect->query(sprintf("SELECT `group`.groupID, `group`.group_name, `group`.group_icon FROM `group`
                JOIN server_group_account ON `group`.groupID=server_group_account.groupID
                WHERE server_group_account.accountID='$accountID'"))) {
                    while($row=$result->fetch_assoc()) {
                        echo "<div class='friendslistcontent'>";
                            echo "<a href='group.php?group=".$row['groupID']."'><img src='usersimgs/".$row['group_icon']."' class='friendslistimage'>";
                            echo $row['group_name']."</a><br>";
                            echo "<span style='color: gray;'>group</span>";
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
            }
        ?>
    </div>
    <div class="content">
        <div class="form" style="margin-top: 3%;">
            <form action="actions/upload.php" method="post" enctype="multipart/form-data">
                Profile Picture:
                <input type="file" name="pfp" id="pfp">
                Profile Banner:
                <input type="file" name="banner" id="banner">
                <input type="submit" value="Upload Images" name="submit">
            </form>
        </div>
        <div class="form" style="margin-top: 3%;">
            <form action="" method="post">
                Informations
                <input type="nick" name="pf_nick"  value="" placeholder="New Nickname" onfocus="this.placeholder=''" onblur="this.placeholder='New Nickname'">
                <input type="tel" name="pf_phone" value="" placeholder="New Phone number" onfocus="this.placeholder=''" onblur="this.placeholder='New Phone number'">
                <input type="email" name="pf_email" value="" placeholder="New E-mail" onfocus="this.placeholder=''" onblur="this.placeholder='New E-mail'">
                <input type="submit" value="Upload Images" name="submit">
                <a href="actions/changepass.php">Change password</a><br>
                <a href="deleteaccount.php">Delete account</a><br>
            </form>
        </div>
    </div>
</body>
</body>

</html>