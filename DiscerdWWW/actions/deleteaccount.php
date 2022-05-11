<!--deleteing account-->
<?php
    session_start();
    $is_good=true;

    if((isset($_POST['submit'])) && ($_POST['submit']=="Delete")) {
        if((!isset($_POST['check'])) || ($_POST['check']!=true)) {
            $is_good=false;
            $dl_error_check="Check the checkbox";
        }
        
        if((!isset($_POST['password'])) || ($_POST['password']=="")) {
            $is_good=false;
            $dl_error_password="Fill password";
        }
        else {
            $id=$_SESSION['account_accountID'];

            require_once "connect.php";
            mysqli_report(MYSQLI_REPORT_STRICT);
            try {
                $connect = @new mysqli($host, $user, $pass, $database);

                if($result = $connect->query(sprintf("SELECT `password` FROM account WHERE accountID='$id'"))) {
                    $row = $result->fetch_assoc();

                    
                    if(!password_verify($_POST['password'], $row['password'])) {
                        $is_good=false;
                        $dl_error_password="Incorrect password";
                    }
                }
                else {
                    throw new Exception($connect->error);
                }

                if($is_good) {
                    //Usuwanie reszty relacji
                    if($result = $connect->query(sprintf("DELETE FROM account WHERE accountID='$id'"))) { //ŻEBY TO DZIAŁAŁO MUSIMY JESZCZE USUWAĆ WSZYSTKIE RELACJE BRUHHHHHH
                        $dl_info="Your account was deleted";
                        unset($_SESSION['is_logged']);
                    }
                    else {
                        throw new Exception($connect->error);
                    }
                }
            }
            catch(Exception $e) {
                echo "<i>Error:</i>";
                echo "<div class='error'><b>Dev info:</b> ".$e."</div>";
                $connect->close();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="forum, social, discerd, chating, messages">
    <meta name="description" content="Discerd is global social forum for everyone!">
    <meta name="author" content="Mikael#0168">
    <title>Discerd | Delete Account</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="icon" href="imgs/icon.ico">
</head>

<body>
    <div class="form">
        <?php
            if(isset($dl_info)) {
                echo "<div class='info'>".$dl_info."</div>";
                unset($dl_info);
                exit();
            }
        ?>
        <form action="" method="post">
            <input type="password" name="password" placeholder="Your Password" onfocus="this.placeholder=''" onblur="this.placeholder='Your Password'">
            <?php 
                if(isset($dl_error_password)) {
                    echo "<div class='error'>".$dl_error_password."</div>";
                    unset($dl_error_password);
                }
            ?>
            <label for="check">Are you sure you want delete your account permanently</label>
            <input type="checkbox" id="check" name="check" style="width: auto; display: inline;">
            <?php 
                if(isset($dl_error_check)) {
                    echo "<div class='error'>".$dl_error_check."</div>";
                    unset($dl_error_check);
                }
            ?>
            <input type="submit" name="submit" value="Delete">
            <?php
                unset($_POST['submit']);
            ?>
            <a href="discerd.php" style="float: left;">Back</a>
        </form>
    </div>
</body>

</html>