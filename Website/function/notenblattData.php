<?php

    $searchBar = $_GET['searchBar'];
    $kategorie = $_GET['kategorie'];
    $z_i_kirchenjahr = $_GET['z_i_kirchenjahr'];
    $thema = $_GET['thema'];
    $besetzung = $_GET['besetzung'];

    include 'databaseCon.php';


    $sql = "SELECT `nb_id`, `nb_katalognummer`, `nb_titel`, `nb_untertitel`, `nb_katigorie`,`nb_besetzung`, `nb_komponist`, `nb_bearbeitung`, `nb_texter`, `nb_werknummer`, `nb_status`, `nb_zugehoerigkeit`, ka_name, ka_prefix, ve_name, be_name, nb_verlag
        FROM `noa_notenblatt` 
        LEFT JOIN noa_katigorie 
        ON nb_katigorie = ka_id 
        LEFT JOIN noa_verlag 
        ON ve_id = nb_verlag 
        LEFT JOIN noa_besetzung 
        ON be_id = nb_besetzung";
                    
          
            
    $sql .= " WHERE (nb_titel LIKE '%" . $searchBar . "%' 
        OR nb_untertitel LIKE '%" . $searchBar . "%' 
        OR nb_zugehoerigkeit LIKE '%" . $searchBar . "%'
        OR nb_komponist LIKE '%" . $searchBar . "%')";
                    
    if($besetzung != "nd"){
        $sql .= " AND (nb_besetzung = " . $besetzung . ")";
    }
    if($kategorie != "nd"){
        $sql .= " AND (nb_katigorie = " . $kategorie . ")";
    }
    if($z_i_kirchenjahr != "nd"){
        $sql .= " AND (nb_id in ( SELECT z.nb_zik_notenblatt FROM noa_nb_zik AS z WHERE z.nb_zik_z_i_kirchenjahr = " . $z_i_kirchenjahr . "))";
    }
    if($thema != "nd"){
        $sql .= " AND (nb_id in ( SELECT th.nb_th_notenblatt FROM noa_nb_th AS th WHERE th.nb_th_thema = " . $thema . "))";
    }
   
                    
    $sql .= " ORDER BY nb_katigorie, nb_katalognummer";
                    
                    
    $result = $conn->query($sql);


    echo "<table class='tableOutput' >";
    echo "<tr>
        <th></th>
        <th>Titel</th>
        <th>Untertitel</th>
        <th>Zugehoerigkeit</th>
        <th>Katigorie</th>
        <th>Besetzung</th>
        <th>Thema</th>
        <th>Zeit im Kirchenjahr</th>
        <th></th>
        <th></th>
    </tr>";

    if ($result->num_rows > 0) {
        //Jede Reie der Datenbank anzeigen
        while($row = $result->fetch_assoc()) {
            if($row["nb_status"] == "akti" || $row["nb_status"] == "arch"){
            
                $sqlZik = "SELECT z.zik_name, z.zik_id 
                    FROM noa_nb_zik AS nz 
                    JOIN noa_z_i_kirchenjahr AS z 
                    ON nz.nb_zik_z_i_kirchenjahr = z.zik_id 
                     WHERE nz.nb_zik_notenblatt = " . $row["nb_id"];
                $resultZik = $conn->query($sqlZik);
                $zik = "";
                $zikSel = "[";
                if ($result->num_rows > 0) {
                    $i = 0;
                    while($rowZik = $resultZik->fetch_assoc()) {
                    $zik .= $rowZik["zik_name"] . " ";
                    $zikSel .= "'" . $rowZik["zik_id"] . "',";
                }
                $zikSel .= "]";
            }
                                
            $sqlTh = "SELECT t.th_name, t.th_id 
                FROM noa_nb_th AS nt 
                JOIN noa_thema AS t 
                ON nt.nb_th_thema = t.th_id
                WHERE nt.nb_th_notenblatt = " . $row["nb_id"];
            $resultTh = $conn->query($sqlTh);
            $the = "";
            $theSel = "[";
            if ($result->num_rows > 0) {
                $i = 0;
                while($rowTh = $resultTh->fetch_assoc()) {
                    $the .= $rowTh["th_name"] . " ";
                    $theSel .= "'" .$rowTh["th_id"]. "',";
                }
                $theSel .= "]";
            }

            if($row["nb_verlag"] == ""){
                $verlag = "nd";
            } else{
                $verlag = $row["nb_verlag"];
            }
                                
            echo "<tr>
                <td>" . $row["ka_prefix"] . $row["nb_katalognummer"]. "</td>
                <td>" . $row["nb_titel"]. "</td>
                    <td>" . $row["nb_untertitel"]. "</td>
                    <td>" . $row["nb_zugehoerigkeit"]. "</td>
                    <td>" . $row["ka_name"]. "</td>
                    <td>" . $row["be_name"]. "</td>
                    <td>" . $the . "</td>
                    <td>" . $zik . "</td>
                    <td onclick=\"SetEdit('".$row["nb_id"]."', '".$row["nb_katalognummer"]."', '".$row["nb_titel"]."', '".$row["nb_untertitel"]."', '".$row["nb_zugehoerigkeit"]."', '".$row["nb_komponist"]."', '".$row["nb_bearbeitung"]."', '".$row["nb_texter"]."', '".$row["nb_werknummer"]."', ".$row["nb_katigorie"].", ".$row["nb_besetzung"].", ".$zikSel.", ".$theSel.", '".$verlag."', '".$row["nb_status"]."');\">
                        <img src='img/edit.svg'>
                    </td>
                    <td onclick=\"ShowMore('more".$row["nb_id"]."');\">
                        <img src='img/info.svg'>
                    </td>
                </tr>
                <tr style='display: none' id='more".$row["nb_id"]."'>
                    <td colspan='9'> <div>Komponist: " . $row["nb_komponist"]. "</div>
                        <div>Bearbeitung: " . $row["nb_bearbeitung"]. "</div>
                        <div>Texter: " . $row["nb_texter"]. "</div>
                        <div>Verlag: " . $row["ve_name"]. "</div>
                        <div>Werknummer: " . $row["nb_werknummer"]. "</div>
                    </td>
                    <td onclick=\"HideMore('more".$row["nb_id"]."');\">
                        <img src='img/cancel.svg'>
                    </td>
                </tr>";
            }
        }
    } else {
        echo "Keine Einträge";
    }

    echo "</table>";

    $conn->close();

?>