
function confirmation(message) {
    document.addEventListener('submit', function(event) {
        var confirmation_msg = confirm(message);
        if(!confirmation_msg) {
            event.preventDefault();
            this.location.reload();
        }
    });
}

function showAlert(message_alert) {
    alert(message_alert);
}
