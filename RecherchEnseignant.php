<?php
    include "connect.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['SearchEnseignant'])) {
        $PrenomEnseignant = $_POST['PrenomEnseignant'];
        $nomEnseignant = $_POST['nomEnseignant'];
        $Matiere = $_POST['selectMatiere'];
        $Formation = $_POST['selectFormation'];



        $sql = "SELECT p.id_prof, p.nom, p.prenom, p.num_tele, m.nom_matier, f.nom_formation
        FROM prof p
        LEFT JOIN matier m ON p.id_matier = m.id_matier
        LEFT JOIN formation f ON m.id_formation = f.id_formation";

        if (!empty($PrenomEnseignant) && !empty($nomEnseignant) && !empty($Matiere) && !empty($Formation)) {
            $sql .= " WHERE p.nom='$nomEnseignant' AND p.prenom='$PrenomEnseignant' AND m.nom_matier='$Matiere' AND f.nom_formation='$Formation'"; 
        } elseif (!empty($PrenomEnseignant) && !empty($nomEnseignant) && !empty($Matiere)) {
            $sql .= " WHERE p.nom='$nomEnseignant' AND p.prenom='$PrenomEnseignant' AND m.nom_matier='$Matiere'";
        } elseif (!empty($PrenomEnseignant) && !empty($nomEnseignant) && !empty($Formation)) {
            $sql .= " WHERE p.nom='$nomEnseignant' AND p.prenom='$PrenomEnseignant' AND f.nom_formation='$Formation'";
        } elseif (!empty($PrenomEnseignant) && !empty($Matiere) && !empty($Formation)) {
            $sql .= " WHERE p.prenom='$PrenomEnseignant' AND m.nom_matier='$Matiere' AND f.nom_formation='$Formation'";
        } elseif (!empty($nomEnseignant) && !empty($Matiere) && !empty($Formation)) {
            $sql .= " WHERE p.nom='$nomEnseignant' AND m.nom_matier='$Matiere' AND f.nom_formation='$Formation'";
        } elseif (!empty($PrenomEnseignant) && !empty($nomEnseignant)) {
            $sql .= " WHERE p.nom='$nomEnseignant' AND p.prenom='$PrenomEnseignant'";
        } elseif (!empty($PrenomEnseignant) && !empty($Matiere)) {
            $sql .= " WHERE p.prenom='$PrenomEnseignant' AND m.nom_matier='$Matiere'";
        } elseif (!empty($PrenomEnseignant) && !empty($Formation)) {
            $sql .= " WHERE p.prenom='$PrenomEnseignant' AND f.nom_formation='$Formation'";
        } elseif (!empty($nomEnseignant) && !empty($Matiere)) {
            $sql .= " WHERE p.nom='$nomEnseignant' AND m.nom_matier='$Matiere'";
        } elseif (!empty($nomEnseignant) && !empty($Formation)) {
            $sql .= " WHERE p.nom='$nomEnseignant' AND f.nom_formation='$Formation'";
        } elseif (!empty($Matiere) && !empty($Formation)) {
            $sql .= " WHERE m.nom_matier='$Matiere' AND f.nom_formation='$Formation'";
        } elseif (!empty($PrenomEnseignant)) {
            $sql .= " WHERE p.prenom='$PrenomEnseignant'";
        } elseif (!empty($nomEnseignant)) {
            $sql .= " WHERE p.nom='$nomEnseignant'";
        } elseif (!empty($Matiere)) {
            $sql .= " WHERE m.nom_matier='$Matiere'";
        } elseif (!empty($Formation)) {
            $sql .= " WHERE f.nom_formation='$Formation'";
        }


        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php  echo $row['id_prof']; ?></td>
                    <td><?php  echo $row['prenom']; ?></td>
                    <td><?php  echo $row['nom']; ?></td>
                    <td><?php  echo $row['num_tele']; ?></td>
                    <td><?php  echo $row['nom_matier']; ?></td>
                    <td>
                    <div class="row mb-4">
                        <div class="col-lg-12">
                        <form action="EditEnseignant.php" method="post">
                            <input type="hidden" name="edit_id" value="<?php echo $row['id_prof']; ?>">
                            <button type="submit" name="edit_btn" class="btn btn-success"> Modifier</button>
                        </form>
                    </td>
                    <td>
                        <form action="EditEnseignant.php" method="post">
                            <input type="hidden" name="delete_id" value="<?php echo $row['id_prof']; ?>">
                            <button type="submit" name="delete_btn" class="btn btn-danger"> Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php
                } 
            }
            else {
                echo "No Record Found";
            }
     
    }else {
        



        // If the form hasn't been submitted or search fields are empty, display all records
        $sql = "SELECT p.id_prof, p.nom, p.prenom, p.num_tele, m.nom_matier, f.nom_formation
        FROM prof p
        LEFT JOIN matier m ON p.id_matier = m.id_matier
        LEFT JOIN formation f ON m.id_formation = f.id_formation;";
        $result = mysqli_query($conn, $sql);

        

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php  echo $row['id_prof']; ?></td>
                    <td><?php  echo $row['prenom']; ?></td>
                    <td><?php  echo $row['nom']; ?></td>
                    <td><?php  echo $row['num_tele']; ?></td>
                    <td><?php  echo $row['nom_matier']; ?></td>
                    <td>
                    <div class="row mb-4">
                        <div class="col-lg-12">
                        <form action="EditEnseignant.php" method="post">
                            <input type="hidden" name="edit_id" value="<?php echo $row['id_prof']; ?>">
                            <button type="submit" name="edit_btn" class="btn btn-success"> Modifier</button>
                        </form>
                    </td>
                    <td>
                        <form action="EditEnseignant.php" method="post">
                            <input type="hidden" name="delete_id" value="<?php echo $row['id_prof']; ?>">
                            <button type="submit" name="delete_btn" class="btn btn-danger"> Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php
                } 
            }
            else {
                echo "No Record Found";
            }
    }

    

    // Close database connection
    mysqli_close($conn);
?>
