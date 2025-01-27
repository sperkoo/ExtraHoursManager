<?php
ob_start(); 
session_start();
include "header.php";
include "navbar.php";
?>

<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"> Modifier Etudiant </h6>
        </div>
        <div class="card-body">
        <?php

        if(isset($_POST['edit_btnEtudiant']))
        {
            $id_etud = $_POST['edit_idEtudiant'];
            
            $query = "SELECT e.id_etud, e.nom, e.prenom, e.num_tele, e.deja_abs, a.id_group, a.nbr_sc_payee
            FROM etudiant e
            LEFT JOIN appartenir a ON e.id_etud = a.id_etud
            WHERE e.id_etud ='$id_etud'";
            include "connect.php";

            $query_run = mysqli_query($conn, $query);

            foreach($query_run as $row)
            {
                ?>

                    <form action="EditEtudiant.php" method="POST">
                        <div class="form-group">
                            <label> Id Etudiant </label>
                            <input type="text" name="editidEtudiant" value="<?php echo $row['id_etud'] ?>" class="form-control"
                                placeholder="Enter Prenom">
                        </div>
                        <?php if ($row['id_group'] != NULL) { ?>
                            <div class="form-group">
                                <label>Numero Groupe </label>
                                <input type="text" name="editidGroupe" value="<?php echo $row['id_group'] ?>" class="form-control"
                                    placeholder="Enter Prenom">
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label> Prénom </label>
                            <input type="text" name="editprenomEtudiant" value="<?php echo $row['prenom'] ?>" class="form-control"
                                placeholder="Enter Prenom">
                        </div>
                        <div class="form-group">
                            <label>Nom</label>
                            <input type="text" name="editnomEtudiant" value="<?php echo $row['nom'] ?>" class="form-control"
                                placeholder="Enter Email">
                        </div>
                        <?php if ($row['nbr_sc_payee'] != NULL) { ?>
                            <div class="form-group">
                                <label>Nombre Séance Payée</label>
                                <input type="text" name="editSeancePayee" value="<?php echo $row['nbr_sc_payee'] ?>" class="form-control"
                                    placeholder="Enter le Nombre">
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label>Telephone</label>
                            <input type="number" name="edittelEtudiant" value="<?php echo $row['num_tele'] ?>"
                                class="form-control" placeholder="Enter Password">
                        </div>
                        <div class="form-group">
                            <label>Déja Abscent</label>
                            <select name="editDeja_abs" class="form-control">
                                <option value="1" <?php if ($row['deja_abs'] == '1') echo 'selected="selected"'; ?>>Oui</option>
                                <option value="0" <?php if ($row['deja_abs'] == '0') echo 'selected="selected"'; ?>>Non</option>
                            </select>
                        </div>

                        <a href="Etudiant.php" class="btn btn-danger"> Retour </a>
                        <button type="submit" name="updatebtnEtudiant" class="btn btn-primary"> Update </button>

                    </form>
                    <?php
                }
            }
            if(isset($_POST['updatebtnEtudiant']))
                {
                    $id_etud = $_POST['editidEtudiant'];
                    $prenom = $_POST['editprenomEtudiant'];
                    $nom = $_POST['editnomEtudiant'];
                    $num_tele = $_POST['edittelEtudiant'];
                    $seancepayee= $_POST['editSeancePayee'];
                    $deja_abs = $_POST['editDeja_abs'];
                    $id_group = $_POST['editidGroupe'];


                    include "connect.php";

                    $query = "UPDATE etudiant SET prenom='$prenom', nom='$nom', num_tele='$num_tele' , deja_abs='$deja_abs' WHERE id_etud='$id_etud' ";
                    $sql="UPDATE appartenir SET nbr_sc_payee = '$seancepayee' WHERE id_etud = '$id_etud' AND id_group = '$id_group';";
                    $query_run = mysqli_query($conn, $query);
                    $sql_run = mysqli_query($conn, $sql);


                    if($query_run && $sql_run)
                    {
                        $_SESSION['status'] = "Your Data is Updated";
                        $_SESSION['status_code'] = "success";
                        header('Location: Etudiant.php'); 
                    }
                    else
                    {
                        $_SESSION['status'] = "Your Data is NOT Updated";
                        $_SESSION['status_code'] = "error";
                        header('Location: Etudiant.php'); 
                    }
                }
                
                
                if(isset($_POST['delete_btnEtudiant']))
                {
                    $id_etud = $_POST['delete_idEtudiant'];
                    include "connect.php";
                    $query = "DELETE FROM etudiant WHERE id_etud = $id_etud;";
                    $query_run = mysqli_query($conn, $query);
                
                    if($query_run)
                    {
                        $_SESSION['status'] = "Your Data is Deleted";
                        $_SESSION['status_code'] = "success";
                        header('Location: Etudiant.php'); 
                    }
                    else
                    {
                        $_SESSION['status'] = "Your Data is NOT DELETED";       
                        $_SESSION['status_code'] = "error";
                        header('Location: Etudiant.php'); 
                    }    
                }
                        ?>
        </div>
    </div>
</div>

</div>
<?php 
include "scripts.php";
include "footer.php";
ob_end_flush();    
?>