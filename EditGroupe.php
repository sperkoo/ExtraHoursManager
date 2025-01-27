<?php
ob_start();
session_start();
include "header.php";
include "navbar.php";
?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"> Modifier Groupe </h6>
        </div>
        <div class="card-body">
            <?php
            include "connect.php";

            // Check if the form is submitted
            if (isset($_POST['updatebtnGroupe'])) {
                $id_group = $_POST['editidGroupe'];
                $id_prof = $_POST['editprof'];
                $id_salle = $_POST['editsalle'];
                $id_date = $_POST['editDate'];
                $niv_scolaire = $_POST['editnivScolaire'];

                // Process the form submission
                $update_query = "UPDATE groupe SET id_prof='$id_prof', id_salle='$id_salle', id_date='$id_date', niv_scolaire='$niv_scolaire' WHERE id_group='$id_group'";
                $update_query_run = mysqli_query($conn, $update_query);

                if ($update_query_run) {
                    $_SESSION['status'] = "Your Data is Updated";
                    $_SESSION['status_code'] = "success";
                    header('Location: Groupe.php');
                    exit();
                } else {
                    $_SESSION['status'] = "Your Data is NOT Updated";
                    $_SESSION['status_code'] = "error";
                    header('Location: Groupe.php');
                    exit();
                }
            }
            // Display the form
            else {
                // Fetch necessary data
                $id_group = $_POST['edit_id'];
                $query = "SELECT g.id_group, p.id_prof, dg.id_date, p.nom AS prof_nom, p.prenom AS prof_prenom, m.nom_matier AS matier_nom, s.id_salle, dg.jour, dg.heure, g.niv_scolaire, COUNT(a.id_etud) AS nombre_etudiants
                        FROM groupe g
                        JOIN date_grp dg ON g.id_date = dg.id_date
                        JOIN prof p ON g.id_prof = p.id_prof
                        JOIN matier m ON p.id_matier = m.id_matier
                        JOIN salle s ON g.id_salle = s.id_salle
                        LEFT JOIN appartenir a ON g.id_group = a.id_group
                        WHERE g.id_group = '$id_group'
                        GROUP BY g.id_group, p.nom, p.prenom, m.nom_matier, s.id_salle, dg.jour, dg.heure, g.niv_scolaire";

                $query_run = mysqli_query($conn, $query);

                if ($query_run) {
                    $row1 = mysqli_fetch_assoc($query_run);
                    ?>
                    <!-- Display the form -->
                    <form action="EditGroupe.php" method="POST">
                        <div class="form-group">
                            <label>Numero Groupe</label>
                            <input type="number" name="editidGroupe" value="<?php echo $row1['id_group'] ?>" class="form-control" placeholder="Enter id Grpupe">
                        </div>
                        <div class="form-group">
                            <label>Prof</label>
                            <select type="number" name="editprof" class="form-control">
                                <?php
                                include "connect.php";

                                $sql = "SELECT prof.id_prof, prof.nom, prof.prenom, matier.nom_matier 
                                        FROM prof 
                                        INNER JOIN matier ON prof.id_matier = matier.id_matier";
                                $result = mysqli_query($conn, $sql);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($prof = mysqli_fetch_assoc($result)) {
                                        $selected = ($prof['id_prof'] == $row1['id_prof']) ? 'selected="selected"' : '';
                                        echo '<option value="' . $prof['id_prof'] . '" ' . $selected . '>' . $prof['nom'] . ' ' . $prof['prenom'] . ' - ' . $prof['nom_matier'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No professors available</option>';
                                }

                                
                                ?>
                            </select>
                        </div>

                        
                        <div class="form-group">
                            <label>Salle</label>
                            <select type="number" name="editsalle" class="form-control">
                                <?php
                                $sql = "SELECT id_salle FROM salle";
                                    $result = mysqli_query($conn, $sql);

                                    if ($result && mysqli_num_rows($result) > 0) {
                                        while ($salle = mysqli_fetch_assoc($result)) {
                                            $selected = ($salle['id_salle'] == $row1['id_salle']) ? 'selected="selected"' : '';
                                            echo '<option value="' . $salle['id_salle'] . '" ' . $selected . '>'. 'Salle  ' . $salle['id_salle'] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">No salle available</option>';
                                    }
                                ?>                               
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Date</label>
                            <select type="number" name="editDate" class="form-control">
                                <?php
                                $sql = "SELECT id_date, jour, heure FROM date_grp";
                                $result = mysqli_query($conn, $sql);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($date = mysqli_fetch_assoc($result)) {
                                        $selected = ($date['id_date'] == $row1['id_date']) ? 'selected="selected"' : '';
                                        echo '<option value="' . $date['id_date'] . '" ' . $selected . '>' . $date['jour'] . ' / ' . $date['heure'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No date available</option>';
                                }
                                ?>
                            </select>
                        </div>

                        
                            <div class="form-group">
                                <label>Niveau Scolaire</label>
                                <select type="text" name="editnivScolaire" class="form-control">
                                    <option value="NONE" <?php if ($row1['niv_scolaire'] == 'NONE') echo 'selected="selected"'; ?>>NONE</option>
                                    <option value="1er année collège" <?php if ($row1['niv_scolaire'] == '1er année collège') echo 'selected="selected"'; ?>>1er année collège</option>
                                    <option value="2eme année collège" <?php if ($row1['niv_scolaire'] == '2eme année collège') echo 'selected="selected"'; ?>>2eme année collège</option>
                                    <option value="3eme année collège" <?php if ($row1['niv_scolaire'] == '3eme année collège') echo 'selected="selected"'; ?>>3eme année collège</option>
                                    <option value="1er année lyceé" <?php if ($row1['niv_scolaire'] == '1er année lyceé') echo 'selected="selected"'; ?>>1er année lyceé</option>
                                    <option value="1er Bac" <?php if ($row1['niv_scolaire'] == '1er Bac') echo 'selected="selected"'; ?>>1er Bac</option>
                                    <option value="BAC" <?php if ($row1['niv_scolaire'] == 'BAC') echo 'selected="selected"'; ?>>BAC</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>

                        
                        <!-- Other fields -->
                        <a href="Groupe.php" class="btn btn-danger">Retour</a>
                        
                        <button type="submit" name="updatebtnGroupe" class="btn btn-primary">Update</button>
                    </form>
                <?php
                } else {
                    echo "Error executing query: " . mysqli_error($conn);
                }
            }
            mysqli_close($conn);

            

            ?>
        </div>
    </div>
</div>

<?php
include "scripts.php";
include "footer.php";
ob_end_flush();
?>
