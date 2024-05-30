<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "komunikacja_rodzice_wychowawczyni");

if ($conn->connect_error) {
    die("Połączenie z bazą danych nieudane: " . $conn->connect_error);
}

$user = $_SESSION['user'];
$isTeacher = $user['role'] === 'teacher';

// Obsługa wysyłania wiadomości
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $message = $_POST['message'];
    $recipient_id = $_POST['recipient'] ?? NULL;

    $stmt = $conn->prepare("INSERT INTO messages (sender_id, recipient_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $user['id'], $recipient_id, $message);
    $stmt->execute();
    $stmt->close();
}

// Pobranie wiadomości
$result = $conn->query("SELECT m.*, u.username as sender FROM messages m JOIN users u ON m.sender_id = u.id ORDER BY m.timestamp DESC");
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
        <h2>Wiadomości</h2>

        <div class="messages">
            <?php foreach ($messages as $msg): ?>
                <div class="message">
                    <strong><?php echo $msg['sender']; ?>:</strong>
                    <p><?php echo $msg['message']; ?></p>
                    <small><?php echo $msg['timestamp']; ?></small>
                </div>
            <?php endforeach; ?>
        </div>

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
                            echo "<option value=\"{$row['id']}\">{$row['username']}</option>";
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
