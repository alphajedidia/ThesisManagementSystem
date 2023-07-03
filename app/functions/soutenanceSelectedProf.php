<?php

function soutenanceSelectedProf($profTable,$idProf){
    
    foreach($profTable as $prof){
        $selected = "";
        if($prof['Identifiant'] === $idProf){
            $selected = 'selected';
        }
        echo "<option value=\"".$prof['Identifiant']."\" ".$selected.">".$prof['Civilite']." ".$prof['Nom']." ".$prof['Prenom']."</option>\n";
    }
}

?>