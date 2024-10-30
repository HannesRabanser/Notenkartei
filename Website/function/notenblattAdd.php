<?php
    if(isset($_GET['add'])){

        //Datenbankverbindung aufbauen
        include 'databaseCon.php';

        $kategorie = $_POST['kategorie'];
        if (strlen($_POST['katalognummer']) == 1){
            $katalognummer = "0" . "0" . $_POST['katalognummer'];
        }
        elseif(strlen($_POST['katalognummer']) == 2){
            $katalognummer = "0" . $_POST['katalognummer'];
        }
        else{
            $katalognummer = $_POST['katalognummer'];
        }
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
                foreach($thema as $value){
                    $sql = "INSERT INTO `noa_nb_th`(`nb_th_thema`, `nb_th_notenblatt`) VALUES ($value,$id)";
                    if ($conn->query($sql) === TRUE) {

                    }else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }

            if($z_i_kirchenjahr != 'nd'){
                foreach($z_i_kirchenjahr as $value){
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
        $conn->close();
    }

    header('Location: ../home.php');
?>