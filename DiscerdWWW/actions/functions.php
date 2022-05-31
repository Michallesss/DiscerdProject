<?php 
    //list of friends
    function friends($id, $connect) {
        try {
            if($result = $connect->query(sprintf("SELECT `account`.`accountID`, `account`.`nickname`, `account`.`status`, `account`.`activity`, `account`.`aboutme`, `account`.`pfp`, `account`.`banner` FROM account
            JOIN friendship ON account.accountID=friendship.reciverID
            WHERE friendship.senderID='$id' AND friendship.status!=0
            UNION
            SELECT `account`.`accountID`, `account`.`nickname`, `account`.`status`, `account`.`activity`, `account`.`aboutme`, `account`.`pfp`, `account`.`banner` FROM account
            JOIN friendship ON account.accountID=friendship.senderID
            WHERE friendship.reciverID='$id' AND friendship.status!=0
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
            WHERE server_group_account.accountID='$id'"))) {
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
                        
        return 0;
    }

    //list of servers
    function servers($id, $connect) {
        try {
            if($result = $connect->query(sprintf("SELECT server.serverID, server.server_name, server.server_icon FROM server
            JOIN server_group_account ON server.serverID=server_group_account.serverID
            WHERE server_group_account.accountID='$id';"))) { 
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

        return 0;
    }