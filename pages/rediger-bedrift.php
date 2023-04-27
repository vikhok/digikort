<?php
require_once("../assets/include/header.inc.php");
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
    <div class="header-rediger-bedrift">
      <h1>Rediger Bedrift</h1>
    </div>
    <div class="Bedrift-siden">
      <form method="POST" action="rediger-bedrift.php" enctype="multipart/form-data">
        <div class="Bedrift-bilde-container">
          <div class="bedrift_bilde_styling">
            <label class="bedrift-label" for="upload-file">Endre bakgrunnsbilde for bedrift:</label>
            <input type="file" id="bedrift-bilde" name="upload-file">
          </div>
          <br>
        </div>
        <div class="addcompany_structure" id="fields">
          <section class="company_name" for="company_name">
            <label for="name">Navn på bedriften:</label>
            <input type="text" id="company_name" name="company_name" placeholder="Egde AS" size="50" required>
          </section>
          <br>
          <section class="company_description" id="freetext">
            <label for="information">Beskrivelse av bedriften:</label>
            <textarea name="freetext" type="text" cols="5" rows="10" name="description" placeholder="Vi er en teknologibedrift" wrap="physical" required></textarea>
          </section>
          <section class="company_url" for="web_url">
            <label for="url">Nettsted URL:</label>
            <input type="text" id="web_url" name="web_url" placeholder="www.egde.no" size="50" required>
          </section>
          <br>
          <section class="ansatte_url" for="employee_url">
            <label for="url">Ansatte URL:</label>
            <input type="text" id="employee_url" name="employee_url" placeholder="egde.no/kontakt" size="50" required>
          </section>
          <br>
          <section class="adress" for="adress">
            <label for="name">Adresse:</label>
            <input type="text" id="adress" name="adress" placeholder="Terje Løvås vei 1, 4879 Grimstad" size="50" required>
          </section>
          <br>
          <section class="addcompany_submit">    
            <button type="submit" name="submit">Lagre</button>
          </section>
        </div>
      </form>
    </div>
    <script src="../assets/scripts/rediger-bedrift.js"></script>
  </body>
</html>
