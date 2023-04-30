<?php
require_once("../assets/include/header.inc.php");
require_once("../assets/include/db.inc.php");
require_once("../assets/include/util.inc.php");
require_once("../assets/include/phpmailer.inc.php");

session_start();
$_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];
$company_id = $_REQUEST["company_id"];

if($company = get_company_info($company_id)) {
  $company_name = $company->company_name ?? null;
  $descriptions = $company->descriptions ?? null;
  $web_url = $company->web_url ?? null;
  $company_address = $company->company_address ?? null;
  

  // Array as reference of current information state:
  $current_company = [$company_name, $descriptions, $web_url, $company_address];

  // Oppdaterer tabellen med nye endringer gjort av bruker.
  if(isset($_REQUEST["submit"])) {
      $company_name = ucfirst(strtolower(clean($_REQUEST["company_name"])));
      $descriptions = ucfirst(strtolower(clean($_REQUEST["descriptions"])));
      $web_url = clean_allow_null($_REQUEST["web_url"]);
      $company_address = strtolower($_REQUEST["company_address"]);

      // Array to compare against the current information state:
      $current_company = [$company_name, $descriptions, $web_url, $company_address];

      // Check that all variables are accepted:
      if(!in_array(false, $current_company, true)) {
          // Check if changes were made to the profile or profile picture:
          if($current_company != $current_company || is_uploaded_file($_FILES["upload-file"]["tmp_name"])) {
              $error = array(); // Setter opp array som samler inn feilmeldinger
              if($_FILES["upload-file"]["tmp_name"] != null) {
                  $file_type = $_FILES["upload-file"]["type"]; // Type
                  $file_size = $_FILES["upload-file"]["size"]; // Bytes
                  $file_size = round($file_size / 1048576, 2); // MB
                  $acc_file_types = array("jpg" => "image/jpeg", "png" => "image/png"); // Tillatt filtyper
                  $max_file_size = 2; // MB
      
                  $folder = md5("user." . $user_id);
                  $dir = $_SERVER["DOCUMENT_ROOT"] . "/digikort/Companies" . $folder . "/"; // Definerer mappe
                  if(!file_exists($dir)) { // Om mappen ikke eksisterer
                      if(!mkdir($dir, 0777, true)) { // Lager mappe og gir feilmeding vis det ikke går
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
                      if(file_exists($dir . "profile_picture.jpg")) {
                          unlink($dir . "profile_picture.jpg");
                      }
                      if(file_exists($dir . "profile_picture.png")) {
                          unlink($dir . "profile_picture.png");
                      }
                      $suffix = array_search($file_type, $acc_file_types);
                      $filename = "profile_picture." . $suffix;
                      
                      $uploaded_file = move_uploaded_file($_FILES["upload-file"]["tmp_name"], $dir . $filename); // Prøver å laste opp fil
                      if(!$uploaded_file) { // Hvis den feiler
                          $error[] = "Filen kunne ikke lastes opp.";
                      }
                  }
              }
            }
          }
        }
      }

?>
<!DOCTYPE html>
<html lang="no">
  <head>
    <meta charset="UTF-8">
    <title>Rediger Bedrift</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/styles.css">
  </head>
  <body>
    <?php banner(false); ?>
    <div class="rediger_profil">
        <form class="redpro_form" method="POST" action="rediger-bedrift.php" enctype="multipart/form-data">
                
          <div class="profil_bilde"> 
            <label class="rediger-bedrift-label" for="upload-file">Endre bakgrunnsbilde for bedrift</label>
            <input type="file" id="bedrift-bilde" name="upload-file">
          </div>

          <div class="redpro_input_text" id="fields">
            <label class="rediger-bedrift-label" for="name">Navn på bedriften</label><br>
            <input type="text" id="company_name" name="company_name" placeholder="Navnet på bedriften din" value="<?=$company_name?>" required><br></br>
          </div>

          <div class="redpro_input_text" id="freetext">
            <label class="rediger-bedrift-label" for="information">Beskrivelse av bedriften</label>
            <input name="textarea" type="text" name="description" placeholder="Informasjon om bedriften din..." wrap="physical" value="<?=$descriptions?>" required></input><br></br>
          </div>

          <div class="redpro_input_text" for="web_url">
            <label class="rediger-bedrift-label" for="url">Nettstedets URL</label><br>
            <input type="text" id="web_url" name="web_url" placeholder="bedrift.no" value="<?=$web_url?>" required><br></br>
          </div>

          <!-- <div class="redpro_input_text" for="employee_url">
            <label class="rediger-bedrift-label" for="url">Ansatte URL</label><br>
            <input type="text" id="employee_url" name="employee_url" placeholder="bedrift.no/kontakt" required><br></br>
          </div> -->

          <div class="redpro_input_text" for="address">
            <label class="rediger-bedrift-label" for="name">Addresse</label><br><br>
            <input type="text" id="address" name="address" placeholder="Bedriftens addresse" value="<?=$company_address?>" required><br></br>
          </div>

          <div class="rediger-bedrift_submit">
            <button type="submit" name="submit">Lagre</button>
          </div>
  
          </form>
      </div>
  </body>
</html>
