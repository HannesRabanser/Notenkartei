<!DOCTYPE html> 
<?php 
session_start();
 
    if(isset($_GET['login'])) {
        $us_user = $_POST['username'];
        $us_passwort = $_POST['passwort'];

        $db_servername = "localhost";
        $db_username = "root";
        $db_password = "";
        $db_dbname = "noa_notenarchiv";

        // Create connection
        $conn = new mysqli($db_servername, $db_username, $db_password, $db_dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        $sql = "SELECT * FROM `tb_user` WHERE us_username = '$us_user';";
        $result = $conn->query($sql);

        $user = $result->fetch_assoc();

        if ($result->num_rows == 1 && password_verify($us_passwort, $user["us_passwort"])) {
        // output data of each row

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
<html> 
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style/main.css">
        <link rel="stylesheet" href="style/login.css">
    </head> 
    <body>
        <div class="loginForm">
            <div class="errorM">
            <?php 
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