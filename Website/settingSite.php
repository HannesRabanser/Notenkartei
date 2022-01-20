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
 
    if(isset($_GET['add'])) {

        //Katigorie
        if($_GET['add'] == 'ka'){
            $ka_name = $_POST['name'];
            $ka_prefix = $_POST['prefix'];

            if($ka_name == "" || $ka_prefix == ""){
                //echo "leer";
            } else{
                $sql = "INSERT INTO tb_katigorie (ka_name, ka_prefix) VALUES ('$ka_name', '$ka_prefix')";

                if ($conn->query($sql) === TRUE) {
                    //echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }

        //Besetzung
        if($_GET['add'] == 'be'){
            $be_name = $_POST['name'];

            if($be_name == ""){
                //echo "leer";
            } else{
                $sql = "INSERT INTO tb_besetzung (be_name) VALUES ('$be_name')";

                if ($conn->query($sql) === TRUE) {
                    //echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }

        //Zeiten im Kirchenjahr
        if($_GET['add'] == 'zik'){
            $zik_name = $_POST['name'];

            if($zik_name == ""){
                //echo "leer";
            } else{
                $sql = "INSERT INTO tb_z_i_kirchenjahr (zik_name) VALUES ('$zik_name')";

                if ($conn->query($sql) === TRUE) {
                    //echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }

        //Thema
        if($_GET['add'] == 'th'){
            $th_name = $_POST['name'];

            if($th_name == ""){
                //echo "leer";
            } else{
                $sql = "INSERT INTO tb_thema (th_name) VALUES ('$th_name')";

                if ($conn->query($sql) === TRUE) {
                    //echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }

        //Verlag
        if($_GET['add'] == 've'){
            $ve_name = $_POST['name'];

            if($ve_name == ""){
                //echo "leer";
            } else{
                $sql = "INSERT INTO tb_verlag (ve_name) VALUES ('$ve_name')";

                if ($conn->query($sql) === TRUE) {
                    //echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
    }

    if(isset($_GET['edit'])) {

        //Katigorie
        if($_GET['edit'] == 'ka'){
            $ka_id = $_POST['id'];
            $ka_name = $_POST['name'];
            $ka_prefix = $_POST['prefix'];

            if($ka_name == "" || $ka_prefix == ""){
                //echo "leer";
            } else{
                $sql = "UPDATE `tb_katigorie` SET `ka_name`='$ka_name',`ka_prefix`='$ka_prefix' WHERE ka_id = $ka_id";

                if ($conn->query($sql) === TRUE) {
                    //echo "Record updated successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }

        //Besetzung
        if($_GET['edit'] == 'be'){
            $be_id = $_POST['id'];
            $be_name = $_POST['name'];

            if($be_name == ""){
                //echo "leer";
            } else{
                $sql = "UPDATE `tb_besetzung` SET `be_name`='$be_name' WHERE be_id = $be_id";

                if ($conn->query($sql) === TRUE) {
                    //echo "Record updated successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }

        //Zeiten im Kirchenjahr
        if($_GET['edit'] == 'zik'){
            $zik_id = $_POST['id'];
            $zik_name = $_POST['name'];

            if($zik_name == ""){
                //echo "leer";
            } else{
                $sql = "UPDATE `tb_z_i_kirchenjahr` SET `zik_name`='$zik_name' WHERE zik_id = $zik_id";

                if ($conn->query($sql) === TRUE) {
                    //echo "Record updated successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }

        //Thema
        if($_GET['edit'] == 'th'){
            $th_id = $_POST['id'];
            $th_name = $_POST['name'];

            if($th_name == ""){
                //echo "leer";
            } else{
                $sql = "UPDATE `tb_thema` SET `th_name`='$th_name' WHERE th_id = $th_id";

                if ($conn->query($sql) === TRUE) {
                    //echo "Record updated successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }

        //Verlag
        if($_GET['edit'] == 've'){
            $ve_id = $_POST['id'];
            $ve_name = $_POST['name'];

            if($ve_name == ""){
                //echo "leer";
            } else{
                $sql = "UPDATE `tb_verlag` SET `ve_name`='$ve_name' WHERE ve_id = $ve_id";

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
        if($_GET['del'] == 'ka'){
            $ka_id = $_POST['id'];

            if($ka_id  == ""){
                //echo "leer";
            } else{
                $sql = "DELETE FROM `tb_katigorie` WHERE `ka_id` = $ka_id";

                if ($conn->query($sql) === TRUE) {
                    //echo "Record deleted successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }

        //Besetzung
        if($_GET['del'] == 'be'){
            $be_id = $_POST['id'];

            if($be_id  == ""){
                //echo "leer";
            } else{
                $sql = "DELETE FROM `tb_besetzung` WHERE `be_id` = $be_id";

                if ($conn->query($sql) === TRUE) {
                    //echo "Record deleted successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }

        //Zeiten im Kirchenjahr
        if($_GET['del'] == 'zik'){
            $zik_id = $_POST['id'];

            if($zik_id  == ""){
                //echo "leer";
            } else{
                $sql = "DELETE FROM `tb_z_i_kirchenjahr` WHERE `zik_id` = $zik_id";

                if ($conn->query($sql) === TRUE) {
                    //echo "Record deleted successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }

        //Thema
        if($_GET['del'] == 'th'){
            $th_id = $_POST['id'];

            if($th_id  == ""){
                //echo "leer";
            } else{
                $sql = "DELETE FROM `tb_thema` WHERE `th_id` = $th_id";

                if ($conn->query($sql) === TRUE) {
                    //echo "Record deleted successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }

        //verlag
        if($_GET['del'] == 've'){
            $ve_id = $_POST['id'];

            if($ve_id  == ""){
                //echo "leer";
            } else{
                $sql = "DELETE FROM `tb_verlag` WHERE `ve_id` = $ve_id";

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
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style/main.css">
        <link rel="stylesheet" href="style/settingSite.css">
        <link rel="icon" href="">
    </head> 
    <body>
        <div class="container">
            <header>
                test
            </header>
            
            
            
            <!--Katigorie-->
            <div class="settingsBlock">
                <div class="settingsHeader">Kategorie</div>
                
                <!--Knopf Neu-->
                <button class="buttonAdd" onclick="document.getElementById('addKa').style.display = 'block';
                                                   document.getElementById('editKa').style.display = 'none';
                                                   document.getElementById('delKa').style.display = 'none';
                                                   ">Neu</button><br/><!--zeigt Add an und verstekt Edit oder Del-->
                
                <table class="tableOutput">
                    <tr>
                        <th>Name</th>
                        <th> Prefix</th>
                        <th/>
                        <th/>
                    </tr>

                    <?php 
                    $sql = "SELECT * FROM tb_katigorie";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        //Jede Reie der Datenbank anzeigen
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                            <td>" . $row["ka_name"]. "</td>
                            <td>" . $row["ka_prefix"]. "</td>
                            <td><button onclick=\"document.getElementById('editKa').style.display = 'block';
                                 document.getElementById('editKaID').setAttribute('value','".$row["ka_id"]."');
                                 document.getElementById('editKaName').setAttribute('value','".$row["ka_name"]."');
                                 document.getElementById('editKaPrefix').setAttribute('value','".$row["ka_prefix"]."');
                                 document.getElementById('addKa').style.display = 'none';
                                 document.getElementById('delKa').style.display = 'none';
                                 \">Bearbeiten</button> </td>
                            <td><button onclick=\"document.getElementById('delKa').style.display = 'block';
                                 document.getElementById('delKaID').setAttribute('value','".$row["ka_id"]."');
                                 document.getElementById('delKaName').innerHTML = 'Wollen Sie ".$row["ka_name"]." wirklich löschen?';
                                 document.getElementById('addKa').style.display = 'none';
                                 document.getElementById('editKa').style.display = 'none';
                                 \">Löschen</button> </td>
                            </tr>";
                        }
                    } else {
                        echo "Keine Einträge";
                    }
                    ?>
                </table>
                
                <form class="formForm" id="addKa" style="display: none" action="?add=ka" method="post">
                    <div class="formHead">Hinzufügen</div>
                    <div class="formLable">Name</div>
                    <input class="formInput" name="name" type="text">
                    <div class="formLable">Prefix</div>
                    <input class="formInput" name="prefix" type="text"><br/>
                    <button class="formSubmit" type="submit">Hinzufügen</button>
                    <button class="formReset" type="reset" onclick="document.getElementById('addKa').style.display = 'none';">Abbrechen</button>
                </form>

                <form class="formForm" id="editKa" style="display: none" action='?edit=ka' method='post'>
                    <div class="formHead">Bearbeiten</div>
                    <input id="editKaID" type='hidden' name='id'>
                    <div class="formLable">Name</div>
                    <input id="editKaName" class="formInput" type="text" name='name'>
                    <div class="formLable">Prefix</div>
                    <input id="editKaPrefix" class="formInput" type="text" name="prefix"><br/>
                    <button class="formSubmit" type='submit'>Bearbeiten</button>
                    <button class="formReset" type="reset" onclick="document.getElementById('editKa').style.display = 'none';">Abbrechen</button>
                </form>
                
                <form class="formForm" id="delKa" style="display: none" action='?del=ka' method='post'>
                    <input id="delKaID" type='hidden' name='id'>
                    <div id="delKaName" class="formHead"></div>
                    <button class="formSubmit" type='submit'>Löschen</button>
                    <button class="formReset" type="reset" onclick="document.getElementById('delKa').style.display = 'none';">Abbrechen</button>
                </form>
            </div>
            
            <!--Besetzung-->
            <div class="settingsBlock">
                <div class="settingsHeader">Besetzung</div>
                
                <!--Knopf Neu-->
                <button class="buttonAdd" onclick="document.getElementById('addBe').style.display = 'block';
                                                   document.getElementById('editBe').style.display = 'none';
                                                   document.getElementById('delBe').style.display = 'none';
                                                   ">Neu</button><br/><!--zeigt Add an und verstekt Edit oder Del-->
                
                <table class="tableOutput">
                    <tr>
                        <th>Name</th>
                        <th/>
                        <th/>
                    </tr>

                    <?php 
                    $sql = "SELECT * FROM tb_besetzung";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        //Jede Reie der Datenbank anzeigen
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                            <td>" . $row["be_name"]. "</td>
                            <td><button onclick=\"document.getElementById('editBe').style.display = 'block';
                                 document.getElementById('editBeID').setAttribute('value','".$row["be_id"]."');
                                 document.getElementById('editBeName').setAttribute('value','".$row["be_name"]."');
                                 document.getElementById('addBe').style.display = 'none';
                                 document.getElementById('delBe').style.display = 'none';
                                 \">Bearbeiten</button> </td>
                            <td><button onclick=\"document.getElementById('delBe').style.display = 'block';
                                 document.getElementById('delBeID').setAttribute('value','".$row["be_id"]."');
                                 document.getElementById('delBeName').innerHTML = 'Wollen Sie ".$row["be_name"]." wirklich löschen?';
                                 document.getElementById('addBe').style.display = 'none';
                                 document.getElementById('editBe').style.display = 'none';
                                 \">Löschen</button> </td>
                            </tr>";
                        }
                    } else {
                        echo "Keine Einträge";
                    }
                    ?>
                </table>
                
                <form class="formForm" id="addBe" style="display: none" action="?add=be" method="post">
                    <div class="formHead">Hinzufügen</div>
                    <div class="formLable">Name</div>
                    <input class="formInput" name="name" type="text"><br/>
                    <button class="formSubmit" type="submit">Hinzufügen</button>
                    <button class="formReset" type="reset" onclick="document.getElementById('addBe').style.display = 'none';">Abbrechen</button>
                </form>

                <form class="formForm" id="editBe" style="display: none" action='?edit=be' method='post'>
                    <div class="formHead">Bearbeiten</div>
                    <input id="editBeID" type='hidden' name='id'>
                    <div class="formLable">Name</div>
                    <input id="editBeName" class="formInput" type="text" name='name'><br/>
                    <button class="formSubmit" type='submit'>Bearbeiten</button>
                    <button class="formReset" type="reset" onclick="document.getElementById('editBe').style.display = 'none';">Abbrechen</button>
                </form>
                
                <form class="formForm" id="delBe" style="display: none" action='?del=be' method='post'>
                    <input id="delBeID" type='hidden' name='id'>
                    <div id="delBeName" class="formHead"></div>
                    <button class="formSubmit" type='submit'>Löschen</button>
                    <button class="formReset" type="reset" onclick="document.getElementById('delBe').style.display = 'none';">Abbrechen</button>
                </form>
            </div>
            
            <!--Zeiten im Kirchenjahr-->
            <div class="settingsBlock">
                <div class="settingsHeader">Zeiten im Kirchenjahr</div>
                
                <!--Knopf Neu-->
                <button class="buttonAdd" onclick="document.getElementById('addZik').style.display = 'block';
                                                   document.getElementById('editZik').style.display = 'none';
                                                   document.getElementById('delZik').style.display = 'none';
                                                   ">Neu</button><br/><!--zeigt Add an und verstekt Edit oder Del-->
                
                <table class="tableOutput">
                    <tr>
                        <th>Name</th>
                        <th/>
                        <th/>
                    </tr>

                    <?php 
                    $sql = "SELECT * FROM tb_z_i_kirchenjahr";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        //Jede Reie der Datenbank anzeigen
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                            <td>" . $row["zik_name"]. "</td>
                            <td><button onclick=\"document.getElementById('editZik').style.display = 'block';
                                 document.getElementById('editZikID').setAttribute('value','".$row["zik_id"]."');
                                 document.getElementById('editZikName').setAttribute('value','".$row["zik_name"]."');
                                 document.getElementById('addZik').style.display = 'none';
                                 document.getElementById('delZik').style.display = 'none';
                                 \">Bearbeiten</button> </td>
                            <td><button onclick=\"document.getElementById('delZik').style.display = 'block';
                                 document.getElementById('delZikID').setAttribute('value','".$row["zik_id"]."');
                                 document.getElementById('delZikName').innerHTML = 'Wollen Sie ".$row["zik_name"]." wirklich löschen?';
                                 document.getElementById('addZik').style.display = 'none';
                                 document.getElementById('editZik').style.display = 'none';
                                 \">Löschen</button> </td>
                            </tr>";
                        }
                    } else {
                        echo "Keine Einträge";
                    }
                    ?>
                </table>
                
                <form class="formForm" id="addZik" style="display: none" action="?add=zik" method="post">
                    <div class="formHead">Hinzufügen</div>
                    <div class="formLable">Name</div>
                    <input class="formInput" name="name" type="text"><br/>
                    <button class="formSubmit" type="submit">Hinzufügen</button>
                    <button class="formReset" type="reset" onclick="document.getElementById('addZik').style.display = 'none';">Abbrechen</button>
                </form>

                <form class="formForm" id="editZik" style="display: none" action='?edit=zik' method='post'>
                    <div class="formHead">Bearbeiten</div>
                    <input id="editZikID" type='hidden' name='id'>
                    <div class="formLable">Name</div>
                    <input id="editZikName" class="formInput" type="text" name='name'><br/>
                    <button class="formSubmit" type='submit'>Bearbeiten</button>
                    <button class="formReset" type="reset" onclick="document.getElementById('editZik').style.display = 'none';">Abbrechen</button>
                </form>
                
                <form class="formForm" id="delZik" style="display: none" action='?del=zik' method='post'>
                    <input id="delZikID" type='hidden' name='id'>
                    <div id="delZikName" class="formHead"></div>
                    <button class="formSubmit" type='submit'>Löschen</button>
                    <button class="formReset" type="reset" onclick="document.getElementById('delZik').style.display = 'none';">Abbrechen</button>
                </form>
            </div>
            
            <!--Thema-->
            <div class="settingsBlock">
                <div class="settingsHeader">Thema</div>
                
                <!--Knopf Neu-->
                <button class="buttonAdd" onclick="document.getElementById('addTh').style.display = 'block';
                                                   document.getElementById('editTh').style.display = 'none';
                                                   document.getElementById('delTh').style.display = 'none';
                                                   ">Neu</button><br/><!--zeigt Add an und verstekt Edit oder Del-->
                
                <table class="tableOutput">
                    <tr>
                        <th>Name</th>
                        <th/>
                        <th/>
                    </tr>

                    <?php 
                    $sql = "SELECT * FROM tb_thema";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        //Jede Reie der Datenbank anzeigen
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                            <td>" . $row["th_name"]. "</td>
                            <td><button onclick=\"document.getElementById('editTh').style.display = 'block';
                                 document.getElementById('editThID').setAttribute('value','".$row["th_id"]."');
                                 document.getElementById('editThName').setAttribute('value','".$row["th_name"]."');
                                 document.getElementById('addTh').style.display = 'none';
                                 document.getElementById('delTh').style.display = 'none';
                                 \">Bearbeiten</button> </td>
                            <td><button onclick=\"document.getElementById('delTh').style.display = 'block';
                                 document.getElementById('delThID').setAttribute('value','".$row["th_id"]."');
                                 document.getElementById('delThName').innerHTML = 'Wollen Sie ".$row["th_name"]." wirklich löschen?';
                                 document.getElementById('addTh').style.display = 'none';
                                 document.getElementById('editTh').style.display = 'none';
                                 \">Löschen</button> </td>
                            </tr>";
                        }
                    } else {
                        echo "Keine Einträge";
                    }
                    ?>
                </table>
                
                <form class="formForm" id="addTh" style="display: none" action="?add=th" method="post">
                    <div class="formHead">Hinzufügen</div>
                    <div class="formLable">Name</div>
                    <input class="formInput" name="name" type="text"><br/>
                    <button class="formSubmit" type="submit">Hinzufügen</button>
                    <button class="formReset" type="reset" onclick="document.getElementById('addTh').style.display = 'none';">Abbrechen</button>
                </form>

                <form class="formForm" id="editTh" style="display: none" action='?edit=th' method='post'>
                    <div class="formHead">Bearbeiten</div>
                    <input id="editThID" type='hidden' name='id'>
                    <div class="formLable">Name</div>
                    <input id="editThName" class="formInput" type="text" name='name'><br/>
                    <button class="formSubmit" type='submit'>Bearbeiten</button>
                    <button class="formReset" type="reset" onclick="document.getElementById('editTh').style.display = 'none';">Abbrechen</button>
                </form>
                
                <form class="formForm" id="delTh" style="display: none" action='?del=th' method='post'>
                    <input id="delThID" type='hidden' name='id'>
                    <div id="delThName" class="formHead"></div>
                    <button class="formSubmit" type='submit'>Löschen</button>
                    <button class="formReset" type="reset" onclick="document.getElementById('delTh').style.display = 'none';">Abbrechen</button>
                </form>
            </div>
            
            <!--Verlag-->
            <div class="settingsBlock">
                <div class="settingsHeader">Verlag</div>
                
                <!--Knopf Neu-->
                <button class="buttonAdd" onclick="document.getElementById('addVe').style.display = 'block';
                                                   document.getElementById('editVe').style.display = 'none';
                                                   document.getElementById('delVe').style.display = 'none';
                                                   ">Neu</button><br/><!--zeigt Add an und verstekt Edit oder Del-->
                
                <table class="tableOutput">
                    <tr>
                        <th>Name</th>
                        <th/>
                        <th/>
                    </tr>

                    <?php 
                    $sql = "SELECT * FROM tb_verlag";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        //Jede Reie der Datenbank anzeigen
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                            <td>" . $row["ve_name"]. "</td>
                            <td><button onclick=\"document.getElementById('editVe').style.display = 'block';
                                 document.getElementById('editVeID').setAttribute('value','".$row["ve_id"]."');
                                 document.getElementById('editVeName').setAttribute('value','".$row["ve_name"]."');
                                 document.getElementById('addVe').style.display = 'none';
                                 document.getElementById('delVe').style.display = 'none';
                                 \">Bearbeiten</button> </td>
                            <td><button onclick=\"document.getElementById('delVe').style.display = 'block';
                                 document.getElementById('delVeID').setAttribute('value','".$row["ve_id"]."');
                                 document.getElementById('delVeName').innerHTML = 'Wollen Sie ".$row["ve_name"]." wirklich löschen?';
                                 document.getElementById('addVe').style.display = 'none';
                                 document.getElementById('editVe').style.display = 'none';
                                 \">Löschen</button> </td>
                            </tr>";
                        }
                    } else {
                        echo "Keine Einträge";
                    }
                    ?>
                </table>
                
                <form class="formForm" id="addVe" style="display: none" action="?add=ve" method="post">
                    <div class="formHead">Hinzufügen</div>
                    <div class="formLable">Name</div>
                    <input class="formInput" name="name" type="text"><br/>
                    <button class="formSubmit" type="submit">Hinzufügen</button>
                    <button class="formReset" type="reset" onclick="document.getElementById('addVe').style.display = 'none';">Abbrechen</button>
                </form>

                <form class="formForm" id="editVe" style="display: none" action='?edit=ve' method='post'>
                    <div class="formHead">Bearbeiten</div>
                    <input id="editVeID" type='hidden' name='id'>
                    <div class="formLable">Name</div>
                    <input id="editVeName" class="formInput" type="text" name='name'><br/>
                    <button class="formSubmit" type='submit'>Bearbeiten</button>
                    <button class="formReset" type="reset" onclick="document.getElementById('editVe').style.display = 'none';">Abbrechen</button>
                </form>
                
                <form class="formForm" id="delVe" style="display: none" action='?del=ve' method='post'>
                    <input id="delVeID" type='hidden' name='id'>
                    <div id="delVeName" class="formHead"></div>
                    <button class="formSubmit" type='submit'>Löschen</button>
                    <button class="formReset" type="reset" onclick="document.getElementById('delVe').style.display = 'none';">Abbrechen</button>
                </form>
            </div>
            
            
            
        </div>
    </body>
</html>
<?php 
      $conn->close();
?>