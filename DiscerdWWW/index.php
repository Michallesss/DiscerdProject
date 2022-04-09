<?php
    session_start();
    //unset($_SESSION['is_logged']);
    //$_SESSION['is_logged']=true;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discer | Home</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/home.css">
    <link rel="icon" href="">
</head>

<body>
    <div class="header">
        <?php
            if((isset($_SESSION['is_logged'])) && ($_SESSION['is_logged']==true)) {
                echo "<a href='discerd.php'><div>Open Discerd</div></a>";
            }
            else {
                echo "<a href='login.php'><div>Login</div></a>";
            }
        ?>
    </div>

    <div class="content">
        content...
    </div>

    <div class="footer">
        footer
    </div>
</body>

</html>