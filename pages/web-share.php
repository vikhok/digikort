<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Web share test</title>
    <style>

    </style>
  </head>
  <body>
    <h1>Sharing MDN</h1>

    <p>We love MDN, and want to share it as far as we can! Click the following button to share MDN's home page using your system's native share functionality. See the <a href="https://developer.mozilla.org/en-US/docs/Web/API/Navigator/share#Browser_compatibility">browsers this currently works on</a>.</p>

    <p><button>Del </button></p>

    <p class="result"></p>

    <script>
      let shareData = {
        title: 'Visittkort',
        text: 'Deling av visittkort',
        url: "<?= $_SERVER['REQUEST_URI'] ?>",
      }

      const btn = document.querySelector('button');
      const resultPara = document.querySelector('.result');

      btn.addEventListener('click', () => {
        navigator.share(shareData)
          .then(() =>
            resultPara.textContent = 'Visittkort delt'
          )
          .catch((e) =>
            resultPara.textContent = 'Error: ' + e
          )
      });
    </script>
  </body>
</html>