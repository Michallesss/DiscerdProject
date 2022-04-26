<?php 
    session_start();

    if((!isset($_SESSION['is_logged'])) || ($_SESSION['is_logged']==false)) {
        header('Location: index.php');
        exit();
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
?><!--W przyszłości dodać jeszcze do tabeli server tagi itd. i filtracje tutaj-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discerd | Search</title>
    
    <link rel="stylesheet" href="styles/search.css">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="icon" href="imgs/icon.ico">
</head>

<body>
    <div class="topnav">
        <a href="index.php">Home</a>
        <div class="search-container">
            <form action="" method="post">
                <input type="text" placeholder="Search.." onfocus="this.placeholder=''" onblur="this.placeholder='Search..'" name="search">
                <input type="submit" value="submit" name="submit">
            </form>
            <?php 
                if(isset($sr_error)) {
                    echo "<div class='error'>".$sr_error."</div>";
                    unset($sr_error);
                }
            ?>
        </div>
    </div>
    <div class="results">
        <?php
            require_once "connect.php";
            mysqli_report(MYSQLI_REPORT_STRICT);

            if($is_good) {
                try {
                    $connect = @new mysqli($host, $user, $pass, $database);
                    if($connect->connect_errno!=0) {
                        throw new Exception(mysqli_connect_errno());
                    }

                    if($result = $connect->query(sprintf("SELECT serverID ,server_name, server_icon FROM `server` WHERE server_name LIKE '%$search%' AND is_public=1"))) {
                        echo "<ul>";
                        while($row=$result->fetch_assoc()) {
                            echo "<li>";
                            echo "<a href=''>".$row['server_name']."</a>";
                            echo "</li>";
                        }
                        echo "</ul>";
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