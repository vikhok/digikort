<?php


    function generate_vcard($last_name, $first_name, $phone, $email){
        $vcard = "BEGIN:VCARD\r\n";
        $vcard .= "VERSION:3.0\r\n";
        $vcard .= "N:$last_name;$first_name;;;\r\n";
        $vcard .= "FN:$first_name $last_name\r\n";
        $vcard .= "TEL;TYPE=CELL:$phone\r\n";
        // $vcard .= "PHOTO;TYPE=JPEG;ENCODING=BASE64:" . base64_encode(file_get_contents($dir));
        $vcard .= "EMAIL:$email\r\n";
        $vcard .= "END:VCARD\r\n";

        // Genererer fil basert på user-input
        header('Content-type: text/x-vcard');
        header('Content-Disposition: attachment; filename="contact.vcf"');

        echo $vcard;
    }
?>