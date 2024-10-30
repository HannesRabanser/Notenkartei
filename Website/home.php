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
                    <form action='?search=1' method='post' class="searchBar">
                        <input type="search" name="searchBar" placeholder="Suche" value="<?php if(isset($_POST['searchBar'])) {echo $_POST['searchBar'];}?>">
                        
                        <select class="" name="kategorie">
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
                        
                        <select class="" name="z_i_kirchenjahr">
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
                        
                        <select class="" name="thema">
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
                        
                        <select class="" name="besetzung">
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
                        
                        <input type="submit" value="Suche">
                    </form>
                    
                    <img src="img/add.svg" class="icon" onclick="document.getElementById('newBlock').style.display = 'block';">
                </div>

                <table class="tableOutput">
                    <tr>
                        <th></th>
                        <th>Titel</th>
                        <th>Untertitel</th>
                        <th>Zugehoerigkeit</th>
                        <th>Katigorie</th>
                        <th>Besetzung</th>
                        <th>Thema</th>
                        <th>Zeit im Kirchenjahr</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php 
                    $sql = "SELECT `nb_id`, `nb_katalognummer`, `nb_titel`, `nb_untertitel`, `nb_katigorie`,`nb_besetzung`, `nb_komponist`, `nb_bearbeitung`, `nb_texter`, `nb_werknummer`, `nb_status`, `nb_zugehoerigkeit`, ka_name, ka_prefix, ve_name, be_name, nb_verlag
                        FROM `noa_notenblatt` 
                        LEFT JOIN noa_katigorie 
                        ON nb_katigorie = ka_id 
                        LEFT JOIN noa_verlag 
                        ON ve_id = nb_verlag 
                        LEFT JOIN noa_besetzung 
                        ON be_id = nb_besetzung";
                    
                    if(isset($_GET['search'])) {
                        if($_GET['search'] == '1'){
                            $searchBar = $_POST['searchBar'];
                            $besetzung = $_POST['besetzung'];
                            $kategorie = $_POST['kategorie'];
                            $z_i_kirchenjahr = $_POST['z_i_kirchenjahr'];
                            $thema = $_POST['thema'];
                            
                            
                            $sql .= " WHERE (nb_titel LIKE '%" . $searchBar . "%' 
                            OR nb_untertitel LIKE '%" . $searchBar . "%' 
                            OR nb_zugehoerigkeit LIKE '%" . $searchBar . "%'
                            OR nb_komponist LIKE '%" . $searchBar . "%')";
                            
                            if($besetzung != "nd"){
                                $sql .= " AND (nb_besetzung = " . $besetzung . ")";
                            }
                            if($kategorie != "nd"){
                                $sql .= " AND (nb_katigorie = " . $kategorie . ")";
                            }
                            if($z_i_kirchenjahr != "nd"){
                                $sql .= " AND (nb_id in ( SELECT z.nb_zik_notenblatt FROM noa_nb_zik AS z WHERE z.nb_zik_z_i_kirchenjahr = " . $z_i_kirchenjahr . "))";
                            }
                            if($thema != "nd"){
                                $sql .= " AND (nb_id in ( SELECT th.nb_th_notenblatt FROM noa_nb_th AS th WHERE th.nb_th_thema = " . $thema . "))";
                            }
                        }
                    }
                    
                    $sql .= " ORDER BY nb_katigorie, nb_katalognummer";
                    
                    
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        //Jede Reie der Datenbank anzeigen
                        while($row = $result->fetch_assoc()) {
                            if($row["nb_status"] == "akti" || $row["nb_status"] == "arch"){
                                
                                $sqlZik = "SELECT z.zik_name, z.zik_id 
                                    FROM noa_nb_zik AS nz 
                                    JOIN noa_z_i_kirchenjahr AS z 
                                    ON nz.nb_zik_z_i_kirchenjahr = z.zik_id 
                                    WHERE nz.nb_zik_notenblatt = " . $row["nb_id"];
                                $resultZik = $conn->query($sqlZik);
                                $zik = "";
                                $zikSel = "[";
                                if ($result->num_rows > 0) {
                                    $i = 0;
                                    while($rowZik = $resultZik->fetch_assoc()) {
                                    $zik .= $rowZik["zik_name"] . " ";
                                    $zikSel .= "'" . $rowZik["zik_id"] . "',";
                                    }
                                    $zikSel .= "]";
                                }
                                
                                $sqlTh = "SELECT t.th_name, t.th_id 
                                    FROM noa_nb_th AS nt 
                                    JOIN noa_thema AS t 
                                    ON nt.nb_th_thema = t.th_id
                                    WHERE nt.nb_th_notenblatt = " . $row["nb_id"];
                                $resultTh = $conn->query($sqlTh);
                                $the = "";
                                $theSel = "[";
                                if ($result->num_rows > 0) {
                                    $i = 0;
                                    while($rowTh = $resultTh->fetch_assoc()) {
                                    $the .= $rowTh["th_name"] . " ";
                                    $theSel .= "'" .$rowTh["th_id"]. "',";
                                    }
                                    $theSel .= "]";
                                }

                                if($row["nb_verlag"] == ""){
                                    $verlag = "nd";
                                } else{
                                    $verlag = $row["nb_verlag"];
                                }
                                
                                echo "<tr>
                                    <td>" . $row["ka_prefix"] . $row["nb_katalognummer"]. "</td>
                                    <td>" . $row["nb_titel"]. "</td>
                                    <td>" . $row["nb_untertitel"]. "</td>
                                    <td>" . $row["nb_zugehoerigkeit"]. "</td>
                                    <td>" . $row["ka_name"]. "</td>
                                    <td>" . $row["be_name"]. "</td>
                                    <td>" . $the . "</td>
                                    <td>" . $zik . "</td>
                                    <td onclick=\"SetEdit('".$row["nb_id"]."', '".$row["nb_katalognummer"]."', '".$row["nb_titel"]."', '".$row["nb_untertitel"]."', '".$row["nb_zugehoerigkeit"]."', '".$row["nb_komponist"]."', '".$row["nb_bearbeitung"]."', '".$row["nb_texter"]."', '".$row["nb_werknummer"]."', ".$row["nb_katigorie"].", ".$row["nb_besetzung"].", ".$zikSel.", ".$theSel.", '".$verlag."', '".$row["nb_status"]."');\">
                                        <img src='img/edit.svg'>
                                    </td>
                                    <td onclick=\"document.getElementById('more".$row["nb_id"]."').style.display = 'table-row';\">
                                        <img src='img/info.svg'>
                                    </td>
                                </tr>
                                <tr style='display: none' id='more".$row["nb_id"]."'>
                                    <td colspan='9'> <div>Komponist: " . $row["nb_komponist"]. "</div>
                                        <div>Bearbeitung: " . $row["nb_bearbeitung"]. "</div>
                                        <div>Texter: " . $row["nb_texter"]. "</div>
                                        <div>Verlag: " . $row["ve_name"]. "</div>
                                        <div>Werknummer: " . $row["nb_werknummer"]. "</div></td>
                                        <td onclick=\"document.getElementById('more".$row["nb_id"]."').style.display = 'none';\">
                                            <img src='img/cancel.svg'>
                                        </td>
                                </tr>";
                            }
                        }
                    } else {
                        echo "Keine Einträge";
                    }
                    ?>
                </table>
            </div>
            
        </div>
        
        <!-- Bearbeiten -->
        <div id="editBlock" class="editNewBG" style='display: none'>
            <div class="editNewForm">
                <form method="post" action="function/notenblattEdit.php?edit=1">
                    
                    <input id="editID" type="hidden" name="ID">
                    
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
                    
                    <div class="formLable">Nummer</div>
                    <input id="editNummer" class="formInput" type="number" name="katalognummer" max="999" min="1" required>

                    <div class="formLable">Titel</div>
                    <input id="editTitel" class="formInput" type="text" name="titel" required>

                    <div class="formLable">Untertitel</div>
                    <input id="editUntertitel" class="formInput" type="text" name="untertitel">

                    <div class="formLable">Zugehörigkeit</div>
                    <input id="editZugehoerigkeit" class="formInput" type="text" name="zugehoerigkeit">

                    <div class="formLable">Zeit im Kirchenjahr</div>
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

                    <div class="formLable">Thema</div>
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

                    <div class="formLable">Besetzung</div>
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

                    <div class="formLable">Komponist</div>
                    <input id="editKomponist" class="formInput" type="text" name="komponist">

                    <div class="formLable">Bearbeitung</div>
                    <input id="editBearbeitung" class="formInput" type="text" name="bearbeitung">

                    <div class="formLable">Texter</div>
                    <input id="editTexter" class="formInput" type="text" name="texter">

                    <div class="formLable">Verlag</div>
                    <select id="editVerlag" class="formSelect" name="verlag">
                        <option value='nd'></option>
                    <?php
                        $sql = "SELECT * FROM noa_verlag";
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
                    <input id="editWerknummer" class="formInput" type="text" name="werknummer">

                    <div class="formLable">Status</div>
                    <select id="editStatus" class="formSelect" name="status">
                        <option value='akti'>Aktiv</option>
                        <option value='arch'>Archiviert</option>
                        <option value='verl'>Verliehen</option>
                        <option value='entf'>Entfernt</option>
                    </select>
                    <br/>
                    <button class="formSubmit" type="submit">Bearbeiten</button>
                    <button class="formReset" type="reset" onclick="document.getElementById('editBlock').style.display = 'none';">Abbrechen</button>
                    
                </form>
            </div>
        </div>
        
        <!-- Neu -->
        <div id="newBlock" class="editNewBG" style='display: none'>
            <div class="editNewForm">
                <form class="formForm" action="function/notenblattAdd.php?add=1" method="post">

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

                <div class="formLable">Nummer</div>
                <input class="formInput" type="number" name="katalognummer" max="999" min="1" required>

                <div class="formLable">Titel</div>
                <input class="formInput" type="text" name="titel" required>

                <div class="formLable">Untertitel</div>
                <input class="formInput" type="text" name="untertitel">

                <div class="formLable">Zugehörigkeit</div>
                <input class="formInput" type="text" name="zugehörigkeit">

                <div class="formLable">Zeit im Kirchenjahr</div>
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

                <div class="formLable">Thema</div>
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

                <div class="formLable">Besetzung</div>
                <select class="formSelect" name="besetzung">
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
                    $sql = "SELECT * FROM noa_verlag";
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
                <select class="formSelect" id="addStatus" name="status">
                    <option value='akti'>Aktiv</option>
                    <option value='arch'>Archiviert</option>
                    <option value='verl'>Verliehen</option>
                    <option value='entf'>Entfernt</option>
                </select>
                <br/>
                <button class="formSubmit" type="submit">Hinzufügen</button>
                <button class="formReset" type="reset" onclick="document.getElementById('newBlock').style.display = 'none';">Abbrechen</button>

            </form>
            </div>
        </div>
        
    </body>
</html>
<?php 
      $conn->close();
?>