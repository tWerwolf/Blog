<?php
// Początek sesji
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Przekieruj na stronę logowania, jeśli nie jest zalogowany
    exit();
}

// Sprawdź, czy istnieje indeks 'username' w tablicy $_SESSION
if (isset($_SESSION['username'])) {
    $loggedInUsername = $_SESSION['username'];
} else {
    $loggedInUsername = 'Gość'; // Domyślna wartość, jeśli 'username' nie istnieje w sesji
}

// Połączenie z bazą danych
$dsn = "mysql:host=localhost;dbname=blog";
$username = "root";
$password = "";

try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Błąd połączenia z bazą danych: " . $e->getMessage());
}

// Pobierz rolę zalogowanego użytkownika
$queryRole = $db->prepare("SELECT role FROM users WHERE id = :userId");
$queryRole->bindParam(':userId', $_SESSION['user_id']);
$queryRole->execute();
$userRole = $queryRole->fetchColumn();

// Sprawdź, czy użytkownik ma rolę administratora
if ($userRole !== 'administrator') {
    header("Location: index.php"); // Przekieruj zwykłych użytkowników na stronę główną
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administracyjny</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1em 0;
        }

        header p {
            margin: 0;
        }

        header button {
            background-color: #d9534f;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .container {
            display: flex;
            max-width: 1200px;
            margin: 20px auto;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .panel {
            flex: 1;
            padding: 20px;
        }

        .left-panel {
            background-color: #4CAF50;
            color: white;
        }

        .left-panel nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .left-panel nav li {
            margin-bottom: 10px;
        }

        .left-panel nav a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            font-size: 16px;
            transition: color 0.3s;
        }

        .left-panel nav a:hover {
            color: #333;
        }

        main {
            flex: 3;
            padding: 20px;
        }

        main h2 {
            color: #333;
        }

        main div a {
            display: inline-block;
            background-color: #5bc0de;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            margin: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        main div a:hover {
            background-color: #31b0d5;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #333;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

    <header>
        <h1>Panel Administracyjny</h1>
        <p class="welcome">Witaj, <?php echo $loggedInUsername; ?>!
        <form id="logoutForm" method="post" action="logout.php">
            <button type="submit" name="logoutBtn">Wyloguj</button>
        </form></p>
    </header>

    <div class="container">
        <div class="panel left-panel">
            <nav>
                <ul>
                    <li><a href="edit_posts.php">Edytuj Posty</a></li>
                    <li><a href="edit_users.php">Edytuj Użytkowników</a></li>
                </ul>
            </nav>
        </div>

        <main>
            <h2>Panel Administracyjny</h2>
        </main>
    
        <div class="panel right-panel">
            <h2>Aktualna Godzina</h2>
                <p><?php echo date("H:i:s"); ?></p>
            </div>
    </div>
    <footer>
        <!-- Stopka -->
    </footer>

    <script>
        function logout() {
            document.getElementById('logoutForm').submit();
        }
    </script>

</body>
</html>
