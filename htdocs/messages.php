<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "chat_db");

if ($conn->connect_error) {
    die("Połączenie z bazą danych nieudane: " . $conn->connect_error);
}

$user = $_SESSION['user'];
$isTeacher = $user['role'] === 'teacher';

// Zajmij się usuwaniem wiadomości, jeśli nauczyciel o to poprosi
if ($isTeacher && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_messages'])) {
    $conn->query("DELETE FROM messages");
}

// Obsługa wysyłania wiadomości
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $message = $_POST['message'];
    $recipient_id = $_POST['recipient'] ?? NULL;

    if ($isTeacher) {
        if ($recipient_id) {
            // Sprawdź, czy odbiorca istnieje
            $res = $conn->query("SELECT id FROM users WHERE id = $recipient_id LIMIT 1");
            if ($res->num_rows === 0) {
                die("Recipient does not exist.");
            }
            $stmt = $conn->prepare("INSERT INTO messages (sender_id, recipient_id, message) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $user['id'], $recipient_id, $message);
        } else {
            // Obsługuj wiadomość dla wszystkich odbiorców (NULL)
            $stmt = $conn->prepare("INSERT INTO messages (sender_id, recipient_id, message) VALUES (?, NULL, ?)");
            $stmt->bind_param("is", $user['id'], $message);
        }
    } else {
        $teacher_id_res = $conn->query("SELECT id FROM users WHERE role='teacher' LIMIT 1");
        if ($teacher_id_res->num_rows == 1) {
            $teacher_id = $teacher_id_res->fetch_assoc()['id'];
            $stmt = $conn->prepare("INSERT INTO messages (sender_id, recipient_id, message) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $user['id'], $teacher_id, $message);
        }
    }
    $stmt->execute();
    $stmt->close();
}

// Pobieraj wiadomości po potencjalnym usunięciu
if ($isTeacher) {
    $result = $conn->query("SELECT m.*, u.username as sender FROM messages m JOIN users u ON m.sender_id = u.id ORDER BY m.timestamp DESC");
} else {
    $user_id = $user['id'];
    $result = $conn->query("SELECT m.*, u.username as sender FROM messages m JOIN users u ON m.sender_id = u.id WHERE m.recipient_id IS NULL OR m.recipient_id = $user_id OR m.sender_id = $user_id ORDER BY m.timestamp DESC");
}
$messages = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wiadomości</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="messages-container">
        <div class="user-info">
            <p>Witaj <strong><?php echo htmlspecialchars($user['username']); ?></strong></p>
        </div>
        <h2>Wiadomości</h2>
        <div class="messages">
            <?php foreach ($messages as $index => $msg): ?>
                <div class="message" id="message-<?php echo $index; ?>">
                    <strong><?php echo htmlspecialchars($msg['sender']); ?>:</strong>
                    <p><?php echo htmlspecialchars($msg['message']); ?></p>
                    <small><?php echo htmlspecialchars($msg['timestamp']); ?></small>
                    <hr>
                    <button class="toggle-message" data-id="message-<?php echo $index; ?>">Zwiń</button>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($isTeacher): ?>
            <form method="POST" style="display: inline;">
                <!-- Przycisk „Usuń wszystko” dla nauczyciela -->
                <button type="submit" name="delete_messages" onclick="return confirm('Czy na pewno chcesz usunąć wszystkie wiadomości?');">Usuń wszystkie wiadomości</button>
            </form>
        <?php endif; ?>

        <button id="clear-messages">Wyczyść</button>
        
        <div class="send-message">
            <h3>Wyślij wiadomość</h3>
            <form method="POST" action="messages.php">
                <?php if ($isTeacher): ?>
                    <label for="recipient">Odbiorca:</label>
                    <select id="recipient" name="recipient">
                        <option value="">Wszyscy</option>
                        <?php
                        $users = $conn->query("SELECT * FROM users WHERE role='parent'");
                        while ($row = $users->fetch_assoc()) {
                            echo "<option value=\"{$row['id']}\">" . htmlspecialchars($row['username']) . "</option>";
                        }
                        ?>
                    </select>
                <?php endif; ?>
                <label for="message">Wiadomość:</label>
                <textarea id="message" name="message" required></textarea>
                <button type="submit">Wyślij</button>
            </form>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>