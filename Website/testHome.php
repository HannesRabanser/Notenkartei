<?php
session_start();
    if(!isset($_SESSION["userid"])){
        header('Location: index.php');
    }
?>
<!DOCTYPE html>
<html > 
    <head>
        <title></title>
        <link rel="icon" href="img/icon.svg">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style/main.css">
        <link rel="stylesheet" href="style/home.css">
    </head> 
    <body>
        
        <a href="settingSite.php">Settings</a>
        <a href="enterSite.php">Enter</a>
        <a href="searchSite.php">Search</a>
        
        <a href="index.php?logout=1">Logout</a>
        
        
        <a href="users.php">Users</a>
        
        
    </body>
</html>