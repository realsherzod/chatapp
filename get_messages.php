<?php
$host = 'localhost'; 
$db = 'telegram_bot_db'; 
$user = 'root'; 
$pass = ''; 

$connect = mysqli_connect($host, $user, $pass, $db);

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

$chat_id = isset($_GET['chat_id']) ? $_GET['chat_id'] : '';

$query = "SELECT * FROM messages WHERE chat_id = ?";
$stmt = $connect->prepare($query);
$stmt->bind_param("i", $chat_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="message">';
        echo '<strong>' . htmlspecialchars($row['user_name']) . ':</strong> ' . htmlspecialchars($row['message']);
        echo '</div>';
    }
} else {
    echo '<p>No messages found.</p>';
}

$stmt->close();
mysqli_close($connect);
?>
