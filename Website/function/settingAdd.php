<?php
    if(isset($_GET['add'])) {
        //Datenbankverbindung aufbauen
        include 'databaseCon.php';

        //Katigorie
        if($_GET['add'] == 'ka'){
            $ka_name = $_POST['name'];
            $ka_prefix = $_POST['prefix'];

            if($ka_name == "" || $ka_prefix == ""){
                //echo "leer";
            } else{
                $sql = "INSERT INTO noa_katigorie (ka_name, ka_prefix) VALUES ('$ka_name', '$ka_prefix')";

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
                $sql = "INSERT INTO noa_besetzung (be_name) VALUES ('$be_name')";

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
                $sql = "INSERT INTO noa_z_i_kirchenjahr (zik_name) VALUES ('$zik_name')";

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
                $sql = "INSERT INTO noa_thema (th_name) VALUES ('$th_name')";

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
                $sql = "INSERT INTO noa_verlag (ve_name) VALUES ('$ve_name')";

                if ($conn->query($sql) === TRUE) {
                    //echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
    
        $conn->close();
    }
    
    header('Location: ../setting.php');
?>