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

    <form action="rediger_profil.php" method="POST">

        <div class="profil_bilde">    
        <label for="profile-picture">Endre profilbilde</label>
        <img class="vis_profil_bilde" src="plassholder for senere bilde" alt="Profil bilde">
        <input type="file" id="profil_bilde" name="profil_bilde" accept="image/*">
        </div>

        <label for="full_name">Fullt navn</label>
        <input type="text" id="full_name" name="full_name" placeholder="Navnet ditt"><br><br>

        <label for="stillingstittel">Stillingstittel</label>
        <input type="text" id="stillingstittel" name="stillingstittel" placeholder="Din stillingstittel"><br><br>

        <label for="email">E-post</label>
        <input type="email" id="email" name="email" placeholder="eksempel@epost.no" ><br><br>

        <label for="telefon">Telefon</label>
        <input type="text" id="telefon" name="telefon" placeholder="+47 12345678" ><br><br>

        <div class="rediger_some">

            <div class="column_rediger_profil">
            <label for="linkedin">LinkedIn</label>
            <input type="url" id="linkedin" name="linkedin" placeholder="linkedin.com/"><br><br>
            </div>

            <div class="column_rediger_profil">
            <label for="github">Github</label>
            <input type="url" id="github" name="github" placeholder="github.com/"><br><br>
            </div>

            <div class="column_rediger_profil">
            <label for="instagram">Instagram</label>
            <input type="url" id="instagram" name="instagram" placeholder="www.instagram.com/"><br><br>
            </div>
        
        </div>

    <button type="submit">Oppdater profil</button>

    </form>
</div>
</body>
</html>