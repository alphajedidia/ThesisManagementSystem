<?php

function soutenanceSelectOrg($orgTable){
    foreach($orgTable as $org){
        echo "<option value=\"".$org['Identifiant']."\">".$org['Designation'].", ".$org['Lieu']."</option>";
    }
}

?>