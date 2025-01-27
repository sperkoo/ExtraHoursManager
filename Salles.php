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
            <h1 class="h3 mb-0 text-gray-800">Listes des Salles</h1>
        </div>

        <div class="row mb-4">
            <div class="col-lg-12">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addSalleModal">
                    + Ajouter une salle
                </button>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Recherche par numero" aria-label="Recherche par numero" id="filterByName">
                </div>
            </div>
            <div class="col-lg-12 mt-2">
                <button class="btn btn-primary" type="button" id="searchsalles">Chercher</button>
            </div>
        </div>
    

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="sallesTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom de Salle</th>
                                        <th>Capacité d'accueil</th>
                                        <th>Emplacement</th>
                                        <th>Classes</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="enseignantsBody">
                                    <!-- Les données des enseignants seront ajoutées ici -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addSalleModal" tabindex="-1" role="dialog" aria-labelledby="addSalleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSalleModalLabel">Ajouter une salle</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="salleForm">
                            <div class="form-group">
                                <label for="nom">Nom de salle</label>
                                <input type="text" class="form-control" id="nom" placeholder="Entrez le nom de salle">
                                <label for="capacité">Capacité d'accueil</label>
                                <input type="number" class="form-control" id="capacité" placeholder="Entrez la Capacité d'accueil">
                                <label for="emp">Emplacement</label>
                                <input type="text" class="form-control" id="emp" placeholder="Entrez l'emplacement">
                                <label for="classe">Classe</label>
                                <input type="text" class="form-control" id="classe" placeholder="Entrez la classe">
                            </div>
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">Réinitialiser</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


  </div>

<?php include "scripts.php";
      include "footer.php"; 
?>
