<?php
    session_start();
    include('actions/functions.php');

    if((!isset($_SESSION['is_logged'])) || (!$_SESSION['is_logged'])) {
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

        if(isset($_SESSION['account_accountID'])) {
            $id = $_SESSION['account_accountID'];
            if($result = $connect->query(sprintf("SELECT * FROM account WHERE accountID='$id'"))) {
                $how_many = $result->num_rows;
                if($how_many>0) {
                    $account = $result->fetch_assoc();

                    $_SESSION['account_login'] = $account['login'];
                    $_SESSION['account_password'] = $account['password'];
                    $_SESSION['account_phone'] = $account['phone'];
                    $_SESSION['account_email'] = $account['email'];
                    $_SESSION['account_nick'] = $account['nickname'];
                    $_SESSION['account_aboutme'] = $account['aboutme'];
                    //$_SESSION['account_status']...
                    switch($account['activity']) {
                        case 0:
                            $_SESSION['account_status']="<span style='color: gray;'>Offline</span>";
                            break;
                        case 1:
                            $_SESSION['account_status']="<span style='color: green;'>Online</span>";
                            break;
                        case 2:
                            $_SESSION['account_status']="<span style='color: red;'>Do not distrub</span>";
                            break;
                        case 3:
                            $_SESSION['account_status']="<span style='color: yellow;'>IDLE</span>";
                            break;
                        default:
                            $_SESSION['account_status']="<span style='color: gray;'>Offline</span>";
                            break;
                    }
                    $_SESSION['account_activity'] = $account['activity'];
                    $_SESSION['account_pfp'] = $account['pfp'];
                    $_SESSION['account_banner'] = $account['banner'];
                    $_SESSION['account_permission_level'] = $account['permission_level'];
                }
                else {
                    exit();
                }
            }
            else {
                throw new Exception($connect->error);
            }
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
    <div class="banner">
        <a href="discerd.php"><img src="imgs/banner.png"></a>
        <ol>
            <?php 
                if($_SESSION['account_permission_level']>0) {
                    echo "<li><b><i><a href='dashboard.php'>Admin Panel</a></i></b></li>";
                }
            ?>
            <li><a href="search.php">Search</a></li>
            <li><a href="requests.php">Invites</a></li>
            <li><a href="createrequest.php">Add Friend</a></li>
            <li><a href="actions/logout.php">Log out</a></li>
        </ol>
    </div>
    <div class="servers">
        <?php //list of servers
            servers($id, $connect);
        ?>
    </div>
    <div class="friends">
        <?php //list of users
            friends($id, $connect);
        ?>
    </div>
    <div class="content">
        <?php //list of online friends
            try {
                if($result = $connect->query(sprintf("SELECT account.`accountID`, account.`nickname`, account.`status`, account.`activity`, account.`aboutme`, account.`pfp`, account.`banner` FROM account
                JOIN friendship ON account.accountID=friendship.reciverID
                WHERE friendship.senderID='$id' AND account.activity>0 AND friendship.status!=0
                UNION
                SELECT account.`accountID`, account.`nickname`, account.`status`, account.`activity`, account.`aboutme`, account.`pfp`, account.`banner` FROM account
                JOIN friendship ON account.accountID=friendship.senderID
                WHERE friendship.reciverID='$id' AND account.activity>0 AND friendship.status!=0
                ORDER BY nickname;"))) {
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
                        echo "<div class='friendscontent'>";
                            echo "<a href='chat.php?chat=".$row['accountID']."'><img src='usersimgs/".$row['pfp']."' class='friendsimage'>";
                            echo $row['nickname']."#".$row['accountID']."</a><span style='float: right;'><a href='chat.php?chat=".$row['accountID']."'>Messages</a> <a href='profile.php?id=".$row['accountID']."'>Profile</a></span><br>";
                            echo $activity." ".$row['status']." <span style='color: gray;'>".$row['aboutme']."</span>";
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
</body>

</html>
<?php
    $connect->close();
?>