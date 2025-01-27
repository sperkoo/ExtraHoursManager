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
            <h1 class="h3 mb-0 text-gray-800">Emploie du temps</h1>
        </div>

        
    

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="emploisTable" width="100%" cellspacing="0">
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
                                <tbody id="classesBody">
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

<?php include "scripts.php";
      include "footer.php"; 
?>