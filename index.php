<?php include "header.php";
      include "navbar.php"; 
?>
 
 <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

            <?php include "navbarTop.php";?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Tableau De Bord</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <?php include "connect.php";
                            $sql="SELECT COUNT(*) AS total_eleves
                            FROM etudiant;";
                            $result=mysqli_query($conn,$sql);
                            if ($result) {
                                $row = mysqli_fetch_assoc($result);
                                $totalStudents = $row['total_eleves'];                    
                            }
                            mysqli_close($conn);

                        ?>
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total des élèves enregistrés</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalStudents ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        

                        <!-- Pending Requests Card Example -->
                        <?php include "connect.php";
                            $sql="SELECT COUNT(id_group) AS total_groupes
                            FROM groupe;";
                            $result=mysqli_query($conn,$sql);
                            if ($result) {
                                $row = mysqli_fetch_assoc($result);
                                $totalStudents = $row['total_groupes'];                    
                            }
                            mysqli_close($conn);

                        ?>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                               Groupes au Total</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalStudents?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-book fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    

                          

                </div>
                <!-- /.container-fluid -->
                <!-- Table of Last 10 Students -->


                <div class="container-fluid mb-4">
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <button class="btn btn-primary" onclick="showLastTenStudents()">10 Derniers Élèves</button>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary" onclick="showAvailableRooms()">Emploie du temps</button>
                        </div>
                    </div>
                </div>

                <div id="lastTenStudents" class="container-fluid">
                    <div class="container-fluid">

                        <h1 class="h3 mb-2 text-gray-800">Derniers Étudiants</h1>
                        <p class="mb-4">Liste des 10 derniers étudiants enregistrés.</p>
                    
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Étudiants</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Id_Etudiant</th>
                                                <th>Prénom</th>
                                                <th>Nom</th>
                                                <th>Mobile</th>
                                                <th>Déja Absent</th>
                                                <th>Nombre Seance restante</th>
                                                <th>Groupe</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            include "connect.php";
                                            // $sql = "SELECT e.id_etud, e.nom, e.prenom, e.num_tele, e.deja_abs
                                            //         FROM etudiant e";
                                            $sql = "SELECT e.id_etud, e.nom, e.prenom, e.num_tele, e.deja_abs, a.id_group, a.nbr_sc_payee
                                            FROM etudiant e
                                            LEFT JOIN appartenir a ON e.id_etud = a.id_etud
                                            ORDER BY e.id_etud DESC
                                            LIMIT 10";
                                            $result = mysqli_query($conn, $sql);

                                            if (mysqli_num_rows($result) > 0) {
                                                while($row = mysqli_fetch_assoc($result)) {
                                                    echo "<tr>";
                                                    echo "<td>".$row["id_etud"]."</td>";
                                                    echo "<td>".$row["prenom"]."</td>";
                                                    echo "<td>".$row["nom"]."</td>";
                                                    echo "<td>".$row["num_tele"]."</td>";
                                                    echo "<td>".$row["deja_abs"]."</td>";
                                                    echo "<td>".$row["nbr_sc_payee"]."</td>";
                                                    echo "<td>".$row["id_group"]."</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='7'>No records found.</td></tr>";
                                            }
                                            mysqli_close($conn);
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                </div>
            
            
                <!-- Section for Available Rooms -->
                <div id="availableRooms" class="container-fluid" style="display: none;">
                    <h1 class="h3 mb-2 text-gray-800">Emploie du temps</h1>
                    
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Emploie</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                        <tr>
                                            <th>*</th>
                                            <th>TEMPS</th>
                                            <th>C1</th>
                                            <th>C2</th>
                                            <th>C3</th>
                                            <th>C4</th>
                                            <th>C5</th>
                                            <th>C6</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            include "connect.php";
                                            $daysOfWeek = ['lundi', 'lundi', 'Mardi', 'Mardi', 'Mercredi', 'Mercredi', 'Jeudi', 'Jeudi', 'Vendredi', 'Vendredi', 'Samedi', 'Samedi'];
                                            $sql = "SELECT id_group from groupe where id_salle = ? and id_date = ?";
                                            $stmt = $conn->prepare($sql);

                                            for ($i = 0; $i < 12; $i++) {
                                                $iddate = 101 + $i;
                                                ?>
                                                <tr>
                                                    <td><?= $daysOfWeek[$i] ?></td>
                                                    <td><?= $i % 2 == 0 ? '7 TO 9' : '9 TO 11' ?></td>
                                                    <?php
                                                    for ($j = 1; $j <= 6; $j++) {
                                                        $stmt->bind_param("ii", $j, $iddate);
                                                        $stmt->execute();
                                                        $result = $stmt->get_result();
                                                        ?>
                                                        <td>
                                                            <?php while ($row = $result->fetch_assoc()) {
                                                                echo "NUMERO GRP: " . $row["id_group"] . "<br>";
                                                            } ?>
                                                        </td>
                                                        <?php
                                                        $result->free_result();
                                                    }
                                                    ?>
                                                </tr>
                                                <?php
                                            }
                                            $stmt->close();
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                </div>
            
                </div>
            

<!-- End of Table of Last 10 Students -->

</body>


            </div>
            <!-- End of Main Content -->


<?php include "scripts.php";
      include "footer.php"; 
?>
 