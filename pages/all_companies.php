<?php
    require_once("../assets/include/db.inc.php");
    
    if($result = get_all_companies()) {
        echo json_encode($result);
    } else {
        echo "Something went wrong.";
    }
?>