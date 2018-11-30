<?php
function isValidInput($input){
    $regex ='/^(?!\s*$)[a-zA-Z0-9 ._()\'\-:,\n@]+$/';
    if(preg_match_all($regex, $input)){
        return true;
    }else{
        return false;
    }
}

/**
 * $inputFields = array("name","city");
 * arrayIsValidInput($_POST, $inputFields); <-- will return a boolean
 */
function arrayIsValidInput($responseType, $formNames){
    foreach ($formNames as $key => $value){
        if(!isValidInput($responseType[$formNames[$key]])){
            return false;
        }
    }
    return true;
}

/**
 * $inputFields = array("name","city");
 * arrayExists($_POST,$inputFields); <-- will return a boolean
*/
function arrayExists($responseType, $formNames){
    foreach ($formNames as $key => $value){
       if(!isset($responseType[$formNames[$key]]) ||  empty($responseType[$formNames[$key]])){
           return false;
       }
    }
    return true;
}


/**
 * used for seeing if the size input is valid,
 */
function isValidSizeInput($input){
    $sizeArray = array('small', 'medium', 'large','xl');
    if(in_array(strtolower($input),$sizeArray)){
        return true;
    }else{
        return false;
    }
}


function sanitizeInput($input){
    $regex = '/[<>"=\/\[\]!#$%^&*{}|()+`~\;]/';
    return preg_replace($regex,"",$input);
}
?>