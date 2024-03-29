<?php 
    session_start();
    // Weiterleitung zu Home wenn bereits angemelldet
    if(isset($_SESSION["userid"])){
        header('Location: home.php');
    }
    
    if(isset($_GET['login'])) {
        $us_user = $_POST['username'];
        $us_passwort = $_POST['passwort'];
        
        //Datenbankverbindung aufbauen
        include 'function/databaseCon.php';

        //Nutzer aus datebank abrufen der mit dem eingegebenen Usernamen überrinstimmt
        $sql = "SELECT * FROM `noa_user` WHERE us_username = '$us_user';";
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();
        
        //Passwort verifizieren
        if ($result->num_rows == 1 && password_verify($us_passwort, $user["us_passwort"])) {
            //Session-Variablen setzen und weiterleitn zu Home
            $_SESSION['userid'] = $user['us_id'];
            $_SESSION['username'] = $user['us_username'];
            $_SESSION['berechtigung'] = $user['us_berechtigung'];
            header('Location: home.php');
        } else {
            $errorMessage = "Username oder Kennwort Falsch";
        }

        $conn->close();
    }
?>
<!DOCTYPE html> 
<html> 
    <head>
        <title>Login</title>
        <link rel="icon" href="img/icon.svg">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style/main.css">
        <link rel="stylesheet" href="style/login.css">
    </head> 
    <body>
        <div class="loginForm">
            <div class="errorM">
            <?php
                //Fehlermeldung anzeigen
                if(isset($errorMessage)) {
                    echo $errorMessage;
                }
            ?>
            </div>
            <form action="?login=1" method="post">
                <div class="loginLable">Username:</div>
                <input class="loginInput" type="text" size="40" maxlength="250" name="username">

                <div class="loginLable">Passwort:</div>
                <input class="loginInput" type="password" size="40"  maxlength="250" name="passwort"><br/>

                <input class="loginButton" type="submit" value="Login">
            </form> 
        </div>
    </body>
</html>