<?php 
    session_start();
    include('actions/functions.php');

    if((!isset($_SESSION['is_logged'])) || ($_SESSION['is_logged']==false)) {
        header('Location: index.php');
        exit();
    }
    else {
        $accountID=$_SESSION['account_accountID'];
    }

    $is_good=false;
    if(isset($_POST['submit'])) {
        if((!isset($_POST['search'])) || ($_POST['search']=="")) {
            $sr_error="Fill search field";
            $is_good=false;
        }
        else {
            $search= "%".$_POST['search']."%";
            $is_good=true;
        }
    }

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
?><!--W przyszłości dodać jeszcze do tabeli server tagi itd. i filtracje tutaj-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discerd | Search</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/discerd.css">
    <link rel="icon" href="imgs/icon.ico">

    <script src="scripts/validation.js"></script>
</head>

<body>
    <div class="banner">
        <a href="discerd.php"><img src="imgs/banner.png"></a>
        <ol>
            <?php
                echo "<li>
                <form name='search' action='' method='post' onsubmit='return searches();'>
                    <input type='text' placeholder='Search..' onfocus='this.placeholder=``' onblur='this.placeholder=`Search..`' name='search'>
                    <input type='submit' value='search' name='submit'>
                </form>
                </li>";
            ?>
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
    <div class="content" class="friendscontent">
        <div class="error" id="sr_error" style="text-align: center;">
            <?php
                if(isset($sr_error)) {
                    echo $sr_error;
                    unset($sr_error);
                }
            ?>
        </div>
        <?php

            if($is_good) {
                try {
                    if($result = $connect->query(sprintf("SELECT serverID ,server_name, server_icon FROM `server` WHERE server_name LIKE'%$search%' AND is_public=1"))) {
                        while($row=$result->fetch_assoc()) {
                            echo "<div class='friendscontent'>";
                            $id=$row['serverID'];
                            echo "<img src='usersimgs/".$row['server_icon']."' class='friendsimage'>";
                            echo $row['server_name']."<br><a href='invite.php?serverID=".$id."&groupID=NULL&message='><span style='text-align: right;'>Join</span></a>";
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
            }
        ?>
    </div>
</body>

</html>