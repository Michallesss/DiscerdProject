<!--delete message-->
<?php 
    session_start();

    if((!isset($_SESSION['is_logged'])) && ($_SESSION['is_logged']==false)) {
        header('Location: index.php');
        exit();
    }

    if((!isset($_GET['id'])) || ($_GET['id']=="")) {
        header('Location: index.php');
        exit();
    }

    #sprawdzanie czy wiadomość o tym tagu wysłał użytkownik konta
    echo "<script>window.close();</script>";
?>