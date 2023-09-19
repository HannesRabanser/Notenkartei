<?php
    if(isset($_GET['del'])) {
        //Datenbankverbindung aufbauen
        include 'databaseCon.php';

        //Katigorie
        if($_GET['del'] == 'ka'){
            $ka_id = $_POST['id'];

            if($ka_id  == ""){
                //echo "leer";
            } else{
                $sql = "DELETE FROM `noa_katigorie` WHERE `ka_id` = $ka_id";

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
                $sql = "DELETE FROM `noa_besetzung` WHERE `be_id` = $be_id";

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
                $sql = "DELETE FROM `noa_z_i_kirchenjahr` WHERE `zik_id` = $zik_id";

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
                $sql = "DELETE FROM `noa_thema` WHERE `th_id` = $th_id";

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
                $sql = "DELETE FROM `noa_verlag` WHERE `ve_id` = $ve_id";

                if ($conn->query($sql) === TRUE) {
                    //echo "Record deleted successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }

        $conn->close();
    }

    header('Location: ../setting.php');
?>