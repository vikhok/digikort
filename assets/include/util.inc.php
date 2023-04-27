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

    function cleanEmail($var){
        $var = clean($var);
        return filter_var($var, FILTER_SANITIZE_EMAIL);
    }

    function validateEmail($var){
        return filter_var($var, FILTER_VALIDATE_EMAIL);
    }

    // function cleanNumber($var){
    //     $var = clean($var);
    //     return filter_var($var, FILTER_SANITIZE_NUMBER_INT);
    // }

    // function validateInt($var){
    //     return filter_var($var, FILTER_VALIDATE_INT);
    // }

    // Encryption / decryption:
    function digicrypt($data, $boolean) {
        $key = "qkwjdiw239&&jdafweihbrhnan&^%3ggdnawhd4njshjwuuO";
        $encryption_key = base64_decode($key);
        if($boolean) {
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length("aes-256-cbc"));
            $encrypted = openssl_encrypt($data, "aes-256-cbc", $encryption_key, 0, $iv);
            return base64_encode($encrypted . "::" . $iv);
        } else {
            list($encrypted_data, $iv) = array_pad(explode("::", base64_decode($data), 2), 2, null);
            return openssl_decrypt($encrypted_data, "aes-256-cbc", $encryption_key, 0, $iv);
        }
    }

?>