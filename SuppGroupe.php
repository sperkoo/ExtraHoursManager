<?php
    if(isset($_POST['delete_btnGroupe'])){
        $id_group = $_POST['delete_idGroupe'];
        include "connect.php";
        $query = "DELETE FROM groupe WHERE id_group = '$id_group';";
        $query_run = mysqli_query($conn, $query);
    
        if($query_run)
        {
            $_SESSION['status'] = "Your Data is Deleted";
            $_SESSION['status_code'] = "success";
            header('Location: Groupe.php'); 
        }
        else
        {
            $_SESSION['status'] = "Your Data is NOT DELETED";       
            $_SESSION['status_code'] = "error";
            header('Location: Groupe.php'); 
        }    
}
?>