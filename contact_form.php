<?php
// Początek sesji
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Przekieruj na stronę logowania, jeśli nie jest zalogowany
    exit();
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

// Obsługa przesłanego formularza
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pobierz dane z formularza
    $title = $_POST['title'];
    $message = $_POST['message'];

    // Pobierz id zalogowanego użytkownika
    $userId = $_SESSION['user_id'];

    // Sprawdź, czy treść wiadomości nie jest pusta, gdy używane jest pole TinyMCE
    if (!empty($message) || !empty($_POST['message'])) {
        // Zapisz wiadomość do bazy danych
        $query = $db->prepare("INSERT INTO contact_messages (user_id, title, message, created_at) VALUES (:user_id, :title, :message, NOW())");
        $query->bindParam(':user_id', $userId);
        $query->bindParam(':title', $title);
        $query->bindParam(':message', $message);

        try {
            $query->execute();
            echo "Wiadomość została wysłana.";

            // Przekieruj do strony index.php po pomyślnym przesłaniu wiadomości
            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            echo "Błąd podczas wysyłania wiadomości: " . $e->getMessage();
        }
    } else {
        echo "Treść wiadomości nie może być pusta.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt</title>
    <link rel="stylesheet" href="style.css">
    <!-- Dodaj link do edytora WYSIWYG (np. TinyMCE) -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#message',  // Zdefiniuj element textarea, który ma być edytorem WYSIWYG
            plugins: 'advlist autolink lists link charmap print preview anchor',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | link',
        });
    </script>
</head>
<body>

    <header>
        <h1>Twój Blog</h1>
    </header>

    <div class="container">
        <!-- Lewy panel -->
        <div class="panel left-panel">
            <nav>
                <ul>
                    <li><a href="admin_panel.php">Panel Administracyjny</a></li>
                    <li><a href="contact_form.php">Formularz Kontaktowy</a></li>
                    <?php
                        if (isset($_SESSION['user_id'])) {
                            echo "<li><a href='logout.php'>Wyloguj się</a></li>";
                        } else {
                            echo "<li><a href='login.php'>Zaloguj się</a></li>";
                        }
                    ?>
                </ul>
            </nav>
        </div>

        <main>
            <h2>Formularz Kontaktowy</h2>

            <form method="post" action="contact_form.php">
                <label for="title">Tytuł:</label>
                <input type="text" name="title" id="title" required>

                <label for="message">Treść wiadomości:</label>
                <textarea name="message" id="message"></textarea>

                <button type="submit" name="submitBtn">Wyślij wiadomość</button>
            </form>
        </main>

        <!-- Prawy panel -->
        <div class="panel right-panel">
        <h2>Aktualna Godzina</h2>
            <p><?php echo date("H:i:s"); ?></p>
        </div>
    </div>

    <footer>
        <!-- Stopka -->
    </footer>

</body>
</html>
