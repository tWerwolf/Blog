<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twój Blog</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>

    <header>
        <h1>blog</h1>
    </header>

    <div class="container">
        <!-- Lewy panel -->
        <div class="panel left-panel">
            <nav>
                <ul>
                    <?php
                        session_start();
                        if (isset($_SESSION['user_id'])) {
                            // Jeśli użytkownik jest zalogowany, wyświetl przycisk "Wyloguj się"
                            echo "<li><a href='logout.php'>Wyloguj się</a></li>";

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

                            // Sprawdź, czy użytkownik ma rolę administratora
                            $queryRole = $db->prepare("SELECT role FROM users WHERE id = :userId");
                            $queryRole->bindParam(':userId', $_SESSION['user_id']);
                            $queryRole->execute();
                            $userRole = $queryRole->fetchColumn();

                            // Jeśli użytkownik ma rolę administratora, wyświetl link "Dodaj Użytkownika"
                            if ($userRole === 'administrator') {
                                echo "<li><a href='add_user.php'>Dodaj Użytkownika</a></li>";
                            }
                        } else {
                            // Jeśli użytkownik nie jest zalogowany, wyświetl przycisk "Zaloguj się"
                            echo "<li><a href='login.php'>Zaloguj się</a></li>";
                        }
                    ?>
                    <li><a href="admin_panel.php">Panel Administracyjny</a></li>
                    <li><a href="contact_form.php">Formularz Kontaktowy</a></li>
                </ul>
            </nav>
        </div>

        <main>
            <?php
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

            // Ustalamy ilość postów na stronie
            $postsPerPage = 3;

            // Pobieramy numer aktualnej strony
            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

            // Obliczamy offset dla zapytania SQL
            $offset = ($currentPage - 1) * $postsPerPage;

            // Pobieranie postów z bazy danych
            $query = $db->query("SELECT * FROM posts ORDER BY id DESC LIMIT $offset, $postsPerPage");
            $posts = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($posts as $post) {
                echo "<div class='post'>";
                echo "<h2>{$post['title']}</h2>";
                echo "<p>{$post['content']}</p>";
                echo "</div>";
            }

            // Wyświetlamy link do poprzedniej strony, jeśli nie jesteśmy na pierwszej stronie
            if ($currentPage > 1) {
                $prevPage = $currentPage - 1;
                echo "<a href='index.php?page=$prevPage'>Poprzednia strona </a>";
            }

            // Wyświetlamy link do następnej strony, jeśli istnieje więcej postów
            $nextPage = $currentPage + 1;
            $queryCount = $db->query("SELECT COUNT(*) as total FROM posts");
            $totalPosts = $queryCount->fetch(PDO::FETCH_ASSOC)['total'];

            if ($totalPosts > $offset + $postsPerPage) {
                echo "<a href='index.php?page=$nextPage'>Następna strona</a>";
            }
            ?>

            <a href="add_post.php">Dodaj nowy post</a>
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
