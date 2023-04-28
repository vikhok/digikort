<?php
require_once("../assets/include/header.inc.php");
require_once("../assets/include/db.inc.php");

session_start();
$_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];
$user_id = $_SESSION["user"]["user_id"];
$company_id = $_REQUEST["company_id"];

  if($company_info = get_company_info($company_id)) {
      $company_name = $company_info->company_name;
      $descriptions = $company_info->descriptions;
      $web_url = $company_info->web_url;
      $company_address = $company_info->company_address;
  } else {
      $status = "<h4><span style='color:red'>
      Noe gikk galt, fant ikke bedrift i systemet.
      </span></h4>";
  }

  if(isset($_REQUEST["submit"])) {
    $company_name = ($_REQUEST["company_name"]);
    $descriptions = ($_REQUEST["descriptions"]);
    $web_url = ($_REQUEST["web_url"]);
    $company_address = ($_REQUEST["company_address"]);

    $updated_company = [$company_name, $descriptions, $web_url, $company_address];

    if($company_name && $descriptions && $web_url && $company_address) {
      if(edit_company($company_name, $descriptions, $web_url, $company_address)) {
        $status = "<h4><span style='color:green'>
                Profil ble endret.
                </span></h4>";
            } else {
                $status = "<h4><span style='color:red'>
                Noe gikk galt, endringer ble ikke foretatt.
                </span></h4>";
            }
        } else {
            $status = "<h4><span style='color:red'>
            Noe gikk galt, endringer ble ikke foretatt i det større bildet.
            </span></h4>";
        }
     }

  $company_info = get_company_info($company_id);
  $company_name = null;
  $descriptions = null;
  $web_url = null;
  $company_address = null;

  if($company_info) {
    $company_name = $company_info->company_name ?? '';
    $descriptions = $company_info->descriptions ?? '';
    $web_url = $company_info->web_url ?? '';
    $company_address = $company_info->company_address ?? '';
  } else {
    // Endringer behøvs
    $failed = "<h4><span style='color:red'>
    Noe gikk galt. kjipt.
    </span></h4>";
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

          <div class="redpro_input_text" for="employee_url">
            <label class="rediger-bedrift-label" for="url">Ansatte URL</label><br>
            <input type="text" id="employee_url" name="employee_url" placeholder="bedrift.no/kontakt" required><br></br>
          </div>

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
