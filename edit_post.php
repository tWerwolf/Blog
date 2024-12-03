<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj Post</title>

    <!-- Dodaj link do arkusza stylów TinyMCE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tinymce@5.10.2/dist/skins/content/default/content.min.css">

    <!-- Dodaj skrypty TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: '#postContent',  // Zaznaczamy pole, które ma być edytorem WYSIWYG
            plugins: 'autolink lists link image charmap print preview hr anchor pagebreak',
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            autosave_ask_before_unload: false,
            height: 300,
            menubar: false,
        });
    </script>

    <link rel="stylesheet" href="style.css">
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
                    <li><a href="index.php">Strona Główna</a></li>
                    <!-- Dodaj inne linki nawigacyjne, jeśli potrzebujesz -->
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

            // Pobierz id posta do edycji
            $postId = isset($_GET['id']) ? $_GET['id'] : null;

            if (!$postId) {
                echo "Nieprawidłowe ID postu.";
                exit();
            }

            // Inicjalizuj zmienną $post
            $post = null;

            // Pobierz dane posta do edycji
            $query = $db->prepare("SELECT * FROM posts WHERE id = :id");
            $query->bindParam(':id', $postId);
            $query->execute();
            $post = $query->fetch(PDO::FETCH_ASSOC);

            if (!$post) {
                echo "Post o podanym ID nie istnieje.";
                exit();
            }
            ?>

            <form method="post" action="process_edit_post.php">
                <label for="postTitle">Tytuł:</label>
                <input type="text" name="postTitle" id="postTitle" value="<?php echo $post['title']; ?>" required>

                <label for="postContent">Treść posta:</label>
                <!-- Zastąp zwykłe textarea edytorem TinyMCE -->
                <div id="postContent" name="postContent" required><?php echo htmlspecialchars($post['content']); ?></div>

                <input type="hidden" name="postId" value="<?php echo $postId; ?>">

                <button type="submit" name="submitBtn">Zapisz zmiany</button>
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
