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