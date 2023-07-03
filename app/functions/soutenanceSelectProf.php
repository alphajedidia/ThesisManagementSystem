<?php

function soutenanceSelectProf($profTable){
    foreach($profTable as $prof){
        echo "<option value=\"".$prof['Identifiant']."\">".$prof['Civilite']." ".$prof['Nom']." ".$prof['Prenom']."</option>";
    }
}

?>