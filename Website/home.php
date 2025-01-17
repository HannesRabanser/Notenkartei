<?php
    session_start();

    //Weiterleitung zu login wenn ncht angemeldet
    if(!isset($_SESSION["userid"])) {
        header('Location: index.php');
    }

    //Datenbankverbindung aufbauen
    include 'function/databaseCon.php';

 ?>
 <!DOCTYPE html> 
<html> 
    <head>
        <title>Search</title>
        <meta charset="UTF-8">
        <link rel="icon" href="img/icon.svg">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style/main.css">
        <link rel="stylesheet" href="style/searchSite.css">
    </head> 
    <body>

        <script>

            window.onload = UpdateData;

            function SetEdit(id, katalognummer, titel, untertitel,zugehoerigkeit, komponist, bearbeitung, texter, werknummer, katigorie, besetzung, zeitImKirchenjahr, thema, verlag, status) {
                document.getElementById('editBlock').style.display = 'block'; 
                document.getElementById('editID').setAttribute('value', id); 
                document.getElementById('editNummer').setAttribute('value', katalognummer); 
                document.getElementById('editTitel').setAttribute('value', titel); 
                document.getElementById('editUntertitel').setAttribute('value', untertitel); 
                document.getElementById('editZugehoerigkeit').setAttribute('value', zugehoerigkeit); 
                document.getElementById('editKomponist').setAttribute('value', komponist); 
                document.getElementById('editBearbeitung').setAttribute('value', bearbeitung); 
                document.getElementById('editTexter').setAttribute('value', texter); 
                document.getElementById('editWerknummer').setAttribute('value', werknummer); 
                document.querySelector('#editKategorie').value = katigorie; 
                document.querySelector('#editBesetzung').value = besetzung; 

                SetEditZik(zeitImKirchenjahr);
                SetEditThema(thema);

                document.querySelector('#editVerlag').value = verlag;
                document.querySelector('#editStatus').value = status;
            }

            function SetEditZik(values) { 
                var element = document.getElementById('editZik');
                for (var i = 0; i < element.options.length; i++) {
                    element.options[i].selected = values.indexOf(element.options[i].value) >= 0;
                }
            }

            function SetEditThema(values) { 
                var element = document.getElementById('editThema');
                for (var i = 0; i < element.options.length; i++) {
                    element.options[i].selected = values.indexOf(element.options[i].value) >= 0;
                }
            }

            function UpdateData() 
            {
                var searchBar = document.querySelector('#searchSearch').value;
                var kategorie = document.querySelector('#searchKategorie').value;
                var z_i_kirchenjahr = document.querySelector('#searchZ_i_kirchenjahr').value;
                var thema = document.querySelector('#searchThema').value;
                var besetzung = document.querySelector('#searchBesetzung').value;

                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("tableData").innerHTML = this.responseText;
                    }
                };

                xmlhttp.open("GET","function/notenblattData.php?searchBar="+searchBar+"&kategorie="+kategorie+"&z_i_kirchenjahr="+z_i_kirchenjahr+"&thema="+thema+"&besetzung="+besetzung,true);
                xmlhttp.send();
            }

            function ClearData()
            {
                document.querySelector('#searchSearch').value = '';
                document.querySelector('#searchKategorie').value = 'nd';
                document.querySelector('#searchZ_i_kirchenjahr').value = 'nd';
                document.querySelector('#searchThema').value = 'nd';
                document.querySelector('#searchBesetzung').value = 'nd';

                UpdateData();
            }

            function ShowMore(elementName)
            {
                document.getElementById(elementName).style.display = 'table-row';
            }

            function HideMore(elementName)
            {
                document.getElementById(elementName).style.display = 'none';
            }

            function ShowNew()
            {
                document.getElementById('newBlock').style.display = 'block';
            }

            function HideNew()
            {
                document.getElementById('newBlock').style.display = 'none';
            }
            
            function ShowTR(elemetId)
            {
                document.getElementById(elemetId).style.display = 'table-row'; 
            }

            function Hide(elemetId)
            {
                document.getElementById(elemetId).style.display = 'none'; 
            }

        </script>

        <div class="container">
            
            <ul class="nav">
                <li>
                    <a href="home.php" class="active">Startseite</a>
                </li>
                <li>
                    <a href="setting.php">Einstellungen</a>
                </li>
                <?php 
                if((decbin($_SESSION['berechtigung'])& 0000001)==1){
                    echo "<li> <a href='admin.php'>Administrator</a> </li>";
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
            
            <div class="settingsBlock" style="clear: Both">
                
                <div class="">
                    <form class="searchBar">
                        <input type="test" name="searchBar" id="searchSearch" placeholder="Suche" onkeyup="UpdateData()" onmouseup="UpdateData()">
                        
                        <select class="" name="kategorie" id="searchKategorie" onchange="UpdateData()">
                            <option value='nd' >Kategorie</option>
                        <?php
                            $sql = "SELECT * FROM noa_katigorie ORDER BY `ka_name`";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                //Jede Reie der Datenbank anzeigen
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value='".$row["ka_id"]."'"; 
                                    if(isset($_POST['kategorie'])){
                                        if($_POST['kategorie'] == $row["ka_id"])
                                            {echo " selected";} 
                                    }
                                    echo ">".$row["ka_name"]."</option>";
                                }
                            } else {
                                echo "<option value='nd'>Keine Einträge</option>";
                            }
                        ?>
                        </select>
                        
                        <select class="" name="z_i_kirchenjahr" id="searchZ_i_kirchenjahr" onchange="UpdateData()">
                            <option value='nd'>Zeit im Kirchenjahr</option>
                        <?php
                            $sql = "SELECT * FROM noa_z_i_kirchenjahr";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                //Jede Reie der Datenbank anzeigen
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value='".$row["zik_id"]."'"; 
                                    if(isset($_POST['z_i_kirchenjahr'])){
                                        if($_POST['z_i_kirchenjahr'] == $row["zik_id"])
                                            {echo " selected";} 
                                    }
                                    echo ">".$row["zik_name"]."</option>";
                                }
                            } else {
                                echo "<option value='nd'>Keine Einträge</option>";
                            }
                        ?>
                        </select>
                        
                        <select class="" name="thema" id="searchThema" onchange="UpdateData()">
                            <option value='nd'>Thema</option>
                        <?php
                            $sql = "SELECT * FROM noa_thema";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                //Jede Reie der Datenbank anzeigen
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value='".$row["th_id"]."'"; 
                                    if(isset($_POST['thema'])){
                                        if($_POST['thema'] == $row["th_id"])
                                            {echo " selected";} 
                                    }
                                    echo ">".$row["th_name"]."</option>";
                                }
                            } else {
                                echo "<option value='nd'>Keine Einträge</option>";
                            }
                        ?>
                        </select>
                        
                        <select class="" name="besetzung" id="searchBesetzung" onchange="UpdateData()">
                            <option value='nd'>Besetzung</option>
                        <?php
                            $sql = "SELECT * FROM noa_besetzung";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                //Jede Reie der Datenbank anzeigen
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value='".$row["be_id"]."'"; 
                                    if(isset($_POST['besetzung'])){
                                        if($_POST['besetzung'] == $row["be_id"])
                                            {echo " selected";} 
                                    }
                                    echo ">".$row["be_name"]."</option>";
                                }
                            } else {
                                echo "<option value='nd'>Keine Einträge</option>";
                            }
                        ?>
                        </select>
                        
                        <!--<input type="submit" value="Suche">-->
                        <input type="button" value="Clear" onmouseup="ClearData()">
                    </form>
                    
                    <img src="img/add.svg" class="icon" onclick="ShowNew();">
                </div>
                
                <div id="tableData"></div>

            </div>
            
        </div>
        
        <!-- Bearbeiten -->
        <div id="editBlock" class="editNewBG" style='display: none'>
            <div class="editNewForm">
                <form class="formForm" method="post" action="function/notenblattEdit.php?edit=1" onreset="Hide('editBlock');">
                    
                    <input id="editID" type="hidden" name="ID">
                    
                    <table style='width: 100%;'>
                        <tr><td>
                            <div class="formLable">Kategorie</div>
                            <select id="editKategorie" class="formSelect" name="kategorie">
                            <?php
                                $sql = "SELECT * FROM noa_katigorie ORDER BY `ka_name`";
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
                        </td></tr>

                        <tr><td>                    
                            <div class="formLable">Nummer</div>
                            <input id="editNummer" class="formInput" type="number" name="katalognummer" max="999" min="1" required>
                        </td></tr>
                        
                        <tr><td>
                            <div class="formLable">Titel</div>
                            <input id="editTitel" class="formInput" type="text" name="titel" required>
                        </td></tr>
                        
                        <tr><td>
                            <div class="formLable">Untertitel</div>
                            <input id="editUntertitel" class="formInput" type="text" name="untertitel">
                        </td></tr>
                        
                        <tr><td>
                            <div class="formLable">Zugehörigkeit</div>
                            <input id="editZugehoerigkeit" class="formInput" type="text" name="zugehoerigkeit">
                        </td></tr>
                        
                        <tr><td>
                            <div class="formLable" onclick="ShowTR('editNeueZiK');">Zeit im Kirchenjahr</div>
                            <select id="editZik" class="formSelect" name="z_i_kirchenjahr[]" multiple>
                            <?php
                                $sql = "SELECT * FROM noa_z_i_kirchenjahr";
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
                        </td></tr>
                        
                        <tr id="editNeueZiK" style='display: none'><td>
                            <div class="formLableNew" onclick="Hide('editNeueZiK');">Hinzufügen</div>
                            <input class="formInput" type="text" name="neueZiK">
                        </td></tr>
                        
                        <tr><td>
                            <div class="formLable" onclick="ShowTR('editNeuesThema');">Thema</div>
                            <select id="editThema" class="formSelect" name="thema[]" multiple>
                            <?php
                                $sql = "SELECT * FROM noa_thema";
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
                        </td></tr>
                        
                        <tr id="editNeuesThema" style='display: none'><td>
                            <div class="formLableNew" onclick="Hide('editNeuesThema');">Hinzufügen</div>
                            <input class="formInput" type="text" name="neuesThema">
                        </td></tr>
                        
                        <tr><td>
                            <div class="formLable" onclick="ShowTR('editNeueBesetzung');">Besetzung</div>
                            <select id="editBesetzung" class="formSelect" name="besetzung">
                            <?php
                                $sql = "SELECT * FROM noa_besetzung";
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
                        </td></tr>
                        
                        <tr id="editNeueBesetzung" style='display: none'><td>
                            <div class="formLableNew" onclick="Hide('editNeueBesetzung');">Hinzufügen</div>
                            <input class="formInput" type="text" name="neueBesetzung">
                        </td></tr>
                        
                        <tr><td>
                            <div class="formLable">Komponist</div>
                            <input id="editKomponist" class="formInput" type="text" name="komponist">
                        </td></tr>
                        
                        <tr><td>
                            <div class="formLable">Bearbeitung</div>
                            <input id="editBearbeitung" class="formInput" type="text" name="bearbeitung">
                        </td></tr>
                        
                        <tr><td>
                            <div class="formLable">Texter</div>
                            <input id="editTexter" class="formInput" type="text" name="texter">
                        </td></tr>
                        
                        <tr><td>
                            <div class="formLable" onclick="ShowTR('editNeuerVertrag');">Verlag</div>
                            <select id="editVerlag" class="formSelect" name="verlag">
                                <option value='nd'></option>
                            <?php
                                $sql = "SELECT * FROM noa_verlag ORDER BY ve_name ASC";
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
                        </td></tr>
                        
                        <tr id="editNeuerVertrag" style='display: none'><td>
                            <div class="formLableNew" onclick="Hide('editNeuerVertrag');">Hinzufügen</div>
                            <input class="formInput" type="text" name="neuerVerlag">
                        </td></tr>
                        
                        <tr><td>
                            <div class="formLable">Werknummer</div>
                            <input id="editWerknummer" class="formInput" type="text" name="werknummer">
                                </td></tr>
                                
                                <tr><td>
                            <div class="formLable">Status</div>
                            <select id="editStatus" class="formSelect" name="status">
                                <option value='akti'>Aktiv</option>
                                <option value='arch'>Archiviert</option>
                                <option value='verl'>Verliehen</option>
                                <option value='entf'>Entfernt</option>
                            </select>
                        </td></tr>
                        
                        <tr><td>
                            <button class="formSubmit" type="submit">Bearbeiten</button>
                            <button class="formReset" type="reset">Abbrechen</button>
                        </td></tr>
                    </table>
                </form>
            </div>
        </div>
        
        <!-- Neu -->
        <div id="newBlock" class="editNewBG" style='display: none'>
            <div class="editNewForm">
                <form class="formForm" action="function/notenblattAdd.php?add=1" method="post" onreset="HideNew();">
                    <table style='width: 100%;'>
                        <tr><td>
                            <div class="formLable">Kategorie</div>
                            <select class="formSelect" name="kategorie">
                            <?php
                                $sql = "SELECT * FROM noa_katigorie ORDER BY `ka_name`";
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
                        </td></tr>

                        <tr><td>
                            <div class="formLable">Nummer</div>
                            <input class="formInput" type="number" name="katalognummer" max="999" min="1" required>
                        </td></tr>

                        <tr><td>
                            <div class="formLable">Titel</div>
                           <input class="formInput" type="text" name="titel" required>
                        </td></tr>

                        <tr><td>
                            <div class="formLable">Untertitel</div>
                            <input class="formInput" type="text" name="untertitel">
                        </td></tr>

                        <tr><td>
                            <div class="formLable">Zugehörigkeit</div>
                            <input class="formInput" type="text" name="zugehörigkeit">
                        </td></tr>

                        <tr><td>
                            <div class="formLable" onclick="ShowTR('addNeueZiK');">Zeit im Kirchenjahr</div>
                            <select class="formSelect" name="z_i_kirchenjahr[]" multiple>
                            <?php
                                $sql = "SELECT * FROM noa_z_i_kirchenjahr";
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
                        </td></tr>
                        
                        <tr id="addNeueZiK" style='display: none'><td>
                            <div class="formLableNew" onclick="Hide('addNeueZiK');">Hinzufügen</div>
                            <input class="formInput" type="text" name="neueZiK">
                        </td></tr>

                        <tr><td>
                            <div class="formLable" onclick="ShowTR('addNeuesThema');">Thema</div>
                            <select class="formSelect" name="thema[]" multiple>
                            <?php
                                $sql = "SELECT * FROM noa_thema";
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
                        </td></tr>
                        
                        <tr id="addNeuesThema" style='display: none'><td>
                            <div class="formLableNew" onclick="Hide('addNeuesThema');">Hinzufügen</div>
                            <input class="formInput" type="text" name="neuesThema">
                        </td></tr>

                        <tr><td>
                            <div class="formLable" onclick="ShowTR('addNeueBesetzung');">Besetzung</div>
                            <select id="addBesetzung" class="formSelect" name="besetzung">
                            <?php
                                $sql = "SELECT * FROM noa_besetzung";
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
                        </td></tr>
                        
                        <tr id="addNeueBesetzung" style='display: none'><td>
                            <div class="formLableNew" onclick="Hide('addNeueBesetzung');">Hinzufügen</div>
                            <input class="formInput" type="text" name="neueBesetzung">
                        </td></tr>

                        <tr><td>
                            <div class="formLable">Komponist</div>
                            <input class="formInput" type="text" name="komponist">
                        </td></tr>

                        <tr><td>
                            <div class="formLable">Bearbeitung</div>
                            <input class="formInput" type="text" name="bearbeitung">
                        </td></tr>

                        <tr><td>
                            <div class="formLable">Texter</div>
                            <input class="formInput" type="text" name="texter">
                        </td></tr>

                        <tr><td>
                            <div class="formLable" onclick="ShowTR('addNeuerVertrag');">Verlag</div>
                            <select class="formSelect" name="verlag">
                                <option value='nd'></option>
                            <?php
                                $sql = "SELECT * FROM noa_verlag ORDER BY ve_name ASC";
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
                        </td></tr>
                        
                        <tr id="addNeuerVertrag" style='display: none'><td>
                            <div class="formLableNew" onclick="Hide('addNeuerVertrag');">Hinzufügen</div>
                            <input class="formInput" type="text" name="neuerVerlag">
                        </td></tr>
                        
                        <tr><td>
                            <div class="formLable">Werknummer</div>
                            <input class="formInput" type="text" name="werknummer">
                        </td></tr>
                        
                        <tr><td>
                            <div class="formLable">Status</div>
                            <select class="formSelect" id="addStatus" name="status">
                                <option value='akti'>Aktiv</option>
                                <option value='arch'>Archiviert</option>
                                <option value='verl'>Verliehen</option>
                                <option value='entf'>Entfernt</option>
                            </select>
                        </td></tr>
                        
                        <tr><td>
                            <button class="formSubmit" type="submit">Hinzufügen</button>
                            <button class="formReset" type="reset">Abbrechen</button>
                        </td></tr>

                    </table>    
                </form>
            </div>
        </div>
        
    </body>
</html>
<?php 
      $conn->close();
?>