<?php
require_once("../../models/etudiantsModel.php");
require_once("../../connect_database/database.php");
if(isset($_POST['id'])){
    $matricule = $_POST['id'];
    if(!Etudiant::delete($matricule)){
        die("Erreur suppression");
    }
}
?>
