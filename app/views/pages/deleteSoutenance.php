<?php
require_once("../../models/soutenirModel.php");
require_once("../../connect_database/database.php");
if(isset($_POST['id'])){
    $matricule =$_POST['id'];
    
    if(!Soutenir::delete($matricule)){
        die("Erreur suppression");
    }
}
?>