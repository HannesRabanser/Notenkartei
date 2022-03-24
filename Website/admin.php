<!DOCTYPE html> 
<?php 
session_start();
    //Login überprüfen
    if(!isset($_SESSION["userid"])){
        header('Location: index.php');
    }
    elseif((decbin($_SESSION['berechtigung'])& 0000001)!=1){
        header('Location: index.php');
    } 
    //Datenbankverbindung aufbauen
    $db_servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_dbname = "noa_notenarchiv";

    $conn = new mysqli($db_servername, $db_username, $db_password, $db_dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
 
    if(isset($_GET['add'])) {
        
        if($_GET['add'] == '1'){
            $nameuser = $_POST['username'];

            //Nutzer aus datebank abrufen der mit dem eingegebenen Usernamen überrinstimmt
            $sql = "SELECT * FROM `tb_user` WHERE us_username = '$nameuser';";
            $result = $conn->query($sql);
            if ($result->num_rows < 1 ) {
                $passwort_hash = password_hash("Kennwort0!", PASSWORD_DEFAULT);
                $sql = "INSERT INTO `tb_user`(`us_username`, `us_passwort`, `us_berechtigung`) VALUES ('$nameuser','$passwort_hash',126)";
                if ($conn->query($sql) === TRUE) {
                    //echo "Nuzer Hinzugefügt";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                $errorMessage = "User existiert bereits";
            }
        }
    }

    if(isset($_GET['edit'])) {

        //Katigorie
        if($_GET['edit'] == 'us'){
            $us_id = $_POST['id'];
            $us_name = $_POST['name'];
            if(isset($_POST['reset'])){
                $reset = $_POST['reset'];
            } else {
                $reset = "Nein";
            }
            
            if($us_name == ""){
                //echo "leer";
            } else{
                $sql = "UPDATE `tb_user` SET `us_username`='$us_name'";

                if($reset == "Reset"){
                    $passwort_hash = password_hash("Kennwort0!", PASSWORD_DEFAULT);
                    $sql .= ", `us_passwort`= '$passwort_hash'";
                }
                
                $sql .= " WHERE us_id = $us_id";
                
                if ($conn->query($sql) === TRUE) {
                    //echo "Record updated successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
    }

    if(isset($_GET['del'])) {

        //Katigorie
        if($_GET['del'] == 'us'){
            $us_id = $_POST['id'];

            if($us_id  == ""){
                //echo "leer";
            } else{
                $sql = "DELETE FROM `tb_user` WHERE `us_id` = $us_id";

                if ($conn->query($sql) === TRUE) {
                    //echo "Record deleted successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
    }

?>
<html> 
    <head>
        <title>Settings</title>
        <link rel="icon" href="img/icon.svg">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style/main.css">
        <link rel="stylesheet" href="style/settingSite.css">
    </head> 
    <body>
        <div class="container">
            
            <ul class="nav">
                <li>
                    <a href="home.php">Startseite</a>
                </li>
                <li>
                    <a href="setting.php">Einstellungen</a>
                </li>
                <?php 
                if((decbin($_SESSION['berechtigung'])& 0000001)==1){
                    echo "<li> <a href='admin.php' class='active'>Administrator</a> </li>";
                }
                ?>
                <li class="dropdown">
                    <a class="dropbtn"><?php echo $_SESSION['username']; ?></a>
                    <div class="dropdown-content">
                        <a href="changePassword.php">Kennwort ändern</a>
                        <a href="index.php?logout=1">Abmelden</a>
                    </div>
                </li>
            </ul>
            
            <h1>NoA</h1>
            <h2>Web-Basierte Notenarchivierung</h2>
            
            <img src='img/add.svg' class="buttonAdd" onclick="document.getElementById('addUs').style.display = 'block';
                                                       document.getElementById('editUs').style.display = 'none';
                                                       document.getElementById('delUs').style.display = 'none';
                                                       "><br/>
            
            <form action="?add=1" id="addUs" style="display: none" method="post">
                Username:<br>
                <input type="text" maxlength="250" name="username"><br>
                <input type="submit" value="Erstellen">
                <button class="formReset" type="reset" onclick="document.getElementById('addUs').style.display = 'none';">Abbrechen</button>
            </form>
            
            <form class="formForm" id="editUs" style="display: none" action='?edit=us' method='post'>
                        <div class="formHead">Bearbeiten</div>
                        <input id="editUsID" type='hidden' name='id'>
                        <div style="clear: both">
                            <div class="formLable">Name</div>
                            <input id="editUsName" class="formInput" type="text" name='name' placeholder="Name">
                        </div>
                        <div style="clear: both">
                            <div class="formLable">Passwort zurücksetzen</div>
                            <input id="editUSPassReset" class="formInput" type="checkbox" name="reset" value="Reset"><br/>
                        </div>
                        <button class="formSubmit" type='submit'>Bearbeiten</button>
                        <button class="formReset" type="reset" onclick="document.getElementById('editUs').style.display = 'none';">Abbrechen</button>
            </form>
            
            <form class="formForm" id="delUs" style="display: none" action='?del=us' method='post'>
                        <input id="delUsID" type='hidden' name='id'>
                        <div id="delUsName" class="formHead"></div>
                        <button class="formSubmit" type='submit'>Löschen</button>
                        <button class="formReset" type="reset" onclick="document.getElementById('delUs').style.display = 'none';">Abbrechen</button>
                    </form>
            
            
            <table class="tableOutput">
            <?php
                $sql = "SELECT * FROM tb_user";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    //Jede Reie der Datenbank anzeigen
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                        <td>" . $row["us_username"]. "</td>
                        <td onclick=\"document.getElementById('editUs').style.display = 'block';
                             document.getElementById('editUsID').setAttribute('value','".$row["us_id"]."');
                             document.getElementById('editUsName').setAttribute('value','".$row["us_username"]."'); 
                             document.getElementById('addUs').style.display = 'none';
                             document.getElementById('delUs').style.display = 'none';
                             \"><img src='img/edit.svg'></td>
                        <td onclick=\"document.getElementById('delUs').style.display = 'block';
                             document.getElementById('delUsID').setAttribute('value','".$row["us_id"]."');
                             document.getElementById('delUsName').innerHTML = 'Wollen Sie ".$row["us_username"]." wirklich löschen?';
                             document.getElementById('addUs').style.display = 'none';
                             document.getElementById('editUs').style.display = 'none';
                             \"><img src='img/delete.svg'></td>
                        </tr>";
                    }
                } else {
                    echo "Keine Einträge";
                }
            ?>
            </table>
        </div>
    </body>
</html>
<?php 
      $conn->close();
?>