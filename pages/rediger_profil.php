<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="rediger_profil_styles.css">
    <title>Rediger profil</title>
</head>
<body>


<div class="rediger_profil">
    <h1>Rediger profilen din</h1>

    <form action="rediger_profil.php" method="POST">

        <label for="full_name">Fullt navn:</label>
        <input type="text" id="full_name" name="full_name"><br><br>

        <label for="stillingstittel">Stillingstittel:</label>
        <input type="text" id="stillingstittel" name="stillingstittel"><br><br>

        <label for="email">E-post:</label>
        <input type="email" id="email" name="email"><br><br>

        <label for="telefon">Telefon:</label>
        <input type="text" id="telefon" name="telefon"><br><br>

        <label for="linkedin">LinkedIn:</label>
        <input type="url" id="linkedin" name="linkedin" placeholder="https://linkedin.com/"><br><br>

        <label for="github">Github:</label>
        <input type="url" id="github" name="github" placeholder="https://github.com/"><br><br>

        <label for="instagram">Instagram:</label>
        <input type="url" id="instagram" name="instagram" placeholder="https://www.instagram.com/"><br><br>

        <button type="submit">Oppdater profil</button>
    </form>
</div>

</body>
</html>