<!--Server with many channels and members-->
<?php
    session_start();
    include('actions/functions.php');

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

                if($result=$connect->query(sprintf("SELECT MIN(`channel`.`channelID`) AS `channelID`, `channel`.`name`, `channel`.`type` FROM `channel`
                JOIN `category` ON `category`.`categoryID` = `channel`.`categoryID`
                JOIN `server` ON `server`.`serverID` = `category`.`serverID`
                WHERE `server`.`serverID`='$serverid' AND `channel`.`type`='1'")))
                {
                    $how_many=$result->num_rows;
                    if($how_many>0) {
                        $row=$result->fetch_assoc();
                        $channelid=$row['channelID'];
                        $serverid=$_GET['server'];
                        header('Location: server.php?server='.$serverid.'&channel='.$channelid.'');
                        $connect->close();
                        exit();
                    }
                    else {
                        header('Location: discerd.php');
                        $connect->close();
                        exit();
                    }
                }
            }
        }
        else {
            if((!isset($_GET['server'])) || ($_GET['server']=="")) {
                //jest podane id kanału ale nie servera
                $channelid=$_GET['channel'];
                try {
                    if($result=$connect->query(sprintf("..."))) {
                        /*SELECT `serverID` FROM `server`
                        JOIN `category` ON `category`.`categoryID` = `channel`.`categoryID`
                        JOIN `server` ON `server`.`serverID` = `category`.`serverID`
                        WHERE `channel`.`channelid`='$channelid'*/
                        
                        $how_many=$result->num_rows;
                        if($how_many>0) {
                            $row=$result->fetch_assoc();
                            $serverid=$row['serverID'];
                            //$channelid=$row['channelID'];
                            header('Location: server.php?server='.$serverid.'&channel='.$channelid);
                            $connect->close();
                            exit();
                        }
                        else {
                            header('Location: discerd.php');
                            $connect->close();
                            exit();
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
            }
            else {
                //podane jest id servera jak i kanału(wszystko)
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

    <script src="scripts/livechat.js"></script>
    <script src="scripts/validation.js"></script>
</head>

<body onload="livechat();">
    <div class="banner"><!--just header-->
        <a href="discerd.php"><img src="imgs/banner.png"></a>
        <ol>
            <li><a href='createinvite.php'>Add member</a></li>
            <?php
                echo "<li><a href='server.php?server=$serverid'>".$name."</a></li>";
            ?>
        </ol>
    </div>
    <div class="servers">
        <?php //list of servers
            servers($accountID, $connect);
        ?>
    </div>
    <div class="channels">
        <?php 
            //list of categories and channels
            try {
                if($result=$connect->query(sprintf("SELECT * FROM `category` WHERE `category`.`serverID`='$serverid' ORDER BY `weight`"))) {
                    while($row=$result->fetch_assoc()) {
                        echo "<div class='category' style='background-color: #40444b;'>";
                        echo $row['name'];
                        $categoryid=$row['categoryID'];
                        if($result2=$connect->query(sprintf("SELECT * FROM `channel` WHERE `channel`.`categoryID`='$categoryid' ORDER BY `weight`"))) {
                            while($row2=$result2->fetch_assoc()) {
                                $thischannelid=$row2['channelID'];
                                if($row2['type']=="1") echo "<div style='margin: 2% 0 2% 0; text-align: center;'><a href='server.php?server=$serverid&channel=$thischannelid'>".$row2['name']."</a></div>";
                                else echo "<div style='margin: 2% 0 2% 0; text-align: center;'><a href=''>".$row2['name']."</a></div>";
                                //tutaj trochę na odwal się ale to trzeba by było już ogarnać czat głosowy
                            }
                        }
                        else {
                            throw new Exception($connect->error);
                        }
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
        <!--some code to voice chats:))-->
    </div>
    <div class="friends">
        <?php //list of users
            friends($accountID, $connect);
        ?>
    </div>
    <input type="hidden" id="type" value="server">
    <input type="hidden" id="server" value="<?php echo$serverid;?>">
    <input type="hidden" id="channel" value="<?php echo$channelid;?>">
    <div class="content">Loading..</div>
    <div class="inputBar">
        <form name="message" action="actions/send.php" method="post" onsubmit="return messages();">
            <input type="text" name="content" placeholder="Type here..." onfocus="this.placeholder=''" onblur="this.placeholder='Type here...'">
            <input type="hidden" value="<?php echo $channelid; ?>" name="channel">
            <input type="hidden" value="<?php echo $serverid; ?>" name="server">
            <input type="submit" value="send" name="submit">
        </form>
    </div>
</body>

</html>
<?php 
    $connect->close();
?>