<?php
require_once("../../models/professeursModel.php");
require_once("../../connect_database/database.php");
if(isset($_POST['id'])){
    $id_prof = $_POST['id'];
    if(!Professeur::delete($id_prof)){
        die("Erreur suppression");
    }
}
?>
