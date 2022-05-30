<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="forum, social, discerd, chating, messages">
    <meta name="description" content="Discerd is global social forum for everyone!">
    <meta name="author" content="Mikael#0168">
    <title>Discerd | Home</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/home.css">
    <link rel="icon" href="imgs/icon.ico">
</head>

<body>
    <div class="banner">
        <a href="discerd.php"><img src="imgs/banner.png"></a>
        <ol>
            <?php
            if((isset($_SESSION['is_logged'])) && ($_SESSION['is_logged'])) {
                echo "<li><a href='discerd.php'><div>Open Discerd</div></a></li>";
            }
            else {
                echo "<li><a href='login.php'><div>Login</div></a></li>";
                echo "<li><a href='signup.php'>Sign Up</a></li>";
            }
            ?>
        </ol>
    </div>
    <div class="content">
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptates aspernatur qui eligendi, sunt beatae ratione quisquam adipisci numquam molestiae recusandae, quod rerum a sequi deserunt officiis eaque mollitia inventore itaque.
    </div>
    <div class="footer">
        Discerd<br>
        By Michał Wieczorek, Mateusz Simkiewicz, Szymon Kulej
    </div>
</body>

</html>