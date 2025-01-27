<?php
ob_start(); 
session_start();
include "header.php";
include "navbar.php";

if (isset($_POST['FairePresenceBtn'])) {
    $_SESSION['id_group'] = $_POST['IdGroupePresence'];
    $id_group = isset($_SESSION['id_group']) ? $_SESSION['id_group'] : '';
}

?>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Liste de Groupe <?php echo $id_group; ?> </h1>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <form method="post" action="">
                            <input type="hidden" name="id_group" value="<?php echo isset($_SESSION['id_group']) ? $_SESSION['id_group'] : ''; ?>">
                            <table class="table table-bordered" id="coursTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Etudiant</th>
                                        <th>Absence</th>
                                    </tr>
                                </thead>
                                <tbody id="classesBody">
                                    <?php
                                    $Date_sc = isset($_SESSION['Date_sc']) ? $_SESSION['Date_sc'] : '';
                                    include "connect.php";
                                    $jour = isset($_SESSION['jour_Sc']) ? $_SESSION['jour_Sc'] : '';
                                    $id_group = isset($_SESSION['id_group']) ? $_SESSION['id_group'] : '';
                                    $sql = "SELECT id_etud, nom, prenom, deja_abs FROM etudiant WHERE id_etud IN (
                                                SELECT id_etud FROM appartenir WHERE id_group = '$id_group')";
                                    $result = mysqli_query($conn, $sql);
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                            <tr>
                                                <td><?php echo $row['nom'] . ' ' . $row['prenom']; ?></td>
                                                <td>
                                                    <label><input type="checkbox" name="students1[]" value="<?php echo $row['id_etud']; ?>"> Absent</label>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    ?>
                                <?php
                                    } else {
                                        echo "No Record Found";
                                    }
                                ?>
                                </tbody>
                            </table>
                            <input type="submit" class="btn btn-primary" name="submitListe" value="Enregistrer">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Process the form submission to update student presence
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitListe'])) {
    $id_group = isset($_SESSION['id_group']) ? $_SESSION['id_group'] : '';
    $sql = "SELECT id_etud, nom, prenom, deja_abs FROM etudiant WHERE id_etud IN (
                SELECT id_etud FROM appartenir WHERE id_group = '$id_group')";
    $result = mysqli_query($conn, $sql);
    $Date_sc = isset($_SESSION['Date_sc']) ? $_SESSION['Date_sc'] : '';

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id_etud = $row['id_etud'];
            $abs_or_not = isset($_POST['students1']) && in_array($id_etud, $_POST['students1']) ? 1 : 0;

            // Your existing insertion logic
            $sqlInsertPresence = "INSERT INTO presence (id_group, date_sc, id_etud, abs_or_not) VALUES (?, ?, ?, ?)";
            $stmtInsertPresence = $conn->prepare($sqlInsertPresence);
            $stmtInsertPresence->bind_param("issi", $id_group, $Date_sc, $id_etud, $abs_or_not);
            $stmtInsertPresence->execute();
            $stmtInsertPresence->close(); // Close the statement after execution

            // Your existing update logic
            if ($abs_or_not == 1) {
                // Check if the student is absent and already marked absent
                if ($row['deja_abs'] === null || $row['deja_abs'] == 0) {
                    // Increment nbr_abs
                    $sqlUpdateAppartenirNbrAbs = "UPDATE appartenir SET nbr_abs = nbr_abs + 1 WHERE id_etud = ? AND id_group = ?";
                    $stmtUpdateAppartenirNbrAbs = $conn->prepare($sqlUpdateAppartenirNbrAbs);
                    $stmtUpdateAppartenirNbrAbs->bind_param("ii", $id_etud, $id_group);
                    $stmtUpdateAppartenirNbrAbs->execute();
                    $stmtUpdateAppartenirNbrAbs->close(); // Close the statement after execution

                    // Set deja_abs to 1
                    $sqlUpdateEtudiantDejaAbs = "UPDATE etudiant SET deja_abs = 1 WHERE id_etud = ?";
                    $stmtUpdateEtudiantDejaAbs = $conn->prepare($sqlUpdateEtudiantDejaAbs);
                    $stmtUpdateEtudiantDejaAbs->bind_param("i", $id_etud);
                    $stmtUpdateEtudiantDejaAbs->execute();
                    $stmtUpdateEtudiantDejaAbs->close(); // Close the statement after execution
                } else {
                    // Increment nbr_abs and decrement nbr_sc_payee
                    $sqlUpdateAppartenir = "UPDATE appartenir SET nbr_abs = nbr_abs + 1, nbr_sc_payee = nbr_sc_payee - 1 WHERE id_etud = ? AND id_group = ?";
                    $stmtUpdateAppartenir = $conn->prepare($sqlUpdateAppartenir);
                    $stmtUpdateAppartenir->bind_param("ii", $id_etud, $id_group);
                    $stmtUpdateAppartenir->execute();
                    $stmtUpdateAppartenir->close(); // Close the statement after execution
                }
            } elseif ($abs_or_not == 0) {
                // Decrement nbr_sc_payee
                $sqlUpdateAppartenirNbrScPayee = "UPDATE appartenir SET nbr_sc_payee = nbr_sc_payee - 1 WHERE id_etud = ? AND id_group = ?";
                $stmtUpdateAppartenirNbrScPayee = $conn->prepare($sqlUpdateAppartenirNbrScPayee);
                $stmtUpdateAppartenirNbrScPayee->bind_param("ii", $id_etud, $id_group);
                $stmtUpdateAppartenirNbrScPayee->execute();
                $stmtUpdateAppartenirNbrScPayee->close(); // Close the statement after execution
            }
            $sqlCheckNbrScPayee = "SELECT nbr_sc_payee FROM appartenir WHERE id_etud = ? AND id_group = ?";
            $stmtCheckNbrScPayee = $conn->prepare($sqlCheckNbrScPayee);
            $stmtCheckNbrScPayee->bind_param("ii", $id_etud, $id_group);
            $stmtCheckNbrScPayee->execute();
            $resultCheckNbrScPayee = $stmtCheckNbrScPayee->get_result();
            $rowCheckNbrScPayee = $resultCheckNbrScPayee->fetch_assoc();

            if ($rowCheckNbrScPayee['nbr_sc_payee'] == 0) {
                // Delete the student from appartenir
                $sqlDeleteAppartenir = "DELETE FROM appartenir WHERE id_etud = ? AND id_group = ?";
                $stmtDeleteAppartenir = $conn->prepare($sqlDeleteAppartenir);
                $stmtDeleteAppartenir->bind_param("ii", $id_etud, $id_group);
                $stmtDeleteAppartenir->execute();
                $stmtDeleteAppartenir->close(); // Close the statement after execution
            }
            $stmtCheckNbrScPayee->close(); // Close the statement after execution
        }
    }

    // Redirect or display a success message
    header('Location: presence.php');
}

include "scripts.php";
include "footer.php";
ob_end_flush();
?>