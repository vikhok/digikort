<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/footer.inc.php");

?>
  <link rel="stylesheet" href="../assets/styles/styles.css">
</head>
<?php banner(false) ?>
<!DOCTYPE html>
<html lang="no">
  <head>
    <title>Rediger Bedrift</title>
  </head>
  <body>
    <div class="header-rediger-bedrift">
      <h1>Rediger Bedrift</h1>
    </div>
    <div class="rediger-bilde-rediger-bedrift">
      <img class="bilde-rediger-bedrift" src="bedriftsbilde.jpg" alt="Bedriftsbilde">
    </div>
    <div class="rediger-navn-rediger-bedrift">
      <input class="navn-input-rediger-bedrift" type="text" placeholder="Navn på bedriften" value="Bedrift AS">
    </div>
    <div class="rediger-beskrivelse-rediger-bedrift">
      <textarea class="beskrivelse-input-rediger-bedrift" placeholder="Beskrivelse av bedriften">Dette er en kort beskrivelse av Bedrift AS</textarea>
    </div>
    <div class="rediger-url-rediger-bedrift">
      <input class="url-input-rediger-bedrift" type="text" placeholder="Nettsted URL" value="www.bedrift.no">
      <input class="url-input-rediger-bedrift" type="text" placeholder="Ansatte URL" value="www.bedrift.no/ansatte">
    </div>
    <div class="rediger-adresse-rediger-bedrift">
      <input class="adresse-input-rediger-bedrift" type="text" placeholder="Adresse" value="Gateadresse 1, 0001 Oslo">
    </div>
    <button class="lagre-knapp-rediger-bedrift">Lagre</button>
  </body>
</html>

  <?php footer() ?>

