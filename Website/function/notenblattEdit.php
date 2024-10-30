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
            $nb_thema = $_POST['thema'];
            $nb_besetzung = $_POST['besetzung'];
            $nb_komponist = $_POST['komponist'];
            $nb_bearbeitung = $_POST['bearbeitung'];
            $nb_texter = $_POST['texter'];
            $nb_verlag = $_POST['verlag'];
            $nb_werknummer = $_POST['werknummer'];
            if($nb_verlag == "nd"){
                $nb_verlag = "null";
            }
            $nb_status = $_POST['status'];
            
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
    
    header('Location: ../home.php');
?>

<br/>
<br/>
<br/>
<a href="../home.php"> Home </a>