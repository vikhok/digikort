<?php

if($user_id = false) {
    // Define and display profile picture:
    $folder = md5("user." . $user_id);
    $dir = "../profiles/" . $folder . "/profile_picture.png";
    if(!file_exists($dir)) {
        $dir = "../profiles/" . $folder . "/profile_picture.jpg";
        if(!file_exists($dir)){
        $dir = "../profiles/stockprofile/profile_picture.png";
        }
    }
}

    function generate_vcard($last_name, $first_name, $name, $phone, $email, $dir){
        $vcard = "BEGIN:VCARD\n";
        $vcard .= "VERSION:3.0\n";
        $vcard .= "N:$last_name;$first_name;;;\n";
        $vcard .= "FN:$name\n";
        $vcard .= "TEL;TYPE=CELL:$phone\n";
        $vcard .= "EMAIL;TYPE=INTERNET:$email\n";
        $vcard .= "PHOTO;ENCODING=b;TYPE=JPEG;VALUE=DATA:" . $dir . "\n";
        $vcard .= "END:VCARD\n";

        // Genererer fil basert på user-input
        header('Content-type: text/x-vcard');
        header('Content-Disposition: attachment; filename="contact.vcf"');
        echo $vcard;
    }
        
?>