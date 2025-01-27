<?php
ob_start(); 
session_start();
include "header.php";
include "navbar.php";

if (isset($_POST['Ajout_btn'])) {
    $_SESSION['id_group'] = $_POST['Ajout_id'];
}

?>

<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"> Ajouter Etudiant à Un Groupe </h6>
        </div>
        <div class="card-body">
            <form action="AjoutEtuGroupe.php" method="POST">
                <div class="form-group">
                    <label> Id Groupe</label>
                    <input type="number" name="GroupeID" value="<?php echo isset($_SESSION['id_group']) ? $_SESSION['id_group'] : ''; ?>" class="form-control" placeholder="Enter Group ID">
                </div>
                <div class="form-group">
                    <label>Nom Etudiant</label>
                    <input type="text" name="NomEtudiant" class="form-control" placeholder="Enter Nom Etudiant">
                </div>
                <div class="form-group">
                    <label>Prenom Etudiant</label>
                    <input type="text" name="PrenomEtudiant" class="form-control" placeholder="Enter Prenom Etudiant">
                </div>
                <div class="form-group">
                    <label for="niv_scolaire">Type Scéance</label>
                    <select  class="form-control" type="number" name="TypeSceance">
                        <option value="1">Test</option>
                        <option value="0">Subsciption</option>
                    </select><br><br>
                </div>

                <a href="Groupe.php" class="btn btn-danger"> Retour </a>
                <button type="submit" name="ChercherEtudiant" class="btn btn-primary"> Chercher </button>
            </form>
            
            <?php 
            if(isset($_POST['ChercherEtudiant'])) {
                $nom = $_POST['NomEtudiant'];
                $prenom = $_POST['PrenomEtudiant'];
                include "connect.php";
        
                $sql = "SELECT id_etud FROM etudiant WHERE nom = '$nom' AND prenom = '$prenom'";
                $result = mysqli_query($conn, $sql);
        
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $id_etud = $row['id_etud'];
                } else {
                    echo "Etudiant non trouvé";
                }
                
                mysqli_close($conn);
            }
            ?>
            
            <!-- Second form -->
            <?php if(isset($id_etud)) { ?>
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form action="InsertApp.php" method="POST">
                            <input type="hidden" name="idEtudiant" value="<?php echo $id_etud; ?>">
                            <!-- Ensure $id_group is properly assigned -->
                            <?php $id_group = isset($_SESSION['id_group']) ? $_SESSION['id_group'] : ''; ?>
                            <input type="hidden" name="GroupeID" value="<?php echo $id_group; ?>">
                            <div class="form-group">
                                <label>Id Etudiant</label>
                                <input type="number" name="idEtudiant" class="form-control" value="<?php echo $id_etud ?>" placeholder="Enter Id Etudiant">
                            </div>
                            <div class="form-group">
                                <label> Id Groupe</label>
                                <input type="number" name="GroupeID" value="<?php echo $id_group; ?>" class="form-control" placeholder="Enter Group ID">
                            </div>
                            <div class="form-group">
                                <label>Nombre Sceance Payée</label>
                                <?php
                                    $nombreSceance = '';
                                    if (isset($_POST['TypeSceance'])) {
                                        $typeSceance = $_POST['TypeSceance'];
                                        if ($typeSceance == '1') {
                                            $nombreSceance = '1';
                                        } elseif ($typeSceance == '0') {
                                            $nombreSceance = '4';
                                        }
                                    }
                                ?>
                                <input type="number" name="NbrSeanceEtudiant" value="<?php echo $nombreSceance; ?>" class="form-control" min="<?php echo $nombreSceance; ?>" >
                            </div>                            
                            <a href="Groupe.php" class="btn btn-danger"> Retour </a>
                            <button type="submit" name="AjoutEtudiant" class="btn btn-primary"> Ajout </button>
                        </form>
                        <?php } ?>
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
