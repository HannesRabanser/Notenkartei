<?php
    if(isset($_GET['edit'])) {
        //Datenbankverbindung aufbauen
        include 'databaseCon.php';

        //Katigorie
        if($_GET['edit'] == 'ka'){
            $ka_id = $_POST['id'];
            $ka_name = $_POST['name'];
            $ka_prefix = $_POST['prefix'];

            if($ka_name == "" || $ka_prefix == ""){
                //echo "leer";
            } else{
                $sql = "UPDATE `noa_katigorie` SET `ka_name`='$ka_name',`ka_prefix`='$ka_prefix' WHERE ka_id = $ka_id";

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
                $sql = "UPDATE `noa_besetzung` SET `be_name`='$be_name' WHERE be_id = $be_id";

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
                $sql = "UPDATE `noa_z_i_kirchenjahr` SET `zik_name`='$zik_name' WHERE zik_id = $zik_id";

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
                $sql = "UPDATE `noa_thema` SET `th_name`='$th_name' WHERE th_id = $th_id";

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
                $sql = "UPDATE `noa_verlag` SET `ve_name`='$ve_name' WHERE ve_id = $ve_id";

                if ($conn->query($sql) === TRUE) {
                    //echo "Record updated successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }

        $conn->close();
    }
    
    header('Location: ../setting.php');
?>