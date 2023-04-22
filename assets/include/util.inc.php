<?php 
    function clean($var){
        $var = strip_tags($var);
        $var = htmlentities($var);
        if (trim($var) == "")
            return false;
        else 
            return $var;
    }
    function clean_allow_null($var){
        $var = strip_tags($var);
        $var = htmlentities($var);
        if (trim($var) == "")
            return null;
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

    // function mycrypt($input, $boolean) {
    //     $nordic = [197=>127, 198=>128, 216=>129, 229=>130, 230=>131, 248=>132];
    //     $chararray = mb_str_split($input);
    //     srand(4172385960 + count($chararray));
    //     $output = "";
    //     foreach ($chararray as $char) {
    //         $ord = mb_ord($char);
    //         $encrypted_ord = $ord;
    //         if (isset($nordic[$ord])) {
    //             $encrypted_ord = $nordic[$ord];
    //         }
    //         $modifier = $boolean ? 1 : -1;
    //         $encrypted_ord += $modifier * rand(1,100);
    //         if ($encrypted_ord < 32 || $encrypted_ord > 132) {
    //             $encrypted_ord -= $modifier * 101;
    //         }
    //         if (in_array($encrypted_ord, $nordic)) {
    //             $encrypted_ord = array_search($encrypted_ord, $nordic);
    //         }
    //         $output .= mb_chr($encrypted_ord);
    //     }
    //     return $output;
    // }




    // 1:
    function mycrypt($input, $boolean) {
        $nordic = [197=>127, 198=>128, 216=>129, 229=>130, 230=>131, 248=>132];
        $input = urldecode($input); // decode the input
        $chararray = mb_str_split($input);
        srand(4172385960 + count($chararray));
        $output = "";
        foreach ($chararray as $char) {
            $ord = mb_ord($char);
            $encrypted_ord = $ord;
            if (isset($nordic[$ord])) {
                $encrypted_ord = $nordic[$ord];
            }
            $modifier = $boolean ? 1 : -1;
            $encrypted_ord += $modifier * rand(1,100);
            if ($encrypted_ord < 32 || $encrypted_ord > 132) {
                $encrypted_ord -= $modifier * 101;
            }
            if (in_array($encrypted_ord, $nordic)) {
                $encrypted_ord = array_search($encrypted_ord, $nordic);
            }
            $output .= mb_chr($encrypted_ord);
        }
        return $output;
    }

    
    // 2:
    function stringEncrypt($string){
        return cryptString($string, "+");
    }
    function stringDecrypt($string){
        return cryptString($string, "-");
    }
    
    function cryptString($string, $operator){
        $encoding = "UTF-8";
        $encString = "";
        $chararray = mb_str_split($string);
        //Setter seed for random with a number + lenght of string to encrypt/decrypt for char shift use.
        srand(4217894+mb_strlen($string,$encoding));
        
        $nordicToCustNum = ["Æ"=>127, "Ø"=>128, "Å"=>129, "æ"=>130, "ø"=>131,"å"=>132];
        $custNumToNordic = [127=>198, 128=>216, 129=>197, 130=>230, 131=>248, 132=>229];
        
        foreach ($chararray as $char){
            
            $ordNumber = mb_ord($char, $encoding);
            //Om Norsk bokstav bytt til alternativt nummer
            if(array_key_exists($char, $nordicToCustNum)){
                $ordNumber = $nordicToCustNum[$char];
            }
            elseif ($ordNumber <= 31 || $ordNumber >= 126){
                $encString.= $char;
                continue;
            } 
            $shiftedChar=charShift($ordNumber, $operator);
            if (array_key_exists($shiftedChar, $custNumToNordic)){
                $shiftedChar = $custNumToNordic[$shiftedChar];
            }
            $encString.=mb_chr($shiftedChar, $encoding);   
        }
    return $encString;
    }
    
    function charShift($char, $operator){
        //Adderer eller subtraherer fra char ID. Eks: A (65) -1 = @ (64)
        //Bruker + om kryptering - om dekryptering. Fungerer pga "Seed" gir lik sekvens fra random
        if ($operator == "+"){
            $shifted = $char + rand(1, 101);
        }
        else{
            $shifted = $char - rand(1, 101);
        }
        //Holder verdiane innanfor ønsket range
        if ($shifted < 32)
            $shifted = $shifted + 101;
        elseif ($shifted > 132)
            $shifted = $shifted - 101;
        return $shifted;
    }
?>