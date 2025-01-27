<?php session_start();
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
            <h1 class="h3 mb-0 text-gray-800">Présence</h1>
        </div>

        <div class="row mb-4">
            <div class="col-lg-12">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addCoursModal">
                    + Ajouter Présence d'une Séance
                </button>
            </div>
        </div>
        <form method="POST" action="presence.php"> 
            <div class="row mb-3">
                <div class="col-lg-3">
                    <div class="input-group">
                        <input type="number" class="form-control" placeholder="Id-Groupe" name="IdGroupe" aria-label="Recherche par Id-Groupe" id="filterByClasse">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Nom Etudiant" name="nomEtudiant" aria-label="Recherche par Nom Etudiant" id="filterByClasse">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Prenom Etudiant" name="PrenomEtudiant" aria-label="Recherche par Prenom Etudiant" id="filterByClasse">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input-group">
                        <input type="date" class="form-control" placeholder="Date Séance" name="DateSceance" aria-label="Recherche par Date Séance" id="dateField">
                    </div>
                </div> 
                <div class="col-lg-12 mt-2">
                    <button class="btn btn-primary" type="submit"  name="CherchPresence" >Chercher</button>
                </div>
            </div>
        </form>
        
    

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="coursTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Numero Groupe</th>
                                        <th>Id Etudiant</th>
                                        <th>Etudiants(e)</th>
                                        <th>Date Séance</th>
                                        <th>Abscence</th>
                                        <th>Matière</th>
                                        <th>Formation</th>
                                    </tr>
                                </thead>
                                <tbody id="classesBody">
                                    <?php
                                        include "connect.php";
                                        // $sql = "SELECT e.id_etud, e.nom, e.prenom, e.num_tele, e.deja_abs
                                        //         FROM etudiant e";
                                        // $sql = "SELECT p.id_group,p.id_etud,e.nom,e.prenom,p.date_sc,p.abs_or_not,m.nom_matier,f.nom_formation
                                        // FROM presence p
                                        // JOIN etudiant e ON p.id_etud = e.id_etud
                                        // JOIN groupe g ON p.id_group = g.id_group
                                        // JOIN prof pr ON g.id_prof = pr.id_prof
                                        // JOIN matier m ON pr.id_matier = m.id_matier
                                        // JOIN formation f ON m.id_formation = f.id_formation;";
                                        // $result = mysqli_query($conn, $sql);

                                        // if(mysqli_num_rows($result) > 0)        
                                        // {
                                        //     while($row = mysqli_fetch_assoc($result))
                                        //     {
                                            include "RecherchPresence.php";
                                        ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addCoursModal" tabindex="-1" role="dialog" aria-labelledby="addCoursModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCoursModalLabel">Ajouter Présence d'une Séance</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form  action="nextPresence.php" method="post" >
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" name="Date_sc" id="date" placeholder="Entrez la date">
                                <label for="daySelect">Selectitoner Un Jour:</label>
                                <select type="text" name="jour" class="form-control" id="daySelect">
                                    <option value="lundi">Lundi</option>
                                    <option value="mardi">Mardi</option>
                                    <option value="mercredi">Mercredi</option>
                                    <option value="jeudi">Jeudi</option>
                                    <option value="vendredi">Vendredi</option>
                                    <option value="samedi">Samedi</option>
                                </select>
                            </div>
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">Réinitialiser</button>
                            <button type="submit" name="NextStepPresence" class="btn btn-primary">Next</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


  </div>
  








<?php 
include "scripts.php";
include "footer.php";    
?>