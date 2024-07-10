<?php
$token = '7244466599:AAF-EqRXMLwIxZY02AFtveJUq8uksNMql3w';
$botUsername = 'xmavechatbot';


$host = 'localhost'; 
$db = 'telegram_bot_db'; 
$user = 'root'; 
$pass = ''; 

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$update = json_decode(file_get_contents('php://input'), true);

if (isset($update['message'])) {
    $message = $update['message'];

    $chat_id = $message['chat']['id'];
    $username = isset($message['chat']['username']) ? $message['chat']['username'] : '';
    $text = $message['text'];

    if ($text === '/start') {
        $responseText = 'Hello! Welcome to your Telegram bot.';
    } else {
        $responseText = 'Message received: ' . $text;
    }

    $url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=" . urlencode($responseText);
    file_get_contents($url);

    $stmt = $conn->prepare("INSERT INTO messages (chat_id, user_name, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $chat_id, $username, $text);

    if ($stmt->execute()) {
        echo "Message saved successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

$conn->close();
?>
