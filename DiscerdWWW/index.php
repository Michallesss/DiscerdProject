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
    <div class="header">
        <a href="index.php"><img src="imgs/transparentlogo.png"></a>
        <ol>
        <?php
            if((isset($_SESSION['is_logged'])) && ($_SESSION['is_logged']==true)) {
                echo "<li><a href='discerd.php'><div>Open Discerd</div></a></li>";
            }
            else {
                echo "<li><a href='login.php'><div>Login</div></a></li>";
            }
        ?>
        </ol>
    </div>

    <div class="content">
        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Odit sapiente fugit, similique hic adipisci voluptatem iure ratione nesciunt quod. Nihil, voluptas porro fugiat non voluptatem eos asperiores? Maxime, provident accusantium?
    </div>

    <div class="footer">
        Discerd<br>
        By Michał Wieczorek, Szymon Kulej, Mateusz Simkiewicz.
    </div>
</body>

</html>