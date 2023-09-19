<?php
    session_start();
    if(!isset($_SESSION["userid"])){
        header('Location: index.php');
    }

    include 'function/databaseCon.php';

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
        
        $sql = "SELECT MAX(`nb_id`) FROM `noa_notenblatt`";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $idA = $result->fetch_assoc();
            $id = $idA["MAX(`nb_id`)"];
            $id++;
        }

        $sql = "INSERT INTO `noa_notenblatt`(`nb_id`,`nb_katalognummer`, `nb_titel`, `nb_untertitel`, `nb_katigorie`, `nb_besetzung`, `nb_komponist`, `nb_bearbeitung`, `nb_texter`, `nb_werknummer`, `nb_status`, `nb_zugehoerigkeit`) VALUES ($id,'$katalognummer','$titel','$untertitel',$kategorie,$besetzung,'$komponist','$bearbeitung','$texter','$werknummer','$status','$zugehoerigkeit')";

            if ($conn->query($sql) === TRUE) {
                
                if($verlag != "nd"){
                    $sql = "UPDATE `noa_notenblatt` SET `nb_verlag`= $verlag WHERE `nb_id`=$id";
                    if ($conn->query($sql) === TRUE) {
                        
                    }else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
                
                if($thema != 'nd'){
                    foreach($thema  as $value){
                        $sql = "INSERT INTO `noa_nb_th`(`nb_th_thema`, `nb_th_notenblatt`) VALUES ($value,$id)";
                        if ($conn->query($sql) === TRUE) {
                        
                        }else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                    }
                }
                
                if(!in_array('nd', $z_i_kirchenjahr)){
                    foreach($z_i_kirchenjahr  as $value){
                        $sql = "INSERT INTO `noa_nb_zik`(`nb_zik_z_i_kirchenjahr`, `nb_zik_notenblatt`) VALUES ($value,$id)";
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
    


?>
<!DOCTYPE html> 
<html> 
    <head>
        <title></title>
        <link rel="icon" href="img/icon.svg">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style/main.css">
        <link rel="stylesheet" href="style/enterSite.css">
    </head> 
    <body>
        <div class="container">

            <form class="formForm" action="?add=1" method="post">

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
                <select class="formSelect" name="status">
                    <option value='akti'>Aktiv</option>
                    <option value='arch'>Archiviert</option>
                    <option value='verl'>Verliehen</option>
                    <option value='entf'>Entfernt</option>
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