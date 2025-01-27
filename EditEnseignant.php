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
            <h6 class="m-0 font-weight-bold text-primary"> Modifier Enseignant </h6>
        </div>
        <div class="card-body">
        <?php

            if(isset($_POST['edit_btn']))
            {
                $id_prof = $_POST['edit_id'];
                
                $query = "SELECT p.id_prof, p.nom, p.prenom, p.num_tele, m.nom_matier
                FROM prof p
                INNER JOIN matier m ON p.id_matier = m.id_matier
                WHERE p.id_prof ='$id_prof'";
                include "connect.php";

                $query_run = mysqli_query($conn, $query);

                foreach($query_run as $row)
                {
                    ?>

                        <form action="EditEnseignant.php" method="POST">
                            <div class="form-group">
                                <label> Id Prof </label>
                                <input type="text" name="editidEnseigant" value="<?php echo $row['id_prof'] ?>" class="form-control"
                                    placeholder="Enter Prenom">
                            </div>


                            <div class="form-group">
                                <label> Prénom </label>
                                <input type="text" name="editprenomEnseigant" value="<?php echo $row['prenom'] ?>" class="form-control"
                                    placeholder="Enter Prenom">
                            </div>
                            <div class="form-group">
                                <label>Nom</label>
                                <input type="text" name="editnomEnseigant" value="<?php echo $row['nom'] ?>" class="form-control"
                                    placeholder="Enter Email">
                            </div>
                            <div class="form-group">
                                <label>Telephone</label>
                                <input type="number" name="edittelEnseigant" value="<?php echo $row['num_tele'] ?>"
                                    class="form-control" placeholder="Enter Password">
                            </div>

                            <a href="Enseignant.php" class="btn btn-danger"> Retour </a>
                            <button type="submit" name="updatebtn" class="btn btn-primary"> Update </button>

                        </form>
                        <?php
                    }
                }
                        if(isset($_POST['updatebtn']))
                            {
                                $id_prof = $_POST['editidEnseigant'];
                                $prenom = $_POST['editprenomEnseigant'];
                                $nom = $_POST['editnomEnseigant'];
                                $num_tele = $_POST['edittelEnseigant'];
                                include "connect.php";

                                $query = "UPDATE prof SET prenom='$prenom', nom='$nom', num_tele='$num_tele' WHERE id_prof='$id_prof' ";
                                $query_run = mysqli_query($conn, $query);

                                if($query_run)
                                {
                                    $_SESSION['status'] = "Your Data is Updated";
                                    $_SESSION['status_code'] = "success";
                                    header('Location: Enseignant.php'); 
                                }
                                else
                                {
                                    $_SESSION['status'] = "Your Data is NOT Updated";
                                    $_SESSION['status_code'] = "error";
                                    header('Location: Enseignant.php'); 
                                }
                            }
                            
                            
                            if(isset($_POST['delete_btn']))
                            {
                                $id_prof = $_POST['delete_id'];
                                include "connect.php";
                                $query = "DELETE FROM prof WHERE id_prof = $id_prof;";
                                $query_run = mysqli_query($conn, $query);
                            
                                if($query_run)
                                {
                                    $_SESSION['status'] = "Your Data is Deleted";
                                    $_SESSION['status_code'] = "success";
                                    header('Location: Enseignant.php'); 
                                }
                                else
                                {
                                    $_SESSION['status'] = "Your Data is NOT DELETED";       
                                    $_SESSION['status_code'] = "error";
                                    header('Location: Enseignant.php'); 
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