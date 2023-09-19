<?php 
    session_start();
    //Logout
    if($_GET['logout'] == '1'){
        session_unset();
    }

    // Weiterleitung zu Login wenn nicht angemeldet ansonsten zu Home
    if(!isset($_SESSION["userid"])){
        header('Location: login.php');
    }else{
        header('Location: home.php');
    }
?>
<!DOCTYPE html> 
<html>
    <head>
        <!-- Weiterleitung zu Login -->
        <meta http-equiv="refresh" content="0; URL=login.php">
    </head>
    <body>
        <a href="login.php">Login</a>
    </body>
</html>