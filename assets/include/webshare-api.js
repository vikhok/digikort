const shareLinkButton = document.getElementById('share-link');

shareLinkButton.addEventListener('click', (event) => {
  event.preventDefault(); // prevent the link from being followed
  if (navigator.share) { // check if Web Share API is supported
    navigator.share({
        title: 'Visittkort',
        text: 'Deling av visittkort',
        url: "www.google.no",
    })
      .then(() => console.log('Deling fullført'))
      .catch((error) => console.error('Et problem oppsto:', error));
  } else {
    console.error('Deling støttes ikke');
  }
});