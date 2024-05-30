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
