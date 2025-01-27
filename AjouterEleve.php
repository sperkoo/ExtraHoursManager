<!-- <?php
                        // include "connect.php";
                        // if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitEnregistrerEleve'])) {
                        //     $id_eleve = $_POST['IdEleve'];
                        //     $prenom= $_POST['prenom'];
                        //     $nom = $_POST['nom'];
                        //     $tel = $_POST['telephone'];
                        //     $sql2 = "INSERT INTO etudiant (id_etud,nom, prenom, num_tel,deja_abs) VALUES('$id_eleve','$nom', '$prenom', '$tel','False')";
                        //     $result = mysqli_query($conn, $sql2) or die("Query Failed!");
                        //     header("location: Edutiant.php");
                        // }


                        error_reporting(E_ALL);
                        ini_set('display_errors', 1);
                        include "connect.php";
                        
                        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['EnregistrerEnseigant'])) {
                            $prenom = $_POST['prenomEnseigant'];
                            $nom = $_POST['nomEnseigant'];
                            $tel = $_POST['telEnseigant'];
                            $profession = $_POST['professionEnseigant'];
                        
                            // Sanitize user input to prevent SQL injection
                            $profession = mysqli_real_escape_string($conn, $profession);
                        
                            // Prepare and execute the query using prepared statement to avoid SQL injection
                            $sql = "SELECT id_matier FROM matier WHERE nom_matier = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("s", $profession);
                            $stmt->execute();
                            $result = $stmt->get_result();
                        
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $idMetier = $row["id_matier"];
                        
                                // Insert the data into the database
                                
                                $sql2 = "INSERT INTO prof (nom, prenom, num_tele, id_matier) VALUES (?, ?, ?, ?)";
                                $stmt2 = $conn->prepare($sql2);
                                $stmt2->bind_param("ssii", $nom, $prenom, $tel, $idMetier);
                                echo $sql2;
                                $stmt2->execute();
                        
                                // Check if the query was successful
                                if ($stmt2->affected_rows > 0) {
                                    header("location: Enseignant.php");
                                    exit();
                                } else {
                                    echo "Failed to insert data into the database.". $stmt2->error;
                                }
                            } else {
                                echo "Profession not found in the database.";
                            }
                        }
                        
                        ?>
                        
