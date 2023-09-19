<?php 
    session_start();
    //Login überprüfen
    if(!isset($_SESSION["userid"])){
        header('Location: index.php');
    }
    //Datenbankverbindung aufbauen
    include 'function/databaseCon.php';
?>
<!DOCTYPE html> 
<html> 
    <head>
        <title>Settings</title>
        <link rel="icon" href="img/icon.svg">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style/main.css">
        <link rel="stylesheet" href="style/settingSite.css">
    <body>
        <div class="container">
            
            <ul class="nav">
                <li>
                    <a href="home.php">Startseite</a>
                </li>
                <li>
                    <a href="setting.php" class="active">Einstellungen</a>
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
            
            <div class="row">
                <!--Katigorie-->
                <div class="settingsBlock">
                    
                    <div class="settingsHeader">Kategorie</div>
                    
                    <!--Knopf Neu-->
                    <img src='img/add.svg' class="buttonAdd" onclick="document.getElementById('addKa').style.display = 'block';
                                                                      document.getElementById('editKa').style.display = 'none';
                                                                      document.getElementById('delKa').style.display = 'none';
                                                                      "><br/><!--zeigt Add an und verstekt Edit oder Del-->

                    <form class="formForm" id="addKa" style="display: none" action="function/settingAdd.php?add=ka" method="post">
                        <div class="formHead">Hinzufügen</div>
                        <div style="clear: both">
                            <div class="formLable">Name:</div>
                            <input class="formInput" name="name" type="text" placeholder="Name">
                        </div>
                        <div style="clear: both">
                            <div class="formLable">Prefix:</div>
                            <input class="formInput" name="prefix" type="text" placeholder="Prefix"><br/>
                        </div>
                        <button class="formSubmit" type="submit">Hinzufügen</button>
                        <button class="formReset" type="reset" onclick="document.getElementById('addKa').style.display = 'none';">Abbrechen</button>
                    </form>
                    
                    <form class="formForm" id="editKa" style="display: none" action='function/settingEdit.php?edit=ka' method='post'>
                        <div class="formHead">Bearbeiten</div>
                        <input id="editKaID" type='hidden' name='id'>
                        <div style="clear: both">
                            <div class="formLable">Name</div>
                            <input id="editKaName" class="formInput" type="text" name='name' placeholder="Name">
                        </div>
                        <div style="clear: both">
                            <div class="formLable">Prefix</div>
                            <input id="editKaPrefix" class="formInput" type="text" name="prefix" placeholder="Prefix"><br/>
                        </div>
                        <button class="formSubmit" type='submit'>Bearbeiten</button>
                        <button class="formReset" type="reset" onclick="document.getElementById('editKa').style.display = 'none';">Abbrechen</button>
                    </form>

                    <form class="formForm" id="delKa" style="display: none" action='function/settingDel.php?del=ka' method='post'>
                        <input id="delKaID" type='hidden' name='id'>
                        <div id="delKaName" class="formHead"></div>
                        <button class="formSubmit" type='submit'>Löschen</button>
                        <button class="formReset" type="reset" onclick="document.getElementById('delKa').style.display = 'none';">Abbrechen</button>
                    </form>
                    
                    <table class="tableOutput">
                        <tr>
                            <th>Name</th>
                            <th> Prefix</th>
                            <th/>
                            <th/>
                        </tr>

                        <?php 
                        $sql = "SELECT * FROM noa_katigorie";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            //Jede Reie der Datenbank anzeigen
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                <td>" . $row["ka_name"]. "</td>
                                <td>" . $row["ka_prefix"]. "</td>
                                <td onclick=\"document.getElementById('editKa').style.display = 'block';
                                     document.getElementById('editKaID').setAttribute('value','".$row["ka_id"]."');
                                     document.getElementById('editKaName').setAttribute('value','".$row["ka_name"]."'); document.getElementById('editKaPrefix').setAttribute('value','".$row["ka_prefix"]."');
                                     document.getElementById('addKa').style.display = 'none';
                                     document.getElementById('delKa').style.display = 'none';
                                     \"><img src='img/edit.svg'></td>
                                <td onclick=\"document.getElementById('delKa').style.display = 'block';
                                     document.getElementById('delKaID').setAttribute('value','".$row["ka_id"]."');
                                     document.getElementById('delKaName').innerHTML = 'Wollen Sie ".$row["ka_name"]." wirklich löschen?';
                                     document.getElementById('addKa').style.display = 'none';
                                     document.getElementById('editKa').style.display = 'none';
                                     \"><img src='img/delete.svg'></td>
                                </tr>";
                            }
                        } else {
                            echo "Keine Einträge";
                        }
                        ?>
                    </table>

                    
                </div>

                <!--Besetzung-->
                <div class="settingsBlock">
                    <div class="settingsHeader">Besetzung</div>

                    <!--Knopf Neu-->
                    <img src='img/add.svg' class="buttonAdd" onclick="document.getElementById('addBe').style.display = 'block';
                                                       document.getElementById('editBe').style.display = 'none';
                                                       document.getElementById('delBe').style.display = 'none';
                                                       "><br/><!--zeigt Add an und verstekt Edit oder Del-->
                    
                    <form class="formForm" id="addBe" style="display: none" action="function/settingAdd.php?add=be" method="post">
                        <div class="formHead">Hinzufügen</div>
                        <div class="formLable">Name:</div>
                        <input class="formInput" name="name" type="text" placeholder="Name"><br/>
                        <button class="formSubmit" type="submit">Hinzufügen</button>
                        <button class="formReset" type="reset" onclick="document.getElementById('addBe').style.display = 'none';">Abbrechen</button>
                    </form>

                    <form class="formForm" id="editBe" style="display: none" action='function/settingEdit.php?edit=be' method='post'>
                        <div class="formHead">Bearbeiten</div>
                        <input id="editBeID" type='hidden' name='id'>
                        <div class="formLable">Name:</div>
                        <input id="editBeName" class="formInput" type="text" name='name' placeholder="Name"><br/>
                        <button class="formSubmit" type='submit'>Bearbeiten</button>
                        <button class="formReset" type="reset" onclick="document.getElementById('editBe').style.display = 'none';">Abbrechen</button>
                    </form>

                    <form class="formForm" id="delBe" style="display: none" action='function/settingDel.php?del=be' method='post'>
                        <input id="delBeID" type='hidden' name='id'>
                        <div id="delBeName" class="formHead"></div>
                        <button class="formSubmit" type='submit'>Löschen</button>
                        <button class="formReset" type="reset" onclick="document.getElementById('delBe').style.display = 'none';">Abbrechen</button>
                    </form>

                    <table class="tableOutput">
                        <tr>
                            <th>Name</th>
                            <th/>
                            <th/>
                        </tr>

                        <?php 
                        $sql = "SELECT * FROM noa_besetzung";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            //Jede Reie der Datenbank anzeigen
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                <td>" . $row["be_name"]. "</td>
                                <td onclick=\"document.getElementById('editBe').style.display = 'block';
                                     document.getElementById('editBeID').setAttribute('value','".$row["be_id"]."');
                                     document.getElementById('editBeName').setAttribute('value','".$row["be_name"]."');
                                     document.getElementById('addBe').style.display = 'none';
                                     document.getElementById('delBe').style.display = 'none';
                                     \"><img src='img/edit.svg'></td>
                                <td onclick=\"document.getElementById('delBe').style.display = 'block';
                                     document.getElementById('delBeID').setAttribute('value','".$row["be_id"]."');
                                     document.getElementById('delBeName').innerHTML = 'Wollen Sie ".$row["be_name"]." wirklich löschen?';
                                     document.getElementById('addBe').style.display = 'none';
                                     document.getElementById('editBe').style.display = 'none';
                                     \"><img src='img/delete.svg'></td>
                                </tr>";
                            }
                        } else {
                            echo "Keine Einträge";
                        }
                        ?>
                    </table>

                    
                </div>
                
                <!--Verlag-->
                <div class="settingsBlock">
                    <div class="settingsHeader">Verlag</div>

                    <!--Knopf Neu-->
                    <img src='img/add.svg' class="buttonAdd" onclick="document.getElementById('addVe').style.display = 'block';
                                                       document.getElementById('editVe').style.display = 'none';
                                                       document.getElementById('delVe').style.display = 'none';
                                                       "><!--zeigt Add an und verstekt Edit oder Del-->

                    <form class="formForm" id="addVe" style="display: none" action="function/settingAdd.php?add=ve" method="post">
                        <div class="formHead">Hinzufügen</div>
                        <div style="clear: both">
                            <div class="formLable">Name:</div>
                            <input class="formInput" name="name" type="text" placeholder="Name"><br/>
                        </div>
                        <button class="formSubmit" type="submit">Hinzufügen</button>
                        <button class="formReset" type="reset" onclick="document.getElementById('addVe').style.display = 'none';">Abbrechen</button>
                    </form>

                    <form class="formForm" id="editVe" style="display: none" action='function/settingEdit.php?edit=ve' method='post'>
                        <div class="formHead">Bearbeiten</div>
                        <input id="editVeID" type='hidden' name='id'>
                        <div class="formLable">Name:</div>
                        <input id="editVeName" class="formInput" type="text" name='name' placeholder="Name"><br/>
                        <button class="formSubmit" type='submit'>Bearbeiten</button>
                        <button class="formReset" type="reset" onclick="document.getElementById('editVe').style.display = 'none';">Abbrechen</button>
                    </form>

                    <form class="formForm" id="delVe" style="display: none" action='function/settingDel.php?del=ve' method='post'>
                        <input id="delVeID" type='hidden' name='id'>
                        <div id="delVeName" class="formHead"></div>
                        <button class="formSubmit" type='submit'>Löschen</button>
                        <button class="formReset" type="reset" onclick="document.getElementById('delVe').style.display = 'none';">Abbrechen</button>
                    </form>
                    
                    <table class="tableOutput">
                        <tr>
                            <th>Name</th>
                            <th/>
                            <th/>
                        </tr>

                        <?php 
                        $sql = "SELECT * FROM noa_verlag";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            //Jede Reie der Datenbank anzeigen
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                <td>" . $row["ve_name"]. "</td>
                                <td onclick=\"document.getElementById('editVe').style.display = 'block';
                                     document.getElementById('editVeID').setAttribute('value','".$row["ve_id"]."');
                                     document.getElementById('editVeName').setAttribute('value','".$row["ve_name"]."');
                                     document.getElementById('addVe').style.display = 'none';
                                     document.getElementById('delVe').style.display = 'none';
                                     \"><img src='img/edit.svg'></td>
                                <td onclick=\"document.getElementById('delVe').style.display = 'block';
                                     document.getElementById('delVeID').setAttribute('value','".$row["ve_id"]."');
                                     document.getElementById('delVeName').innerHTML = 'Wollen Sie ".$row["ve_name"]." wirklich löschen?';
                                     document.getElementById('addVe').style.display = 'none';
                                     document.getElementById('editVe').style.display = 'none';
                                     \"><img src='img/delete.svg'></td>
                                </tr>";
                            }
                        } else {
                            echo "Keine Einträge";
                        }
                        ?>
                    </table>

                </div>
            </div>
            
            <div class="row">
                <!--Zeiten im Kirchenjahr-->
                <div class="settingsBlock">
                    <div class="settingsHeader">Zeiten im Kirchenjahr</div>

                    <!--Knopf Neu-->
                    <img src='img/add.svg' class="buttonAdd" onclick="document.getElementById('addZik').style.display = 'block';
                                                       document.getElementById('editZik').style.display = 'none';
                                                       document.getElementById('delZik').style.display = 'none';
                                                       "><br/><!--zeigt Add an und verstekt Edit oder Del-->

                    <form class="formForm" id="addZik" style="display: none" action="function/settingAdd.php?add=zik" method="post">
                        <div class="formHead">Hinzufügen</div>
                        <div class="formLable">Name:</div>
                        <input class="formInput" name="name" type="text" placeholder="Name"><br/>
                        <button class="formSubmit" type="submit">Hinzufügen</button>
                        <button class="formReset" type="reset" onclick="document.getElementById('addZik').style.display = 'none';">Abbrechen</button>
                    </form>

                    <form class="formForm" id="editZik" style="display: none" action='function/settingEdit.php?edit=zik' method='post'>
                        <div class="formHead">Bearbeiten</div>
                        <input id="editZikID" type='hidden' name='id'>
                        <div class="formLable">Name:</div>
                        <input id="editZikName" class="formInput" type="text" name='name' placeholder="Name"><br/>
                        <button class="formSubmit" type='submit'>Bearbeiten</button>
                        <button class="formReset" type="reset" onclick="document.getElementById('editZik').style.display = 'none';">Abbrechen</button>
                    </form>

                    <form class="formForm" id="delZik" style="display: none" action='function/settingDel.php?del=zik' method='post'>
                        <input id="delZikID" type='hidden' name='id'>
                        <div id="delZikName" class="formHead"></div>
                        <button class="formSubmit" type='submit'>Löschen</button>
                        <button class="formReset" type="reset" onclick="document.getElementById('delZik').style.display = 'none';">Abbrechen</button>
                    </form>
                    
                    <table class="tableOutput">
                        <tr>
                            <th>Name</th>
                            <th/>
                            <th/>
                        </tr>

                        <?php 
                        $sql = "SELECT * FROM noa_z_i_kirchenjahr";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            //Jede Reie der Datenbank anzeigen
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                <td>" . $row["zik_name"]. "</td>
                                <td onclick=\"document.getElementById('editZik').style.display = 'block';
                                     document.getElementById('editZikID').setAttribute('value','".$row["zik_id"]."');
                                     document.getElementById('editZikName').setAttribute('value','".$row["zik_name"]."');
                                     document.getElementById('addZik').style.display = 'none';
                                     document.getElementById('delZik').style.display = 'none';
                                     \"><img src='img/edit.svg'></td>
                                <td onclick=\"document.getElementById('delZik').style.display = 'block';
                                     document.getElementById('delZikID').setAttribute('value','".$row["zik_id"]."');
                                     document.getElementById('delZikName').innerHTML = 'Wollen Sie ".$row["zik_name"]." wirklich löschen?';
                                     document.getElementById('addZik').style.display = 'none';
                                     document.getElementById('editZik').style.display = 'none';
                                     \"><img src='img/delete.svg'></td>
                                </tr>";
                            }
                        } else {
                            echo "Keine Einträge";
                        }
                        ?>
                    </table>
                    
                </div>

                <!--Thema-->
                <div class="settingsBlock">
                    <div class="settingsHeader">Thema</div>

                    <!--Knopf Neu-->
                    <img src='img/add.svg' class="buttonAdd" onclick="document.getElementById('addTh').style.display = 'block';
                                                       document.getElementById('editTh').style.display = 'none';
                                                       document.getElementById('delTh').style.display = 'none';
                                                       "><!--zeigt Add an und verstekt Edit oder Del-->

                    <form class="formForm" id="addTh" style="display: none" action="function/settingAdd.php?add=th" method="post">
                        <div class="formHead">Hinzufügen</div>
                        <div class="formLable">Name:</div>
                        <input class="formInput" name="name" type="text"  placeholder="Name"><br/>
                        <button class="formSubmit" type="submit">Hinzufügen</button>
                        <button class="formReset" type="reset" onclick="document.getElementById('addTh').style.display = 'none';">Abbrechen</button>
                    </form>

                    <form class="formForm" id="editTh" style="display: none" action='function/settingEdit.php?edit=th' method='post'>
                        <div class="formHead">Bearbeiten</div>
                        <input id="editThID" type='hidden' name='id'>
                        <div class="formLable">Name:</div>
                        <input id="editThName" class="formInput" type="text" name='name' placeholder="Name"><br/>
                        <button class="formSubmit" type='submit'>Bearbeiten</button>
                        <button class="formReset" type="reset" onclick="document.getElementById('editTh').style.display = 'none';">Abbrechen</button>
                    </form>

                    <form class="formForm" id="delTh" style="display: none" action='function/settingDel.php?del=th' method='post'>
                        <input id="delThID" type='hidden' name='id'>
                        <div id="delThName" class="formHead"></div>
                        <button class="formSubmit" type='submit'>Löschen</button>
                        <button class="formReset" type="reset" onclick="document.getElementById('delTh').style.display = 'none';">Abbrechen</button>
                    </form>
                    
                    <table class="tableOutput">
                        <tr>
                            <th>Name</th>
                            <th/>
                            <th/>
                        </tr>

                        <?php 
                        $sql = "SELECT * FROM noa_thema";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            //Jede Reie der Datenbank anzeigen
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                <td>" . $row["th_name"]. "</td>
                                <td onclick=\"document.getElementById('editTh').style.display = 'block';
                                     document.getElementById('editThID').setAttribute('value','".$row["th_id"]."');
                                     document.getElementById('editThName').setAttribute('value','".$row["th_name"]."');
                                     document.getElementById('addTh').style.display = 'none';
                                     document.getElementById('delTh').style.display = 'none';
                                     \"><img src='img/edit.svg'></td>
                                <td onclick=\"document.getElementById('delTh').style.display = 'block';
                                     document.getElementById('delThID').setAttribute('value','".$row["th_id"]."');
                                     document.getElementById('delThName').innerHTML = 'Wollen Sie ".$row["th_name"]." wirklich löschen?';
                                     document.getElementById('addTh').style.display = 'none';
                                     document.getElementById('editTh').style.display = 'none';
                                     \"><img src='img/delete.svg'></td>
                                </tr>";
                            }
                        } else {
                            echo "Keine Einträge";
                        }
                        ?>
                    </table>

                </div>
            </div>
            <div style="clear: both"></div>
        </div>
    </body>
</html>
<?php 
      $conn->close();
?>