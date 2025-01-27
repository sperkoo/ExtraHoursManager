<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['searchGroupe'])) {
    $id_group = $_POST['CherchIdGroupe'];

    $sql = "SELECT
        g.id_group,
        p.nom AS prof_nom,
        p.prenom AS prof_prenom,
        m.nom_matier AS matier_nom,
        s.id_salle,
        dg.jour,
        dg.heure,
        g.niv_scolaire,
        COUNT(a.id_etud) AS nombre_etudiants
    FROM groupe g
    JOIN date_grp dg ON g.id_date = dg.id_date
    JOIN prof p ON g.id_prof = p.id_prof
    JOIN matier m ON p.id_matier = m.id_matier
    JOIN salle s ON g.id_salle = s.id_salle
    LEFT JOIN appartenir a ON g.id_group = a.id_group";
    if (!empty($id_group)) {
        $sql .= " WHERE g.id_group='$id_group'
        GROUP BY g.id_group, p.nom, p.prenom, m.nom_matier, s.id_salle, dg.jour, dg.heure;";
    }
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
?>
            <tr>
                <td><?php echo $row['id_group']; ?></td>
                <td><?php echo $row['nombre_etudiants']; ?></td>
                <td><?php echo $row['jour'] . " / " . $row['heure']; ?></td>
                <td><?php echo $row['id_salle']; ?></td>
                <td><?php echo $row['prof_nom'] . ' ' . $row['prof_prenom']; ?></td>
                <td><?php echo $row['matier_nom']; ?></td>
                <td><?php echo $row['niv_scolaire']; ?></td>
                <td>
                    <form action="AjoutEtuGroupe.php" method="post">
                        <input type="hidden" name="Ajout_id" value="<?php echo $row['id_group']; ?>">
                        <?php if ($row['nombre_etudiants'] >= 8) { ?>
                            <button type="button" class="btn btn-info" disabled> Groupe Plein</button>
                        <?php } else { ?>
                            <button type="submit" name="Ajout_btn" class="btn btn-info"> Ajouter Etudiant</button>
                        <?php } ?>
                    </form>
                </td>
                
                <td>                                                   
                    <form action="EditGroupe.php" method="post">
                        <input type="hidden" name="edit_id" value="<?php echo $row['id_group']; ?>">
                        <button type="submit" name="edit_btn" class="btn btn-success"> Modifier</button>
                    </form>
                </td>
                <td>
                    <form action="SuppGroupe.php" method="post">
                        <input type="hidden" name="delete_idGroupe" value="<?php echo $row['id_group']; ?>">
                        <button type="submit" name="delete_btnGroupe" class="btn btn-danger"> Supprimer</button>
                    </form>
                </td>
            </tr>
    <?php
        }
    } else {
        echo "No Record Found";
    }

}else {
        



        // If the form hasn't been submitted or search fields are empty, display all records
        $sql = "SELECT
            g.id_group,
            p.nom AS prof_nom,
            p.prenom AS prof_prenom,
            m.nom_matier AS matier_nom,
            s.id_salle,
            dg.jour,
            dg.heure,
            g.niv_scolaire,
            COUNT(a.id_etud) AS nombre_etudiants
        FROM groupe g
        JOIN date_grp dg ON g.id_date = dg.id_date
        JOIN prof p ON g.id_prof = p.id_prof
        JOIN matier m ON p.id_matier = m.id_matier
        JOIN salle s ON g.id_salle = s.id_salle
        LEFT JOIN appartenir a ON g.id_group = a.id_group
        GROUP BY g.id_group, p.nom, p.prenom, m.nom_matier, s.id_salle, dg.jour, dg.heure;";
        $result = mysqli_query($conn, $sql);

        

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php  echo $row['id_group']; ?></td>
                    <td><?php  echo $row['nombre_etudiants']; ?></td>
                    <td><?php echo $row['jour'] . " / " . $row['heure']; ?></td>
                    <td><?php  echo $row['id_salle']; ?></td>
                    <td><?php echo $row['prof_nom'] . ' ' . $row['prof_prenom']; ?></td>
                    <td><?php  echo $row['matier_nom']; ?></td>
                    <td><?php echo $row['niv_scolaire']; ?></td>
                    <td>
                        <form action="AjoutEtuGroupe.php" method="post">
                        <input type="hidden" name="Ajout_id" value="<?php echo $row['id_group']; ?>">
                        <?php if ($row['nombre_etudiants'] >= 8) { ?>
                            <button type="submit" name="Ajout_btn" class="btn btn-info" disabled> Groupe Plein</button>
                        <?php } else { ?>
                            <button type="submit" name="Ajout_btn" class="btn btn-info"> Ajouter Etudiant</button>
                        <?php } ?>
                        </form>
                    </td>
                    
                    <td>                                                   
                        <form action="EditGroupe.php" method="post">
                            <input type="hidden" name="edit_id" value="<?php echo $row['id_group']; ?>">
                            <button type="submit" name="edit_btn" class="btn btn-success"> Modifier</button>
                        </form>
                    </td>
                    <td>
                        <form action="SuppGroupe.php" method="post">
                            <input type="hidden" name="delete_idGroupe" value="<?php echo $row['id_group']; ?>">
                            <button type="submit" name="delete_btnGroupe" class="btn btn-danger"> Supprimer</button>
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
