<?php
    if(isset($_GET['edit'])) {
        //Datenbankverbindung aufbauen
        include 'databaseCon.php';

        if($_GET['edit'] == '1')
        {
            $nb_id = $_POST['ID'];
            $nb_kategorie = $_POST['kategorie'];
            if (strlen($_POST['katalognummer']) == 1){
                $nb_katalognummer = "0" . "0" . $_POST['katalognummer'];
            }
            elseif(strlen($_POST['katalognummer']) == 2){
                $nb_katalognummer = "0" . $_POST['katalognummer'];
            }
            else{
                $nb_katalognummer = $_POST['katalognummer'];
            }
            $nb_titel = $_POST['titel'];
            $nb_untertitel = $_POST['untertitel'];
            $nb_zugehoerigkeit = $_POST['zugehoerigkeit'];
            $nb_z_i_kirchenjahr = $_POST['z_i_kirchenjahr'];
            $neueZiK = $_POST['neueZiK'];
            $nb_thema = $_POST['thema'];
            $neuesThema = $_POST['neuesThema'];
            $nb_besetzung = $_POST['besetzung'];
            $neueBesetzung = $_POST['neueBesetzung'];
            $nb_komponist = $_POST['komponist'];
            $nb_bearbeitung = $_POST['bearbeitung'];
            $nb_texter = $_POST['texter'];
            $nb_verlag = $_POST['verlag'];
            $neuerVerlag = $_POST['neuerVerlag'];
            $nb_werknummer = $_POST['werknummer'];
            $nb_status = $_POST['status'];
            


            if ($nb_verlag == 'nd')
            {
                $nb_verlag = "null";
            
                if ($neuerVerlag != "")
                {
                    $sql = "SELECT * FROM noa_verlag where ve_name ='".$neuerVerlag."'";
                    $result = $conn->query($sql);
        
                    if ($result->num_rows > 0) {
                        //Jede Reie der Datenbank anzeigen
                        while($row = $result->fetch_assoc()) {
                            $nb_verlag = $row["ve_id"];
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
                                    $nb_verlag = $row["ve_id"];
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
                        $nb_besetzung = $row["be_id"];
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
                                $nb_besetzung = $row["be_id"];
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
                        $nb_thema[] = $row["th_id"];
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
                                $nb_thema[] = $row["th_id"];
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
                        $nb_z_i_kirchenjahr[] = $row["zik_id"];
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
                                $nb_z_i_kirchenjahr[] = $row["zik_id"];
                            }
                        }
                    } else 
                    {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }            
            }



            $sql = "UPDATE `noa_notenblatt` 
                    SET `nb_katalognummer`='$nb_katalognummer', `nb_titel`='$nb_titel', `nb_untertitel`='$nb_untertitel', `nb_zugehoerigkeit`='$nb_zugehoerigkeit', `nb_katigorie`=$nb_kategorie, `nb_besetzung`=$nb_besetzung, `nb_komponist`='$nb_komponist', `nb_bearbeitung`='$nb_bearbeitung', `nb_texter`='$nb_texter', `nb_verlag`= $nb_verlag, `nb_werknummer`='$nb_werknummer', `nb_status`='$nb_status' 
                    WHERE  nb_id = $nb_id ";
            echo "$sql <br/>";

            if ($conn->query($sql) === TRUE) 
            {                
                $sql = "DELETE FROM noa_nb_th WHERE nb_th_notenblatt = $nb_id";
                echo "$sql <br/>";

                if ($conn->query($sql) === TRUE) 
                {
                    $sql = "DELETE FROM noa_nb_zik WHERE nb_zik_notenblatt = $nb_id ";
                    echo "$sql <br/>";

                    if ($conn->query($sql) === TRUE) 
                    {
                        foreach($nb_z_i_kirchenjahr as $value)
                        {
                            $sql = "INSERT INTO `noa_nb_zik`(`nb_zik_z_i_kirchenjahr`, `nb_zik_notenblatt`) VALUES ($value,$nb_id) ";
                            echo "$sql <br/>";
                            
                            if ($conn->query($sql) === TRUE) {
                                //echo "Record updated successfully";
                            } else {
                                echo "Error: " . $sql . "<br>" . $conn->error;
                            }
                        }
                        foreach($nb_thema as $value)
                        {
                            $sql = "INSERT INTO `noa_nb_th`(`nb_th_thema`, `nb_th_notenblatt`) VALUES ($value,$nb_id) ";
                            echo "$sql <br/>";

                            if ($conn->query($sql) === TRUE) {
                                //echo "Record updated successfully";
                            } else {
                                echo "Error: " . $sql . "<br>" . $conn->error;
                            }
                        }
                    } 
                    else 
                    {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                } 
                else 
                {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } 
            else 
            {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        $conn->close();
    }
    
    header('Location: ../home_test.php');
?>

<br/>
<br/>
<br/>
<a href="../home.php"> Home </a>