function showMessages(chatId) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_messages.php?chat_id=' + chatId, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById('message-container').innerHTML = xhr.responseText;
            document.getElementById('chatId').value = chatId;
        } else {
            alert('Failed to fetch messages.');
        }
    };
    xhr.send();
}

var firstUser = document.querySelector('.user-list-item');
if (firstUser) {
    showMessages(firstUser.getAttribute('onclick').match(/\d+/)[0]);
}

document.getElementById('messageForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var formData = new FormData(this);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'chat.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById('messageInput').value = '';
            showMessages(document.getElementById('chatId').value);
        } else {
            alert('Failed to send message.');
        }
    };
    xhr.send(formData);
});