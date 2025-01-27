<?php
    include "connect.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['searchEtudiant'])) {
        $PrenomEtudiant = $_POST['PrenomEtudiant'];
        $nomEtudiant = $_POST['nomEtudiant'];

        $sql = "SELECT e.id_etud, e.nom, e.prenom, e.num_tele, e.deja_abs, a.id_group, a.nbr_sc_payee
        FROM etudiant e
        LEFT JOIN appartenir a ON e.id_etud = a.id_etud";

        if (!empty($PrenomEtudiant) && !empty($nomEtudiant)) {
            $sql .= " WHERE e.nom='$nomEtudiant' AND e.prenom='$PrenomEtudiant'";
        } elseif (!empty($nomEtudiant)) {
            $sql .= " WHERE nom='$nomEtudiant'";
        } elseif (!empty($PrenomEtudiant)) {
            $sql .= " WHERE prenom='$PrenomEtudiant'";
        }

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row["id_etud"]."</td>";
                echo "<td>".$row["prenom"]."</td>";
                echo "<td>".$row["nom"]."</td>";
                echo "<td>".$row["num_tele"]."</td>";
                echo "<td>";
                if ($row["deja_abs"] == 0) {
                    echo "Non";
                } else {
                    echo "Oui";
                }
                echo "</td>";
                echo "<td>".$row["nbr_sc_payee"]."</td>";
                echo "<td>".$row["id_group"]."</td>";
                ?>
                <td>
                <div class="row mb-4">
                    <div class="col-lg-12">
                    <form action="EditEtudiant.php" method="post">
                        <input type="hidden" name="edit_idEtudiant" value="<?php echo $row['id_etud']; ?>">
                        <button type="submit" name="edit_btnEtudiant" class="btn btn-success"> Modifier</button>
                    </form>
                </td>
                <td>
                    <form action="EditEtudiant.php" method="post">
                        <input type="hidden" name="delete_idEtudiant" value="<?php echo $row['id_etud']; ?>">
                        <button type="submit" name="delete_btnEtudiant" class="btn btn-danger"> Supprimer</button>
                    </form>
                </td>
                <?php
                echo "</tr>";
                }
        } else {
                echo "<tr><td colspan='7'>No records found.</td></tr>";
            }
    }else {
        



        // If the form hasn't been submitted or search fields are empty, display all records
        $sql = "SELECT e.id_etud, e.nom, e.prenom, e.num_tele, e.deja_abs, a.id_group, a.nbr_sc_payee
        FROM etudiant e
        LEFT JOIN appartenir a ON e.id_etud = a.id_etud";
        $result = mysqli_query($conn, $sql);

        

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row["id_etud"]."</td>";
                echo "<td>".$row["prenom"]."</td>";
                echo "<td>".$row["nom"]."</td>";
                echo "<td>".$row["num_tele"]."</td>";
                echo "<td>";
                if ($row["deja_abs"] == 0) {
                    echo "Non";
                } else {
                    echo "Oui";
                }
                echo "</td>";
                echo "<td>".$row["nbr_sc_payee"]."</td>";
                echo "<td>".$row["id_group"]."</td>";
                ?>
                <td>
                <div class="row mb-4">
                    <div class="col-lg-12">
                    <form action="EditEtudiant.php" method="post">
                        <input type="hidden" name="edit_idEtudiant" value="<?php echo $row['id_etud']; ?>">
                        <button type="submit" name="edit_btnEtudiant" class="btn btn-success"> Modifier</button>
                    </form>
                </td>
                <td>
                    <form action="EditEtudiant.php" method="post">
                        <input type="hidden" name="delete_idEtudiant" value="<?php echo $row['id_etud']; ?>">
                        <button type="submit" name="delete_btnEtudiant" class="btn btn-danger"> Supprimer</button>
                    </form>
                </td>

                <?php
                echo "</tr>";
                }
        } else {
            echo "<p>No records found.</p>";
        }
    }

    

    // Close database connection
    mysqli_close($conn);
?>
