<?php
// Verifier si la variable $_POST ou $_GET sont definit: contient des valeurs
// 
function isVariableSet($globalVariable,$variables){
    $isDefine = false;
    foreach($variables as $elem){
        if(isset($globalVariable[$elem])){
            $isDefine = true;
        }else {
            return false;
        }
    } 
    return $isDefine;
}

?>