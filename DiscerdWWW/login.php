<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discer | Log in</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="icon" href="">
</head>

<body>
    <form action="logging.php" method="POST">
        <input type="text" name="login"><br>
        <input type="password" name="password"><br>
        <a href="forgotpass">forgot password</a><br>
        <input type="submit"><br>
    </form>
    <a href="signup.php">Sign Up</a>
</body>

</html>