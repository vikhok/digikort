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

    function rrmdir($dir) {
        if(is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if($object != "." && $object != "..") {
                    if(filetype($dir."/".$object) == "dir") 
                        rrmdir($dir."/".$object); 
                    else 
                        unlink($dir."/".$object);
                }
            }
            reset($objects);
            if(rmdir($dir)) 
                return true;
            else 
                return false;
        }
    }

    function upload_image($id, $option) {
        $error = array(); // Array to store potential errors
        $file_type = $_FILES["upload-file"]["type"]; // File type
        $file_size = $_FILES["upload-file"]["size"]; // Bytes
        $file_size = round($file_size / 1048576, 2); // MB
        $acc_file_types = array("jpg" => "image/jpeg", "png" => "image/png"); // Accepted file types
        $max_file_size = 2; // MB

        if($option == "user") {
            $folder = md5("user." . $id);
            $dir = $_SERVER["DOCUMENT_ROOT"] . "/digikort/profiles/" . $folder . "/";
        } elseif($option == "company") {
            $folder = md5("company." . $id);
            $dir = $_SERVER["DOCUMENT_ROOT"] . "/digikort/companies/" . $folder . "/";
        } else return false;

        if(!file_exists($dir)) {
            if(!mkdir($dir, 0777, true)) {
                die("Kunne ikke opprette mappen: " . $dir);
            }
        }

        if(!in_array($file_type, $acc_file_types)) {
            $acc_types = implode(", ", array_keys($acc_file_types));
            $error[] = "Ugyldig filtype, kun $acc_types er tillat.";
        }
        if($file_size > $max_file_size) {
            $error[] = "Filen du valgte er på $file_size MB og overgår grensen på 2 MB.";
        }

        if(empty($error)) {
            if(file_exists($dir . "picture.jpg")) {
                unlink($dir . "picture.jpg");
            }
            if(file_exists($dir . "picture.png")) {
                unlink($dir . "picture.png");
            }
            $suffix = array_search($file_type, $acc_file_types);
            $filename = "picture." . $suffix;
            
            $uploaded_file = move_uploaded_file($_FILES["upload-file"]["tmp_name"], $dir . $filename);
            if(!$uploaded_file) {
                $error[] = "Filen kunne ikke lastes opp.";
            }
        }
        return $error;
    }

    function show_alert($message) {
        echo '<script language="javascript" src="/javascript/messages.js"></script>';
        echo '<script>';
        echo 'window.onload = function() { showAlert("'. $message .'"); }';
        echo '</script>';
    }

?>