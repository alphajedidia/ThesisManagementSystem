<?php

function soutenanceSelectedOrg($orgTable,$idOrg){
    foreach($orgTable as $org){
        $selected = "";
        if($idOrg === $org['Identifiant']){
            $selected = "selected";
        }
        echo "<option value=\"".$org['Identifiant']."\" ".$selected.">".$org['Designation'].", ".$org['Lieu']."</option>\n";
    }
}

?>