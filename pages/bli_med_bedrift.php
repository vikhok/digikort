<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/styles.css">
    <title>Bli med i en bedrift</title>
</head>
<body>

    <div class="bli_med_bedrift">

<form class="bli_med_bedrift_form" action="bli_med_bedrift.php" method="POST">

    <div class="h1_bli_med_bedrift">
        <h1>Du er ikke oppført i en bedrift.</h1>
    </div>
    <div class="h1_bli_med_bedrift_2">
        <h1>Fyll inn navnet på bedriften eller opprett en ny bedrift.</h1>
    </div>

    <div class="bedrift_navn">
        <label for="bedrift_navn">Bedriftsnavn:</label>
        <input type="text" id="bedrift_navn" name="bedrift_navn"><br><br>
    </div>

    <div class="bli_med_bedrift_knapp">    
        <button type="submit">Bli med</button>
    </div>

    <div class="opprett_ny_bedrift_knapp">
        <a class="a_ny_bedrift" href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">Opprett bedrift</a>
    </div>

    </div>

</form>

</body>
</html>