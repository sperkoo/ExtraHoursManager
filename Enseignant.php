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
                        <h1 class="h3 mb-0 text-gray-800">Listes des Enseignants</h1>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-lg-12">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#addTeacherModal">
                                + Ajouter un enseignant
                            </button>
                        </div>
                    </div>
                    <form method="POST" action="Enseignant.php">
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="PrenomEnseignant" placeholder="Recherche par prénom" aria-label="Recherche par prénom" >
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nomEnseignant" placeholder="Recherche par nom" aria-label="Recherche par nom" >
                                </div>
                            </div>                        
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <select type="text" class="form-control" name="selectMatiere" id="profession"  >
                                        <option value="" selected hidden>Select Matiere</option>
                                        <option value="mathematiques" >Math</option>
                                        <option value="phisique chimie" >Physique chimie</option>
                                        <option value="science de la vie et de la terre" >SVT</option>
                                        <option value="philosophie" >philosophie</option>
                                        <option value="ANGLAIS" >ANGLAIS</option>
                                        <option value="histoire geografique" >Histoire Geografique</option>
                                        <option value="education islamique" >Education Islamique</option>
                                        <option value="la langue allemande" >la langue allemande</option>
                                        <option value="la langue espagnole" >la langue espagnole</option>
                                        <option value="la langue anglaise" >la langue anglaise</option>
                                        <option value="la langue chinoise" >la langue chinoise</option>
                                        <option value="C" >Langage  C</option>
                                        <option value="C++" >Langage  C++</option>
                                        <option value="PYTHON" >Langage  PYTHON</option>
                                        <option value="HTML" >Langage  HTML</option>
                                        <option value="CSS" >Langage  CSS</option>
                                        <option value="PHP" >Langage  PHP</option>
                                        <option value="JAVASCRIPT" >Langage  JAVASCRIPT</option>
                                        <option value="MYSQL" >Langage  MYSQL</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <select  type="text" class="form-control" name="selectFormation" id="profession">
                                        <option value="" selected hidden>Select Formation</option>
                                        <option value="soutien scolaire" >Soutien Scolaire</option>
                                        <option value="les langues" >Les Langues</option>
                                        <option value="les langages de programation" >Les Langages De Programation</option>                                    
                                    </select>
                                </div>
                            </div>                        
                            <div class="col-lg-12 mt-2">
                                <button class="btn btn-primary" type="submit" name="SearchEnseignant" id="searchTeachers">Chercher</button>
                            </div>
                        </div>
                    </form>
                

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="enseignantsTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Id_Enseignant</th>
                                                    <th>Prenom</th>
                                                    <th>Nom</th>
                                                    <th>Telephone</th>
                                                    <th>Profession</th>
                                                    <th>Editer</th>
                                                    <th>Supprimer</th>
                                                </tr>
                                            </thead>
                                            <tbody id="enseignantsBody">
                                            <?php
                                                include "connect.php";
                                                // $sql = "SELECT e.id_etud, e.nom, e.prenom, e.num_tele, e.deja_abs
                                                //         FROM etudiant e";
                                                include "RecherchEnseignant.php";
                                            ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="addTeacherModal" tabindex="-1" role="dialog" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addTeacherModalLabel">Ajouter un enseignant</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="teacherForm" method="post" action="Enseignant.php">
                                        <div class="form-group">
                                            <label for="prenom">Prénom</label>
                                            <input type="text" class="form-control" name="prenomEnseigant" id="prenom" placeholder="Entrez le prénom">
                                            <label for="nom">Nom</label>
                                            <input type="text" class="form-control" name="nomEnseigant" id="nom" placeholder="Entrez le nom">
                                            <label for="telephone">Telephone</label>
                                            <input type="number" class="form-control" name="telEnseigant" id="telephone" placeholder="Entrez le telephone">                                            
                                            <label for="profession">Profession</label>
                                            <select class="form-control" name="professionEnseigant" id="profession"  required>
                                                <option value="" selected hidden>Select Profession</option>
                                                <option value="mathematiques" >Math</option>
                                                <option value="phisique chimie" >Physique chimie</option>
                                                <option value="science de la vie et de la terre" >SVT</option>
                                                <option value="philosophie" >philosophie</option>
                                                <option value="ANGLAIS" >ANGLAIS</option>
                                                <option value="histoire geografique" >Histoire Geografique</option>
                                                <option value="education islamique" >Education Islamique</option>
                                                <option value="la langue allemande" >la langue allemande</option>
                                                <option value="la langue espagnole" >la langue espagnole</option>
                                                <option value="la langue anglaise" >la langue anglaise</option>
                                                <option value="la langue chinoise" >la langue chinoise</option>
                                                <option value="C" >Langage  C</option>
                                                <option value="C++" >Langage  C++</option>
                                                <option value="PYTHON" >Langage  PYTHON</option>
                                                <option value="HTML" >Langage  HTML</option>
                                                <option value="CSS" >Langage  CSS</option>
                                                <option value="PHP" >Langage  PHP</option>
                                                <option value="JAVASCRIPT" >Langage  JAVASCRIPT</option>
                                                <option value="MYSQL" >Langage  MYSQL</option>
                                            </select>
                                        </div>
                                        <button type="button" class="btn btn-secondary" onclick="resetForm()">Réinitialiser</button>
                                        <button type="submit" name="EnregistrerEnseigant" class="btn btn-primary">Enregistrer</button>
                                        <?php
                                        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['EnregistrerEnseigant'])) {
                                            $prenom = $_POST['prenomEnseigant'];
                                            $nom = $_POST['nomEnseigant'];
                                            $tel = $_POST['telEnseigant'];
                                            $profession = $_POST['professionEnseigant'];
                                            
                                            if (!empty($prenom) || !empty($nom) || !empty($tel) || !empty($profession)) {
                                                // Query for searched elements
                                                include "connect.php";
                                                $sql = "SELECT id_matier FROM matier WHERE nom_matier = '$profession'";
                                                $result = mysqli_query($conn, $sql);

                                    
                                                if (mysqli_num_rows($result) > 0) {
                                                    $row = $result->fetch_assoc();
                                                    $idMetier = $row["id_matier"];
                                                }
                                                $sql1="INSERT INTO prof (nom, prenom, num_tele, id_matier) VALUES ('$nom','$prenom',$tel,$idMetier)";
                                                $result1 = mysqli_query($conn, $sql1);
                                               
                                                header("Location: Enseignant.php");                                           
                                            }
                                            mysqli_close($conn);
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