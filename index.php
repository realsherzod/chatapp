<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User List and Messages</title>
    <link rel="stylesheet" href="./style.css">
</head>

<body>

    <div class="container">
        <div class="sidebar">
            <h2>User List</h2>
            <ul class="user-list">
                <?php
                $host = 'localhost';
                $db = 'telegram_bot_db';
                $user = 'root';
                $pass = '';

                $connect = mysqli_connect($host, $user, $pass, $db);

                if (!$connect) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $query = "SELECT DISTINCT chat_id, user_name FROM messages";
                $result = mysqli_query($connect, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<li class="user-list-item" onclick="showMessages(' . $row['chat_id'] . ')">';
                        echo $row['user_name'];
                        echo '</li>';
                    }
                } else {
                    echo '<li>No users found.</li>';
                }

                mysqli_close($connect);
                ?>
            </ul>
        </div>

        <div class="main-content">
            <div class="message-container" id="message-container">
            </div>
            <div class="message-form">
                <form id="messageForm" method="post" action="send_message.php">
                    <input type="hidden" id="chatId" name="chat_id" value="">
                    <input type="text" id="messageInput" name="message" placeholder="Type your message..." autocomplete="off">
                    <input type="submit" value="Send">
                </form>
            </div>
        </div>
    </div>

    <script src="./script.js"></script>
</body>

</html>