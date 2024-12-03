<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
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

    // Pobierz id posta do usunięcia
    $postId = $_GET['id'];

    try {
        // Zapytanie SQL do usunięcia posta
        $query = $db->prepare("DELETE FROM posts WHERE id = :id");
        $query->bindParam(':id', $postId);

        // Wykonaj zapytanie
        $query->execute();

        // Przekieruj po udanym usunięciu
        header("Location: index.php?delete_success=1");
        exit();

    } catch (PDOException $e) {
        // Obsłuż błędy związane z zapytaniem SQL
        echo "Błąd SQL: " . $e->getMessage();
    }
}
?>