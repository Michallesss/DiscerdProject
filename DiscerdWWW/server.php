<!--Server with many channels and members-->
<?php
    session_start();

    //test data:
    $serverid=1;
    $channelid=1;

    if((!isset($_SESSION['is_logged'])) || (!$_SESSION['is_logged'])) {
        header('Location: index.php');
        exit();
    }
    else {
        $accountID=$_SESSION['account_accountID'];
    }

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);
    try {
        $connect = @new mysqli($host, $user, $pass, $database);
        if($connect->connect_errno!=0) {
            throw new Exception($connect->mysqli_connect_errno());
        }
        
        //wybieranie servera jeśli podane jest id!!!
        if((!isset($_GET['channel'])) || ($_GET['channel']=="")) {
            if((!isset($_GET['server'])) || ($_GET['server']=="")) {
                //nic nie jest podane
                header('discerd.php');
                $connect->close();
                exit();
            }
            else {
                //jest podane id servera ale nie ma id kanału
                $serverid=$_GET['server'];

                /*if($result=$connect->query(sprintf("...")))
                {
                    $how_many=$result->num_rows;
                    if($how_many>0) {
                        $channelid=$_GET['channel'];
                    }
                    else {
                        //to samo co w lini 30 (czyli to wybieranie pierwszego kanału na serverze)
                    }
                }*/  
            }
        }
        else {
            if((!isset($_GET['server'])) || ($_GET['server']=="")) {
                //jest podane id kanału ale nie servera
                $channelid=$_GET['channel'];
            }
            else {
                //podane jest id servera jak i kanału
                $channelid=$_GET['channel'];
                $serverid=$_GET['server'];
            }
        }

        if($result=$connect->query(sprintf("SELECT `server`.`server_name`, `server`.`server_icon`, `server`.`is_public` FROM `server` WHERE `serverID`='$serverid'"))) {
            $how_many=$result->num_rows;
            if($how_many>0) {
                $row=$result->fetch_assoc();

                //$id
                //channelid
                //serverid
                $name=$row['server_name'];
                $icon=$row['server_icon'];
                $is_public=$row['is_public'];
            }
            else {
                //header('Location: index.php');
                //$connect->close();
                //exit();
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discer | Server - <?php if(isset($name)) echo $name?></title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/chat.css">
    <link rel="icon" href="imgs/icon.ico">
</head>

<body>
    <div class="banner"><!--just header-->
        <a href="discerd.php"><img src="imgs/banner.png"></a>
        <ol>
            <?php
                echo "<li><a href='server.php?server=$serverid'>".$name."</a></li>";
            ?>
        </ol>
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
    <div class="channels">
        <div style="padding: 15% 0 15% 0; text-align: center; border-bottom: 1px solid #404040;" title="switch to text channel"><a href="">Text Channel</a></div>
        <div style="padding: 15% 0 15% 0; text-align: center; border-bottom: 1px solid #404040;" title="switch to voice channel"><a href="">Voice Channel</a></div>
        <!--some code to voice chats:))-->
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
    <div class="content"><!--channel's messages-->
        <?php 
            try {
                if($result=$connect->query(sprintf("SELECT `message`.`messageID`, `account`.`accountID`, `account`.`nickname`, `message`.`message_date`, `message`.`senderID`, `message`.`ChannelID`, `message`.`content` FROM `message` 
                JOIN account ON account.accountID=message.senderID
                WHERE `channelID`='$channelid'
                ORDER BY `messageID` ASC;"))) {
                    while($row=$result->fetch_assoc()) {
                        echo "<div class='message'>";
                        echo "<a herf='profile.php?id=".$row['accountID']."'><b>".$row['nickname']."</b></a> <i><sup>".$row['message_date']."</sup></i>"; 
                        if($accountID==$row['senderID']) {
                            echo " <a href='actions/deletemessage.php?id=".$row['messageID']."&channel=".$channelid."'>Delete</a>";
                        }
                        echo "<br>".$row['content'];
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
    <div class="inputBar">
        <form action="actions/send.php" method="post">
            <input type="text" name="content" placeholder="Type here..." onfocus="this.placeholder=''" onblur="this.placeholder='Type here...'">
            <input type="hidden" value="<?php echo $channelid; ?>" name="channel">
            <input type="submit" value="send" name="submit">
        </form>
    </div>
</body>

</html>
<?php 
    $connect->close();
?>