<?php 
ob_start();
session_start();
include "header.php";
include "navbar.php";
?>




<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div id="content">

    <!-- Topbar -->
    <?php include "navbarTop.php";?>
   
  <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Listes des Groupes</h1>
        </div>

        <div class="row mb-4">
            <div class="col-lg-12">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addClassModal">
                    + Creer Un Croupe
                </button>
            </div>
        </div>
        <form method="POST" action="Groupe.php">
            <div class="row mb-3">
                <div class="col-lg-4">
                    <div class="input-group">                        
                        <input type="number" class="form-control" name="CherchIdGroupe" placeholder="Recherche par Numéro de Groupe" aria-label="Recherche par Numéro de Groupe" >
                    </div>
                </div>
                <div class="col-lg-12 mt-2">
                    <a href="Groupe.php" class="btn btn-danger"> Réinitialiser </a>
                    <button class="btn btn-primary" type="submit"  name="searchGroupe">Chercher</button>
                </div>
            </div>
        </form>
    

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="ClassTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Numéro de Groupe</th>
                                        <th>Nombre des Eleves</th>
                                        <th>Jour/heure</th>
                                        <th>Salle</th>
                                        <th>Prof</th>
                                        <th>Matière</th>
                                        <th>Niv_Scolaire</th>
                                        <th>Ajouter Etudiant</th>
                                        <th>Editer</th>
                                        <th>Supprimer</th>
                                    </tr>
                                </thead>
                                <tbody id="classesBody">
                                    <!-- Les données des enseignants seront ajoutées ici -->
                                    <?php
                                                include "connect.php";
                                                // $sql = "SELECT e.id_etud, e.nom, e.prenom, e.num_tele, e.deja_abs
                                                //         FROM etudiant e";
                                                include "RecherchGroupe.php";
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addClassModal" tabindex="-1" role="dialog" aria-labelledby="addClassModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addClassModalLabel">Creer Un Groupe</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="ClassForm" method="post">
                            <div class="form-group">
                                <label for="classes">Date</label>
                                <select id="id_date" name="id_date_heure">
                                    <!-- Fetching existing id_date and heure data from the database -->
                                    <?php
                                    include "connect.php";

                                    $sql = "SELECT id_date, jour, heure FROM date_grp";
                                    $result = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="' . $row['id_date'] . '">' . $row['jour'] . ' / ' . $row['heure'] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">No date available</option>';
                                    }

                                    mysqli_close($conn);
                                    ?>
                                </select><br><br>
                                <label for="capacité d'acceuil">Salle</label>
                                <select id="id_salle" name="id_salle">
                                    <!-- Fetching existing id_salle data from the database -->
                                <?php
                                    include "connect.php";

                                    $sql = "SELECT id_salle FROM salle";
                                    $result = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="' . $row['id_salle'] . '">' . $row['id_salle'] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">No salle available</option>';
                                    }

                                    mysqli_close($conn);
                                ?>
                                </select><br><br>
                                <label for="scolarité">Professeur</label>
                                <select id="id_prof" name="id_prof_matier">
                                    <!-- Fetching existing id_prof and matier data from the database -->
                                    <?php
                                    include "connect.php";

                                    $sql = "SELECT prof.id_prof, prof.nom, prof.prenom, matier.nom_matier 
                                            FROM prof 
                                            INNER JOIN matier ON prof.id_matier = matier.id_matier";
                                    $result = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="' . $row['id_prof'] . '">' . $row['nom'] . ' ' . $row['prenom'] . ' - ' . $row['nom_matier'] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">No professor available</option>';
                                    }

                                    mysqli_close($conn);
                                    ?>
                                </select><br><br>
                                <label for="niv_scolaire">Niveau Scolaire:</label>
                                <select id="niv_scolaire" name="niv_scolaire">
                                    <!-- Add options based on your existing data -->
                                    <option value="NONE">NONE</option>
                                    <option value="1er année collège">1er année collège</option>
                                    <option value="2eme année collège">2eme année collège</option>
                                    <option value="3eme année collège">3eme année collège</option>
                                    <option value="1er année lyceé">1er année lyceé</option>
                                    <option value="1er Bac">1er Bac</option>
                                    <option value="BAC">BAC</option>
                                    <!-- Add more options as per your available data -->
                                </select><br><br>
                            </div>
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">Réinitialiser</button>
                            <button type="submit" name="EnregistrerGroupe" class="btn btn-primary">Enregistrer</button>
                            <?php
                                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['EnregistrerGroupe'])) {
                                    $id_date_heure = $_POST['id_date_heure'];
                                    $id_salle = $_POST['id_salle'];
                                    $id_prof_matier = $_POST['id_prof_matier'];
                                    $niv_scolaire = $_POST['niv_scolaire'];

                                    if (!empty($id_date_heure) && !empty($id_salle) && !empty($id_prof_matier) && !empty($niv_scolaire)) {
                                        include "connect.php";

                                        // Split the date and time
                                        $id_date_heure_parts = explode("-", $id_date_heure);
                                        $id_date = $id_date_heure_parts[0];
           

                                        // Check if the salle is available at the specified date and time
                                        $sql_check_availability = "SELECT id_group FROM groupe WHERE id_date = '$id_date' AND id_salle = '$id_salle'";
                                        $result_check_availability = mysqli_query($conn, $sql_check_availability);

                                        if (mysqli_num_rows($result_check_availability) > 0) {
                                            // The salle is already occupied at the specified date and time
                                            echo "The selected room (salle) is already occupied at the specified date and time. Please choose another room or time.";
                                        } else {
                                            // The salle is available; proceed with the insertion
                                            $sql_insert_group = "INSERT INTO groupe (id_date, id_prof, id_salle, niv_scolaire) 
                                                                VALUES ('$id_date', '$id_prof_matier', '$id_salle', '$niv_scolaire')";
                                            if (mysqli_query($conn, $sql_insert_group)) {
                                                header("Location: Groupe.php");
                                            } else {
                                                echo "Error: " . $sql_insert_group . "<br>" . mysqli_error($conn);
                                            }
                                        }

                                        mysqli_close($conn); // Close the database connection
                                    } else {
                                        echo "Please fill in all the required fields.";
                                    }
                                }
                                ?>

                        </form>
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