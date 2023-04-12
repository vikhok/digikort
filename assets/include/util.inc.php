<?php 
    function clean($var){
        $var = strip_tags($var);
        $var = htmlentities($var);
        if (trim($var) == "")
            return false;
        else 
            return $var;
    }

    function cleanNumber($var){
        $var = clean($var);
        return filter_var($var, FILTER_SANITIZE_NUMBER_INT);
    }

    function validateInt($var){
        return filter_var($var, FILTER_VALIDATE_INT);
    }

    function cleanEmail($var){
        $var = clean($var);
        return filter_var($var, FILTER_SANITIZE_EMAIL);
    }

    function validateEmail($var){
        return filter_var($var, FILTER_VALIDATE_EMAIL);
    }
?>