<?php
ob_start(); 
session_start();
include "header.php";
include "navbar.php";


if (isset($_POST['NextStepPresence'])) {
    $_SESSION['Date_sc'] = $_POST['Date_sc'];
    $_SESSION['jour_Sc'] = $_POST['jour'];

}
?>


<div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Présence</h1>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="coursTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Numéro de Groupe</th>
                                        <th>Nombre des Eleves</th>
                                        <th>Jour/heure</th>
                                        <th>Salle</th>
                                        <th>Prof</th>
                                        <th>Matière</th>
                                        <th>Niv_Scolaire</th>
                                        <th>Faire Absence</th>
                                    </tr>
                                </thead>
                                <tbody id="classesBody">
                                <?php
                                                $Date_sc= isset($_SESSION['Date_sc']) ? $_SESSION['Date_sc'] : '';                                                
                                                include "connect.php";
                                                // $sql = "SELECT e.id_etud, e.nom, e.prenom, e.num_tele, e.deja_abs
                                                //         FROM etudiant e";echo isset($_SESSION['id_group']) ? $_SESSION['id_group'] : '';
                                                $jour= isset($_SESSION['jour_Sc']) ? $_SESSION['jour_Sc'] : '';
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
                                            WHERE dg.jour = '$jour'  -- Replace 'echo isse' with the PHP variable or value
                                            GROUP BY g.id_group, p.nom, p.prenom, m.nom_matier, s.id_salle, dg.jour, dg.heure, g.niv_scolaire;";
                                                $result = mysqli_query($conn, $sql);
                                                if(mysqli_num_rows($result) > 0)        
                                                {
                                                    while($row = mysqli_fetch_assoc($result))
                                                    {
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
                                                        <form action="ListePresence.php" method="post">
                                                            <input type="hidden" name="IdGroupePresence" value="<?php echo $row['id_group']; ?>" >
                                                            <button type="submit" name="FairePresenceBtn" class="btn btn-info"> Faire Présence</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                                } 
                                            }
                                            else {
                                                echo "No Record Found";
                                            }
                                            ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </div>





<?php 
include "scripts.php";
include "footer.php";
ob_end_flush();    
?>
