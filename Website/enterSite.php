<!DOCTYPE html> 
<?php
    session_start();

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

    if(isset($_GET['add'])){
        $kategorie = $_POST['kategorie'];
        
        
        
        
        
        
        
        echo $kategorie;
    }
    


?>
<html> 
    <head>
        <title></title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style/main.css">
        <link rel="stylesheet" href="style/enterSite.css">
    </head> 
    <body>
        <div class="container">
            <?php
            print_r($_SESSION);
            ?>
        
            <form class="formForm" action="?add=1" method="post">

                <div class="formLable">Kategorie</div>
                <select class="formSelect" name="kategorie">
                <?php
                    $sql = "SELECT * FROM tb_katigorie ORDER BY `ka_name`";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        //Jede Reie der Datenbank anzeigen
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='".$row["ka_id"]."'>".$row["ka_name"]."</option>";
                        }
                    } else {
                        echo "<option value='nd'>Keine Einträge</option>";
                    }
                ?>
                </select>

                <div class="formLable">Nummer</div>
                <input class="formInput" type="number" name="katalognummer">

                <div class="formLable">Titel</div>
                <input class="formInput" type="text" name="titel">

                <div class="formLable">Untertitel</div>
                <input class="formInput" type="text" name="untertitel">

                <div class="formLable">Zugehörigkeit</div>
                <input class="formInput" type="text" name="zugehörigkeit">

                <div class="formLable">Zeit im Kirchenjahr</div>
                <select class="formSelect" name="z_i_kirchenjahr" multiple>
                <?php
                    $sql = "SELECT * FROM tb_z_i_kirchenjahr";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        //Jede Reie der Datenbank anzeigen
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='".$row["zik_id"]."'>".$row["zik_name"]."</option>";
                        }
                    } else {
                        echo "<option value='nd'>Keine Einträge</option>";
                    }
                ?>
                </select>

                <div class="formLable">Thema</div>
                <select class="formSelect" name="thema" multiple>
                <?php
                    $sql = "SELECT * FROM tb_thema";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        //Jede Reie der Datenbank anzeigen
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='".$row["th_id"]."'>".$row["th_name"]."</option>";
                        }
                    } else {
                        echo "<option value='nd'>Keine Einträge</option>";
                    }
                ?>
                </select>

                <div class="formLable">Besetzung</div>
                <select class="formSelect" name="besetzung">
                <?php
                    $sql = "SELECT * FROM tb_besetzung";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        //Jede Reie der Datenbank anzeigen
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='".$row["be_id"]."'>".$row["be_name"]."</option>";
                        }
                    } else {
                        echo "<option value='nd'>Keine Einträge</option>";
                    }
                ?>
                </select>

                <div class="formLable">Komponist</div>
                <input class="formInput" type="text" name="komponist">

                <div class="formLable">Bearbeitung</div>
                <input class="formInput" type="text" name="bearbeitung">

                <div class="formLable">Texter</div>
                <input class="formInput" type="text" name="texter">

                <div class="formLable">Verlag</div>
                <select class="formSelect" name="verlag">
                    <option value='nd'></option>
                <?php
                    $sql = "SELECT * FROM tb_verlag";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        //Jede Reie der Datenbank anzeigen
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='".$row["ve_id"]."'>".$row["ve_name"]."</option>";
                        }
                    } else {
                        echo "<option value='nd'>Keine Einträge</option>";
                    }
                ?>
                </select>           

                <div class="formLable">Werknummer</div>
                <input class="formInput" type="text" name="werknummer">

                <div class="formLable">Status</div>
                <select class="formSelect" name="verlag">
                    <option value='nd'>Aktiv</option>
                    <option value='nd'>Archiviert</option>
                    <option value='nd'>Verliehen</option>
                    <option value='nd'>Entfernt</option>
                </select>
                <br/>
                <button class="formSubmit" type="submit">Hinzufügen</button>


            </form>
        
        </div>
    </body>
</html>
<?php 
      $conn->close();
?>