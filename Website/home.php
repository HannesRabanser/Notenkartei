<!DOCTYPE html> 
<?php
    session_start();

    //Weiterleitung zu login wenn ncht angemeldet
    if(!isset($_SESSION["userid"])) {
        header('Location: index.php');
    }

    //Datenbankverbindung aufbauen
    $db_servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_dbname = "noa_notenarchiv";

    $conn = new mysqli($db_servername, $db_username, $db_password, $db_dbname);
    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

   if(isset($_GET['add'])){
        $kategorie = $_POST['kategorie'];
        $katalognummer = $_POST['katalognummer'];
        $titel = $_POST['titel'];
        $untertitel = $_POST['untertitel'];
        $zugehoerigkeit = $_POST['zugehörigkeit'];
        if(isset($_POST['z_i_kirchenjahr'])){
            $z_i_kirchenjahr = $_POST['z_i_kirchenjahr'];
        }else{
            $z_i_kirchenjahr = 'nd';
        }
        if(isset($_POST['thema'])){
            $thema = $_POST['thema'];
        }else{
            $thema = 'nd';
        }
        $besetzung = $_POST['besetzung'];
        $komponist = $_POST['komponist'];
        $bearbeitung = $_POST['bearbeitung'];
        $texter = $_POST['texter'];
        $verlag = $_POST['verlag'];
        $werknummer = $_POST['werknummer'];
        $status = $_POST['status'];
        
        $sql = "SELECT MAX(`nb_id`) FROM `tb_notenblatt`";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $idA = $result->fetch_assoc();
            $id = $idA["MAX(`nb_id`)"];
            $id++;
        }

        $sql = "INSERT INTO `tb_notenblatt`(`nb_id`,`nb_katalognummer`, `nb_titel`, `nb_untertitel`, `nb_katigorie`, `nb_besetzung`, `nb_komponist`, `nb_bearbeitung`, `nb_texter`, `nb_werknummer`, `nb_status`, `nb_zugehoerigkeit`) VALUES ($id,'$katalognummer','$titel','$untertitel',$kategorie,$besetzung,'$komponist','$bearbeitung','$texter','$werknummer','$status','$zugehoerigkeit')";

        if ($conn->query($sql) === TRUE) {

            if($verlag != "nd"){
                $sql = "UPDATE `tb_notenblatt` SET `nb_verlag`= $verlag WHERE `nb_id`=$id";
                if ($conn->query($sql) === TRUE) {

                }else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }

            if($thema != 'nd'){
                foreach($thema  as $value){
                    $sql = "INSERT INTO `tb_nb_th`(`nb_th_thema`, `nb_th_notenblatt`) VALUES ($value,$id)";
                    if ($conn->query($sql) === TRUE) {

                    }else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }

            if($z_i_kirchenjahr != 'nd'){
                foreach($z_i_kirchenjahr  as $value){
                    $sql = "INSERT INTO `tb_nb_zik`(`nb_zik_z_i_kirchenjahr`, `nb_zik_notenblatt`) VALUES ($value,$id)";
                    if ($conn->query($sql) === TRUE) {

                    }else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }

        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if(isset($_GET['edit'])) {
        if($_GET['edit'] == '1'){
            $nb_id = $_POST['ID'];
            $nb_kategorie = $_POST['kategorie'];
            $nb_katalognummer = $_POST['katalognummer'];
            $nb_titel = $_POST['titel'];
            $nb_untertitel = $_POST['untertitel'];
            $nb_zugehoerigkeit = $_POST['zugehoerigkeit'];
            $nb_besetzung = $_POST['besetzung'];
            $nb_komponist = $_POST['komponist'];
            $nb_bearbeitung = $_POST['bearbeitung'];
            $nb_texter = $_POST['texter'];
            $nb_verlag = $_POST['verlag'];
            $nb_werknummer = $_POST['werknummer'];
            $nb_status = $_POST['status'];
            
            if($nb_verlag == "nd"){
                $nb_verlag = "null";
            }
            
            $sql = "UPDATE `tb_notenblatt` SET `nb_katalognummer`='$nb_katalognummer', `nb_titel`='$nb_titel', `nb_untertitel`='$nb_untertitel', `nb_zugehoerigkeit`='$nb_zugehoerigkeit', `nb_katigorie`=$nb_kategorie, `nb_besetzung`=$nb_besetzung, `nb_komponist`='$nb_komponist', `nb_bearbeitung`='$nb_bearbeitung', `nb_texter`='$nb_texter', `nb_verlag`= $nb_verlag, `nb_werknummer`='$nb_werknummer', `nb_status`='$nb_status' WHERE  nb_id = $nb_id";

            if ($conn->query($sql) === TRUE) {
                //echo "Record updated successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            
        }
    }
 ?>
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
                            $sql = "SELECT * FROM tb_katigorie ORDER BY `ka_name`";
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
                            $sql = "SELECT * FROM tb_z_i_kirchenjahr";
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
                            $sql = "SELECT * FROM tb_thema";
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
                            $sql = "SELECT * FROM tb_besetzung";
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
                        FROM `tb_notenblatt` 
                        LEFT JOIN tb_katigorie 
                        ON nb_katigorie = ka_id 
                        LEFT JOIN tb_verlag 
                        ON ve_id = nb_verlag 
                        LEFT JOIN tb_besetzung 
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
                                $sql .= " AND (nb_id in ( SELECT z.nb_zik_notenblatt FROM tb_nb_zik AS z WHERE z.nb_zik_z_i_kirchenjahr = " . $z_i_kirchenjahr . "))";
                            }
                            if($thema != "nd"){
                                $sql .= " AND (nb_id in ( SELECT th.nb_th_notenblatt FROM tb_nb_th AS th WHERE th.nb_th_thema = " . $thema . "))";
                            }
                        }
                    }
                    
                    $sql .= " ORDER BY nb_katigorie, nb_katalognummer";
                    
                    
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        //Jede Reie der Datenbank anzeigen
                        while($row = $result->fetch_assoc()) {
                            if($row["nb_status"] == "akti"){
                                
                                $sqlI = "SELECT z.zik_name 
                                    FROM tb_nb_zik AS nz 
                                    JOIN tb_z_i_kirchenjahr AS z 
                                    ON nz.nb_zik_z_i_kirchenjahr = z.zik_id 
                                    WHERE nz.nb_zik_notenblatt = " . $row["nb_id"];
                                $resultI = $conn->query($sqlI);
                                $zik = "";
                                if ($result->num_rows > 0) {
                                    while($rowI = $resultI->fetch_assoc()) {
                                    $zik .= $rowI["zik_name"] . " ";
                                    }
                                }
                                
                                $sqlI = "SELECT t.th_name
                                    FROM tb_nb_th AS nt 
                                    JOIN tb_thema AS t 
                                    ON nt.nb_th_thema = t.th_id
                                    WHERE nt.nb_th_notenblatt = " . $row["nb_id"];
                                $resultI = $conn->query($sqlI);
                                $the = "";
                                if ($result->num_rows > 0) {
                                    while($rowI = $resultI->fetch_assoc()) {
                                    $the .= $rowI["th_name"] . " ";
                                    }
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
                                <td onclick=\"document.getElementById('editBlock').style.display = 'block'; document.getElementById('editID').setAttribute('value','".$row["nb_id"]."'); document.getElementById('editNummer').setAttribute('value','".$row["nb_katalognummer"]."'); document.getElementById('editTitel').setAttribute('value','".$row["nb_titel"]."'); document.getElementById('editUntertitel').setAttribute('value','".$row["nb_untertitel"]."'); document.getElementById('editZugehoerigkeit').setAttribute('value','".$row["nb_zugehoerigkeit"]."'); document.getElementById('editKomponist').setAttribute('value','".$row["nb_komponist"]."'); document.getElementById('editBearbeitung').setAttribute('value','".$row["nb_bearbeitung"]."'); document.getElementById('editTexter').setAttribute('value','".$row["nb_texter"]."'); document.getElementById('editWerknummer').setAttribute('value','".$row["nb_werknummer"]."'); document.querySelector('#editKategorie').value = ".$row["nb_katigorie"]."; document.querySelector('#editBesetzung').value = ".$row["nb_besetzung"]."; document.querySelector('#editStatus').value = ".$row["nb_status"]."; document.querySelector('#editVerlag').value = ";  
                                if($row["nb_verlag"] == ""){
                                    echo "nd";
                                } else{
                                    echo $row["nb_verlag"];
                                }
                                echo ";\"><img src='img/edit.svg'></td>
                                <td onclick=\"document.getElementById('more".$row["nb_id"]."').style.display = 'table-row';\"><img src='img/info.svg'></td>
                                </tr>
                                <tr style='display: none' id='more".$row["nb_id"]."'>
                                <td colspan='9'> <div>Komponist: " . $row["nb_komponist"]. "</div>
                                    <div>Bearbeitung: " . $row["nb_bearbeitung"]. "</div>
                                    <div>Texter: " . $row["nb_texter"]. "</div>
                                    <div>Verlag: " . $row["ve_name"]. "</div>
                                    <div>Werknummer: " . $row["nb_werknummer"]. "</div></td>
                                    <td onclick=\"document.getElementById('more".$row["nb_id"]."').style.display = 'none';\">
                                    <img src='img/cancel.svg'></td>
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
                <form method="post" action="?edit=1">
                    
                    <input id="editID" type="hidden" name="ID">
                    
                    <div class="formLable">Kategorie</div>
                    <select id="editKategorie" class="formSelect" name="kategorie">
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
                    <input id="editNummer" class="formInput" type="number" name="katalognummer" max="999" min="1" required>

                    <div class="formLable">Titel</div>
                    <input id="editTitel" class="formInput" type="text" name="titel" required>

                    <div class="formLable">Untertitel</div>
                    <input id="editUntertitel" class="formInput" type="text" name="untertitel">

                    <div class="formLable">Zugehörigkeit</div>
                    <input id="editZugehoerigkeit" class="formInput" type="text" name="zugehoerigkeit">
<!--
                    <div class="formLable">Zeit im Kirchenjahr</div>
                    <select class="formSelect" name="z_i_kirchenjahr[]" multiple>
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
                    <select class="formSelect" name="thema[]" multiple>
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
-->
                    <div class="formLable">Besetzung</div>
                    <select id="editBesetzung" class="formSelect" name="besetzung">
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
                    <input id="editKomponist" class="formInput" type="text" name="komponist">

                    <div class="formLable">Bearbeitung</div>
                    <input id="editBearbeitung" class="formInput" type="text" name="bearbeitung">

                    <div class="formLable">Texter</div>
                    <input id="editTexter" class="formInput" type="text" name="texter">

                    <div class="formLable">Verlag</div>
                    <select id="editVerlag" class="formSelect" name="verlag">
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
                <select class="formSelect" name="thema[]" multiple>
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
                <select class="formSelect" name="status">
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