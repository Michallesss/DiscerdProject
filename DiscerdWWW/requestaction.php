<!--Accepting or dimmmising requests from `requests.php`-->
<?php 
    session_start();

    if((!isset($_SESSION['is_logged'])) || ($_SESSION['is_logged']!=true)) {
        header('Location: requests.php');
        exit();
    }

    if(!isset($_POST['action'])) {
        header('Location: requests.php');
        exit();
    }

    if((!isset($_POST['user'])) || ($_POST['user']=="")) {
        header('Location: requests.php');
        exit();
    }
    
    $id=$_POST['user'];
    $accountid= $_SESSION['account_accountID'];

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);
    
    try {
        $connect = @new mysqli($host, $user, $pass, $database);
        if($connect->connect_errno!=0) {
            throw new Exception(mysqli_connect_errno);
        }

        switch($_POST['action']) {
            case "accept":
                if($result=$connect->query(sprintf("UPDATE `friendship` SET status='1'
                WHERE ((`friendship`.`senderID`='$id' OR `friendship`.`reciverID`='$id') AND (`friendship`.`senderID`='$accountid' OR `friendship`.`reciverID`='$accountid')) AND `friendship`.`status`='0';"))) {
                    header('Location: requests.php');
                    $connect->close();
                    exit();
                }
                else
                {
                    echo "<i>Error:</i>";
                    echo "<div class='error'><b>Dev info:</b> ".$e."</div>";
                    $connect->close();
                }
                break;
            case "dimiss":
                if($result=$connect->query(sprintf("..."))) {
                    //here..
                }
                else {
                    echo "<i>Error:</i>";
                    echo "<div class='error'><b>Dev info:</b> ".$e."</div>";
                    $connect->close();
                }
                break;
        }

        if($result=$connect->query(sprintf("UPDATE ..."))) {
            header('Location: requests.php');
            exit();
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
    <title>Discer | Action on Request...</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="icon" href="imgs/icon.ico">
</head>

<body></body>

</html>