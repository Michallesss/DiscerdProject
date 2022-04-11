<?php
    session_start();

    if((isset($_SESSION["is_logged"])) || ($_SESSION["is_logged"]==true)) {
        header('Location:discerd .php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discer | Log in</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="icon" href="imgs/icon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;1,300;1,400&display=swap" rel="stylesheet">
</head>

<body>
    <form action="logging.php" method="POST">
        <input type="text" name="login"><br>
        <input type="password" name="password"><br>
        <a href="forgotpass">forgot password</a><br> <!--żeby tego nie robić zrób stronę na której pisze dla bezpieczeństa ta opcja jest nie dostępna albo po prostu ją zrób-->
        <input type="submit"><br>
    </form>
    <a href="signup.php">Sign Up</a>
</body>

</html>