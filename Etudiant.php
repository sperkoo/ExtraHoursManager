<?php include "header.php";
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
            <h1 class="h3 mb-0 text-gray-800">Listes des élèves</h1>
        </div>

        <div class="row mb-4">
            <div class="col-lg-12">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addEleveModal">
                    + Ajouter un élève
                </button>
            </div>
        </div>
        <form method="POST" action="Etudiant.php">
            <div class="row mb-3">
                <div class="col-lg-3">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Prenom" name="PrenomEtudiant" aria-label="Recherche par Année scolaire" id="filterByYear">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Nom" name="nomEtudiant" aria-label="Recherche par Classe" id="filterByClasse">
                    </div>
                </div>
                <div class="col-lg-12 mt-2">
                    <button class="btn btn-primary" name="searchEtudiant" type="submit" id="searchEtudiants">Chercher</button>
                </div>
            </div>
        </form>

    

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="etudiantsTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Id_Etudiant</th>
                                        <th>Prénom</th>
                                        <th>Nom</th>
                                        <th>Mobile</th>
                                        <th>Déja Absent</th>
                                        <th>Nombre Seance resté</th>
                                        <th>Groupe</th>
                                        <th>Editer</th>
                                        <th>Supprimer</th>
                                    </tr>
                                </thead>
                                <tbody id="classesBody">
                                <?php
                                    // include "connect.php";
                                    // $sql = "SELECT e.id_etud, e.nom, e.prenom, e.num_tele, e.deja_abs
                                    //         FROM etudiant e";
                                    // $sql = "SELECT e.id_etud,e.nom,e.prenom,e.num_tele,e.deja_abs,a.id_group,a.nbr_sc_payee
                                    // FROM etudiant e
                                    // INNER JOIN appartenir a ON e.id_etud = a.id_etud";
                                    // $result = mysqli_query($conn, $sql);

                                    // if (mysqli_num_rows($result) > 0) {
                                    //     while($row = mysqli_fetch_assoc($result)) {
                                    //         echo "<tr>";
                                    //         echo "<td>".$row["id_etud"]."</td>";
                                    //         echo "<td>".$row["prenom"]."</td>";
                                    //         echo "<td>".$row["nom"]."</td>";
                                    //         echo "<td>".$row["num_tele"]."</td>";
                                    //         echo "<td>".$row["deja_abs"]."</td>";
                                    //         echo "<td>".$row["nbr_sc_payee"]."</td>";
                                    //         echo "<td>".$row["id_group"]."</td>";
                                    //         echo "</tr>";
                                    //     }
                                    // } else {
                                    //     echo "<tr><td colspan='7'>No records found.</td></tr>";
                                    // }
                                    // mysqli_close($conn);
                                    include "RecherchEtudiant.php"
                                ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addEleveModal" tabindex="-1" role="dialog" aria-labelledby="addEleveModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addEleveModalLabel">Ajouter un élève</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="EleveForm" method="post" action="Etudiant.php">
                            <div class="form-group">                                
                                <label for="prénom">Prénom</label>
                                <input type="text" class="form-control" name="prenomEtudiant" id="prénom" placeholder="Entrez le prénom ">
                                <label for="nom">Nom</label>
                                <input type="text" class="form-control" name="nomEtudiant" id="nom" placeholder="Entrez le nom ">
                                <label for="tel">Tel</label>
                                <input type="number" class="form-control" name="telephoneEtudiant" id="tel" placeholder="Entrez le telephone ">                                                              
                            </div>
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">Réinitialiser</button>
                            <button type="submit" name="submitEnregistrerEleve" class="btn btn-primary">Enregistrer</button>
                            <?php
                                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitEnregistrerEleve'])) {
                                    $prenomEtudiant = $_POST['prenomEtudiant'];
                                    $nomEtudiant = $_POST['nomEtudiant'];
                                    $telEtudiant = $_POST['telephoneEtudiant'];
                                    
                                    
                                    if (!empty($prenomEtudiant) || !empty($nomEtudiant) || !empty($telEtudiant)) {
                                        // Query for searched elements
                                        include "connect.php";
                                        $sql = "INSERT INTO etudiant (nom, prenom, num_tele)
                                                VALUES ('$nomEtudiant', '$prenomEtudiant', '$telEtudiant')";
                                        $result = mysqli_query($conn, $sql);
                                        header("Location: Etudiant.php");
                                        $conn->close();                                                
                                    }
                                }
                            ?>
                        </form>                       
                    </div>
                </div>
            </div>
        </div>


  </div>
  


<?php include "scripts.php";
      include "footer.php"; 
?>