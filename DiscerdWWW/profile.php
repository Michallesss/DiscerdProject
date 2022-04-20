<?php
    session_start();

    if((!isset($_SESSION['is_logged'])) || ($_SESSION['is_logged']==false)) {
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
        else {
            //here...
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
    <title>Discer | Profile</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/discerd.css">
    <link rel="icon" href="imgs/icon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;1,300;1,400&display=swap" rel="stylesheet">
</head>

<body>
    <?php
        echo $nick."<i>#".$id."</i><br>";
        switch($activity) {
            case 0:
                echo "<span style='color: gray;'>Offline</span>";
                break;
            case 1:
                echo "<span style='color: green;'>Online</span>";
                break;
            case 2:
                echo "<span style='color: red;'>Do not distrub</span>";
                break;
            case 3:
                echo "<span style='color: yellow;'>IDLe</span>";
                break;
            default:
                echo "<span style='color: gray;'>Offline</span>";
        }
        echo $status;
        echo $aboutme;
        //echo $pfp.$banner;
    ?>
</body>

</html>