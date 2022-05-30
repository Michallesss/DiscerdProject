<?php
    session_start();
    
    if((!isset($_SESSION['is_logged'])) || ($_SESSION['is_logged']==false)) {
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
    }
    catch(Exception $e) {
        echo "<i>Error:</i>";
        echo "<div class='error'><b>Dev info:</b> ".$e."</div>";
        $connect->close();
    }
    
    if(isset($_POST['submit'])) {
        $is_good=true;
        unset($_POST['submit']);

        if((!isset($_POST['text'])) || ($_POST['text']=="")) {
            $is_good=false;
            $rq_nick_error="Fill nick and tag";
        }
        else {
            $text = $_POST['text'];
            $data = explode("#", $text);
            if((!isset($data[0])) || ($data[0]=="")) {
                $is_good=false;
                $rq_nick_error="Invalid nick";
            }
            else {
                $nick = $data[0];
            }
    
            if((!isset($data[1])) || ($data[1]=="")) {
                $is_good=false;
                $rq_nick_error="Invalid tag";
            }
            else {
                $tag = $data[1];
            }

            $senderID=$_SESSION['account_accountID'];
            $reciverID=$tag;

            if($senderID==$reciverID) {
                $is_good=false;
                $rq_nick_error="This is your account";
            }
        }
    
        if($is_good) {
            try {
                if(!$result = $connect->query("SELECT * FROM account WHERE nickname='$nick' AND accountID='$tag'")) {
                    throw new Exception($connect->error);
                }

                $how_many=$result->num_rows;
                if($how_many<=0) {
                    $rq_nick_error="That user doesn't exist";
                }
                else {
                    if(!$result = $connect->query("SELECT * FROM friendship WHERE (senderID='$senderID' AND reciverID='$reciverID') OR (senderID='$reciverID' AND reciverID='$senderID')")) {
                        throw new Exception($connect->error);
                    }
                    
                    $how_many=$result->num_rows;
                    if($how_many>0) {
                        $rq_nick_error="You've already sent an request";
                    }
                    else {
                        if($result=$connect->query("INSERT INTO friendship(`senderID`,`reciverID`,`status`) VALUES ('$senderID','$reciverID','0')")) {
                            $info = "Request was sent";
                        }
                        else {
                            throw new Exception($connect->error); 
                        }
                    }
                }
            }
            catch(Exception $e) {
                echo "<i>Error:</i>";
                echo "<div class='error'><b>Dev info:</b> ".$e."</div>";
                $connect->close();
            }
            $connect->close();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discer | Send friend request</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/discerd.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="icon" href="imgs/icon.ico">
</head>

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
        <div class="form">
            <?php 
                if(isset($info)) {
                    echo "<div class='info'>".$info."</div>";
                    unset($text);
                    unset($info);
                    echo "<a href='discerd.php' style='float: left;'>Back</a>";
                    exit();
                }
            ?>
            <form action="" method="post">
                <input type="text" name="text" value="<?php if(isset($text)) echo$text; ?>" placeholder="Nick#1" onfocus="this.placeholder=''" onblur="this.placeholder='Nick#1'">
                <?php
                    if(isset($rq_nick_error)) {
                        echo "<div class='error'>".$rq_nick_error."</div>";
                        unset($rq_nick_error);
                    }?>
                <input type="submit" name="submit" value="Send request">
            </form>
        </div>
    </div>
</body>

</html>