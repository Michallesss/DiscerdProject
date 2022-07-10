<!--async reveive message form servers-->
<?php
    session_start();
    $serverid=$_GET['server'];
    $channelid=$_GET['channel'];
    $accountID=$_SESSION['account_accountID'];

    require_once "../connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);
    try  {
        $connect = @new mysqli($host, $user, $pass, $database);
        if($connect->connect_errno!=0) {
            throw new Exception($connect->mysqli_connect_errno());
        }

        if($result=$connect->query(sprintf("SELECT `message`.`messageID`, `account`.`accountID`, `account`.`nickname`, `message`.`message_date`, `message`.`senderID`, `message`.`ChannelID`, `message`.`content` FROM `message` 
        JOIN account ON account.accountID=message.senderID
        WHERE `channelID`='$channelid'
        ORDER BY `messageID` ASC;"))) {
            while($row=$result->fetch_assoc()) {
                echo "<div class='message'>";
                echo "<a herf='profile.php?id=".$row['accountID']."'><b>".$row['nickname']."</b></a> <i><sup>".$row['message_date']."</sup></i>"; 
                if($accountID==$row['senderID']) {
                    echo " <a href='actions/deletemessage.php?id=".$row['messageID']."&server=".$serverid."&channel=".$channelid."'>Delete</a>";
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
    $connect->close();
?>