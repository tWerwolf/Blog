<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitBtn'])) {
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

    // Pobierz dane z formularza
    $postTitle = $_POST['postTitle'];
    $postContent = $_POST['postContent'];
    $postId = $_POST['postId'];

    try {
        // Sprawdź, czy to dodawanie czy edycja posta
        if (empty($postId)) {
            // Dodawanie nowego posta
            $query = $db->prepare("INSERT INTO posts (title, content) VALUES (:title, :content)");
        } else {
            // Edycja istniejącego posta
            $query = $db->prepare("UPDATE posts SET title = :title, content = :content WHERE id = :id");
            $query->bindParam(':id', $postId);
        }

        // Przypisz wartości do parametrów zapytania
        $query->bindParam(':title', $postTitle);
        $query->bindParam(':content', $postContent);

        // Wykonaj zapytanie
        $query->execute();

        // Przekieruj po udanej operacji
        header("Location: index.php?success=1");
        exit();

    } catch (PDOException $e) {
        // Obsłuż błędy związane z zapytaniem SQL
        echo "Błąd SQL: " . $e->getMessage();
    }
}
?>