<?php
    include "connect.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['CherchPresence'])) {
        $PrenomEtudiant = $_POST['PrenomEtudiant'];
        $nomEtudiant = $_POST['nomEtudiant'];
        $date_sc = $_POST['DateSceance'];
        $id_group = $_POST['IdGroupe'];

        $sql = "SELECT p.id_group,p.id_etud,e.nom,e.prenom,p.date_sc,p.abs_or_not,m.nom_matier,f.nom_formation
        FROM presence p
        JOIN etudiant e ON p.id_etud = e.id_etud
        JOIN groupe g ON p.id_group = g.id_group
        JOIN prof pr ON g.id_prof = pr.id_prof
        JOIN matier m ON pr.id_matier = m.id_matier
        JOIN formation f ON m.id_formation = f.id_formation";


        if (!empty($PrenomEtudiant) && !empty($nomEtudiant) && !empty($date_sc) && !empty($id_group)) {
            $sql .= " WHERE e.nom='$nomEtudiant' AND e.prenom='$PrenomEtudiant' AND p.date_sc='$date_sc' AND p.id_group='$id_group'"; 
        } elseif (!empty($PrenomEtudiant) && !empty($nomEtudiant) && !empty($date_sc)) {
            $sql .= " WHERE e.nom='$nomEtudiant' AND e.prenom='$PrenomEtudiant' AND p.date_sc='$date_sc'";
        } elseif (!empty($PrenomEtudiant) && !empty($nomEtudiant) && !empty($id_group)) {
            $sql .= " WHERE e.nom='$nomEtudiant' AND e.prenom='$PrenomEtudiant' AND p.id_group='$id_group'";
        } elseif (!empty($PrenomEtudiant) && !empty($date_sc) && !empty($id_group)) {
            $sql .= " WHERE e.prenom='$PrenomEtudiant' AND p.date_sc='$date_sc' AND p.id_group='$id_group'";
        } elseif (!empty($nomEtudiant) && !empty($date_sc) && !empty($id_group)) {
            $sql .= " WHERE e.nom='$nomEtudiant' AND p.date_sc='$date_sc' AND p.id_group='$id_group'";
        } elseif (!empty($PrenomEtudiant) && !empty($nomEtudiant)) {
            $sql .= " WHERE e.nom='$nomEtudiant' AND e.prenom='$PrenomEtudiant'";
        } elseif (!empty($PrenomEtudiant) && !empty($date_sc)) {
            $sql .= " WHERE e.prenom='$PrenomEtudiant' AND p.date_sc='$date_sc'";
        } elseif (!empty($PrenomEtudiant) && !empty($id_group)) {
            $sql .= " WHERE e.prenom='$PrenomEtudiant' AND p.id_group='$id_group'";
        } elseif (!empty($nomEtudiant) && !empty($date_sc)) {
            $sql .= " WHERE e.nom='$nomEtudiant' AND p.date_sc='$date_sc'";
        } elseif (!empty($nomEtudiant) && !empty($id_group)) {
            $sql .= " WHERE e.nom='$nomEtudiant' AND p.id_group='$id_group'";
        } elseif (!empty($date_sc) && !empty($id_group)) {
            $sql .= " WHERE p.date_sc='$date_sc' AND p.id_group='$id_group'";
        } elseif (!empty($PrenomEtudiant)) {
            $sql .= " WHERE e.prenom='$PrenomEtudiant'";
        } elseif (!empty($nomEtudiant)) {
            $sql .= " WHERE e.nom='$nomEtudiant'";
        } elseif (!empty($date_sc)) {
            $sql .= " WHERE p.date_sc='$date_sc'";
        } elseif (!empty($id_group)) {
            $sql .= " WHERE p.id_group='$id_group'";
        }

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php  echo $row['id_group']; ?></td>
                    <td><?php  echo $row['id_etud']; ?></td>
                    <td><?php  echo $row['nom'] . ' ' . $row['prenom']; ?></td>
                    <td><?php  echo $row['date_sc']; ?></td>
                    <td><?php if( $row['abs_or_not'] ==0){echo "Present";}else{echo "Abscent";} ?></td>
                    <td><?php  echo $row['nom_matier']; ?></td>
                    <td><?php  echo $row['nom_formation']; ?></td>
                </tr>
            <?php
                }
        } else {
                echo "<tr><td colspan='7'>No records found.</td></tr>";
            }
    }else {
        



        // If the form hasn't been submitted or search fields are empty, display all records
        $sql = "SELECT p.id_group,p.id_etud,e.nom,e.prenom,p.date_sc,p.abs_or_not,m.nom_matier,f.nom_formation
        FROM presence p
        JOIN etudiant e ON p.id_etud = e.id_etud
        JOIN groupe g ON p.id_group = g.id_group
        JOIN prof pr ON g.id_prof = pr.id_prof
        JOIN matier m ON pr.id_matier = m.id_matier
        JOIN formation f ON m.id_formation = f.id_formation;";
        $result = mysqli_query($conn, $sql);

        

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php  echo $row['id_group']; ?></td>
                    <td><?php  echo $row['id_etud']; ?></td>
                    <td><?php  echo $row['nom'] . ' ' . $row['prenom']; ?></td>
                    <td><?php  echo $row['date_sc']; ?></td>
                    <td><?php if( $row['abs_or_not'] ==0){echo "Present";}else{echo "Abscent";} ?></td>
                    <td><?php  echo $row['nom_matier']; ?></td>
                    <td><?php  echo $row['nom_formation']; ?></td>
                </tr>
            <?php
                }
        } else {
            echo "<p>No records found.</p>";
        }
    }

    

    // Close database connection
    mysqli_close($conn);
?>
