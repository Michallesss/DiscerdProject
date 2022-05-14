<?php
    session_start();
    
    if((!isset($_SESSION['is_logged'])) || ($_SESSION['is_logged']==false)) {
        header('Location: index.php');
        exit();
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
    
        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
    
        if($is_good) {
            try {
                $connect= @new mysqli($host, $user, $pass, $database);
    
                if($connect->connect_errno!=0) {
                    throw new Exception(mysqli_connect_errno());
                }
                else {
                    $result = $connect->query("SELECT * FROM account WHERE nickname='$nick' AND accountID='$tag'");
                    if(!$result) {
                        throw new Exception($connect->error);
                    }

                    $how_many=$result->num_rows;
                    if($how_many<=0) {
                        $rq_nick_error="That user doesn't exist";
                    }
                    else {
                        $result = $connect->query("SELECT * FROM friendship WHERE (senderID='$senderID' AND reciverID='$reciverID') OR (senderID='$reciverID' AND reciverID='$senderID')");
                        if(!$result) {
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
    <link rel="stylesheet" href="styles/login.css">
    <link rel="icon" href="imgs/icon.ico">
</head>

<body>
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
            <a href="discerd.php" style="float: left;">Back</a>
        </form>
    </div>
</body>

</html>