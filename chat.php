<?php
$token = '7244466599:AAF-EqRXMLwIxZY02AFtveJUq8uksNMql3w';
$botUsername = 'xmavechatbot';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $chat_id = $_POST['chat_id'];
    $message = $_POST['message'];

    $url = "https://api.telegram.org/bot$token/sendMessage";
    $params = [
        'chat_id' => $chat_id,
        'text' => $message,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if ($response === false) {
        die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
    }
    curl_close($ch);

   
    $host = 'localhost'; 
    $db = 'telegram_bot_db'; 
    $user = 'root'; 
    $pass = ''; 

    $connect = mysqli_connect($host, $user, $pass, $db);

    
    if (!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $stmt = $connect->prepare("INSERT INTO messages (chat_id, user_name, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $chat_id, $botUsername, $message);

    if ($stmt->execute()) {
        echo 'Message sent successfully and saved to database!';
    } else {
        echo 'Error: ' . $stmt->error;
    }

    $stmt->close();

    mysqli_close($connect);
}
?>
