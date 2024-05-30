<?php
session_start();
$conn = new mysqli("localhost", "root", "", "komunikacja_rodzice_wychowawczyni");

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Połączenie z bazą danych nieudane: " . $conn->connect_error);
}

// Obsługa logowania
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $result = $conn->query("SELECT * FROM users WHERE username='$username' AND password='$password'");

    if ($result->num_rows == 1) {
        $_SESSION['user'] = $result->fetch_assoc();
        header("Location: messages.php");
        exit();
    } else {
        echo "<p>Nieprawidłowa nazwa użytkownika lub hasło.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Logowanie</h2>
        <form method="POST" action="index.php">
            <label for="username">Nazwa użytkownika:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Hasło:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit" name="login">Zaloguj</button>
        </form>
    </div>
</body>
</html>
