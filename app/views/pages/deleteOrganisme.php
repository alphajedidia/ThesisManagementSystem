<?php
require_once("../../models/organismesModel.php");
require_once("../../connect_database/database.php");
if(isset($_POST['id'])){
    $id_org = $_POST['id'];
    if(!Organisme::delete($id_org)){
        die("Erreur suppression");
    }
}
?>