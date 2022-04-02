<!DOCTYPE html>
<?php 
    session_start();
    // Weiterleitung zu Home wenn bereits angemelldet
    if(!isset($_SESSION["userid"])) {
        header('Location: index.php');
    }
    
    if(isset($_GET['change'])) {
        $us_oldPasswort = $_POST['oldPasswort'];
        $us_newPasswort1 = $_POST['newPasswort1'];
        $us_newPasswort2 = $_POST['newPasswort2'];
        $us_name = $_SESSION['username'];
        
        //Datenbankverbindung aufbauen
        $db_servername = "localhost";
        $db_username = "root";
        $db_password = "";
        $db_dbname = "noa_notenarchiv";
        
        $conn = new mysqli($db_servername, $db_username, $db_password, $db_dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        //Nutzer aus datebank abrufen der mit dem eingegebenen Usernamen überrinstimmt
        $sql = "SELECT * FROM `tb_user` WHERE `us_username` = '$us_name'";
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();
        
        //Passwort verifizieren
        if ($result->num_rows == 1 && password_verify($us_oldPasswort, $user["us_passwort"]) && $us_newPasswort1 == $us_newPasswort2) {
            //Session-Variablen setzen und weiterleitn zu Home
            $passwort_hash = password_hash($us_newPasswort1, PASSWORD_DEFAULT);
            $sql = "UPDATE `tb_user` SET `us_passwort`='$passwort_hash' WHERE `us_id` = " . $_SESSION['userid'] ;
                if ($conn->query($sql) === TRUE) {
                    header('Location: home.php');
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
        } else {
            $errorMessage = "Kennwort Falsch oder stimmt nicht überein";
        }

        $conn->close();
    }
?>
<html> 
    <head>
        <title>Kennwort ändern</title>
        <link rel="icon" href="img/icon.svg">
        <meta charset="UTF-8">
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
            <form action="?change=1" method="post">
                <div class="loginLable">Altes Passwort:</div>
                <input class="loginInput" type="password" size="40"  maxlength="250" name="oldPasswort">

                <div class="loginLable">Neues Passwort:</div>
                <input class="loginInput" type="password" size="40"  maxlength="250" name="newPasswort1">
                
                <div class="loginLable">Passwort Wiederholen:</div>
                <input class="loginInput" type="password" size="40"  maxlength="250" name="newPasswort2"><br/>

                <input class="loginButton" type="submit" value="Kennwort ändern">
                
            </form> 
        </div>
    </body>
</html>