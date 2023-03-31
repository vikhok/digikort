<?php
    function createQR($user_id, $url) {
        include("phpqrcode/qrlib.php");

        // Declare file path and name:
        $dir = "../profiles/" . md5("user." . $user_id);
        $file = "qr.png";
        $path = $dir . "/" . $file;
        
        if(!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        // Generate QR-code:
        QRcode::png($url, $path);
    }
?>