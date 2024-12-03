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
        // Zapytanie SQL do aktualizacji posta
        $query = $db->prepare("UPDATE posts SET title = :title, content = :content WHERE id = :id");
        $query->bindParam(':title', $postTitle);
        $query->bindParam(':content', $postContent);
        $query->bindParam(':id', $postId);

        // Wykonaj zapytanie
        $query->execute();

        // Przekieruj po udanych zmianach
        header("Location: index.php?edit_success=1");
        exit();

    } catch (PDOException $e) {
        // Obsłuż błędy związane z zapytaniem SQL
        echo "Błąd SQL: " . $e->getMessage();
    }
}
?>
