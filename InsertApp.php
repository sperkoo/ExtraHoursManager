<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['AjoutEtudiant'])) {
    // Insertion logic here
    include "connect.php";
    
    $id_etud = $_POST['idEtudiant'];
    $id_group = $_POST['GroupeID'];
    $nbr_sc_payee = $_POST['NbrSeanceEtudiant'];

    
    $sql = "INSERT INTO appartenir (id_etud, id_group, nbr_sc_payee) VALUES (?, ?, ?)";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "iii", $id_etud, $id_group, $nbr_sc_payee);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: Groupe.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    
    mysqli_close($conn);
    }
?>