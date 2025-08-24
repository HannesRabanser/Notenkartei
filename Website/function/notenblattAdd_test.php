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
            $z_i_kirchenjahr[] = 'nd';
        }
        $neueZiK = $_POST['neueZiK'];
        if(isset($_POST['thema'])){
            $thema = $_POST['thema'];
        }else{
            $thema[] = 'nd';
        }
        $neuesThema = $_POST['neuesThema'];
        $besetzung = $_POST['besetzung'];
        $neueBesetzung = $_POST['neueBesetzung'];
        $komponist = $_POST['komponist'];
        $bearbeitung = $_POST['bearbeitung'];
        $texter = $_POST['texter'];
        $verlag = $_POST['verlag'];
        $neuerVerlag = $_POST['neuerVerlag'];
        $werknummer = $_POST['werknummer'];
        $status = $_POST['status'];
        

        if ($verlag == 'nd')
        {
            if ($neuerVerlag != "")
            {
                $sql = "SELECT * FROM noa_verlag where ve_name ='".$neuerVerlag."'";
                $result = $conn->query($sql);
    
                if ($result->num_rows > 0) {
                    //Jede Reie der Datenbank anzeigen
                    while($row = $result->fetch_assoc()) {
                        $verlag = $row["ve_id"];
                    }
                }
                else
                {
                    $sql = "INSERT INTO noa_verlag (ve_name) VALUES ('$neuerVerlag')";

                    if ($conn->query($sql) === TRUE) 
                    {
                        $sql = "SELECT * FROM noa_verlag where ve_name ='".$neuerVerlag."'";
                        $result = $conn->query($sql);
    
                        if ($result->num_rows > 0) {
                            //Jede Reie der Datenbank anzeigen
                            while($row = $result->fetch_assoc()) {
                                $verlag = $row["ve_id"];
                            }
                        }
                    } else 
                    {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }
        }

        if ($neueBesetzung != "")
        {
            $sql = "SELECT * FROM noa_besetzung where be_name ='".$neueBesetzung."'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                //Jede Reie der Datenbank anzeigen
                while($row = $result->fetch_assoc()) {
                    $besetzung = $row["be_id"];
                }
            }
            else
            {
                $sql = "INSERT INTO noa_besetzung (be_name) VALUES ('$neueBesetzung')";

                if ($conn->query($sql) === TRUE) 
                {
                    $sql = "SELECT * FROM noa_besetzung where be_name ='".$neueBesetzung."'";
                    $result = $conn->query($sql);
    
                    if ($result->num_rows > 0) {
                        //Jede Reie der Datenbank anzeigen
                        while($row = $result->fetch_assoc()) {
                            $besetzung = $row["be_id"];
                        }
                    }
                } else 
                {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }            
        }

        if ($neuesThema != "")
        {
            $sql = "SELECT * FROM noa_thema where th_name ='".$neuesThema."'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                //Jede Reie der Datenbank anzeigen
                while($row = $result->fetch_assoc()) {
                    $thema[] = $row["th_id"];
                }
            }
            else
            {
                $sql = "INSERT INTO noa_thema (th_name) VALUES ('$neuesThema')";

                if ($conn->query($sql) === TRUE) 
                {
                    $sql = "SELECT * FROM noa_thema where th_name ='".$neuesThema."'";
                    $result = $conn->query($sql);
    
                    if ($result->num_rows > 0) {
                        //Jede Reie der Datenbank anzeigen
                        while($row = $result->fetch_assoc()) {
                            $thema[] = $row["th_id"];
                        }
                    }
                } else 
                {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }            
        }

        if ($neueZiK != "")
        {
            $sql = "SELECT * FROM noa_z_i_kirchenjahr where zik_name ='".$neueZiK."'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                //Jede Reie der Datenbank anzeigen
                while($row = $result->fetch_assoc()) {
                    $z_i_kirchenjahr[] = $row["zik_id"];
                }
            }
            else
            {
                $sql = "INSERT INTO noa_z_i_kirchenjahr (zik_name) VALUES ('$neueZiK')";

                if ($conn->query($sql) === TRUE) 
                {
                    $sql = "SELECT * FROM noa_z_i_kirchenjahr where zik_name ='".$neueZiK."'";
                    $result = $conn->query($sql);
    
                    if ($result->num_rows > 0) {
                        //Jede Reie der Datenbank anzeigen
                        while($row = $result->fetch_assoc()) {
                            $z_i_kirchenjahr[] = $row["zik_id"];
                        }
                    }
                } else 
                {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }            
        }

        $sql = "SELECT MAX(`nb_id`) FROM `noa_notenblatt`";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $idA = $result->fetch_assoc();
            $id = $idA["MAX(`nb_id`)"];
            $id++;
        }

        $sql = "INSERT INTO `noa_notenblatt`(`nb_id`,`nb_katalognummer`, `nb_titel`, `nb_untertitel`, `nb_katigorie`, `nb_besetzung`, `nb_komponist`, `nb_bearbeitung`, `nb_texter`, `nb_werknummer`, `nb_status`, `nb_zugehoerigkeit`) VALUES ($id,'$katalognummer','$titel','$untertitel',$kategorie,$besetzung,'$komponist','$bearbeitung','$texter','$werknummer','$status','$zugehoerigkeit')";

        if ($conn->query($sql) === TRUE) {

            if($verlag != "nd")
            {
                $sql = "UPDATE `noa_notenblatt` SET `nb_verlag`= $verlag WHERE `nb_id`=$id";
                if ($conn->query($sql) === TRUE) {

                }else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }

            foreach($thema as $value)
            {
                if ($value != 'nd')
                {
                    $sql = "INSERT INTO `noa_nb_th`(`nb_th_thema`, `nb_th_notenblatt`) VALUES ($value,$id)";
                    if ($conn->query($sql) === TRUE) {

                    }else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }

            foreach($z_i_kirchenjahr as $value)
            {
                if($value != 'nd')
                {
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
?>