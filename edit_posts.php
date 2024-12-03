<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$loggedInUsername = isset($_SESSION['username']) ? $_SESSION['username'] : 'Gość';

$dsn = "mysql:host=localhost;dbname=blog";
$username = "root";
$password = "";

try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Błąd połączenia z bazą danych: " . $e->getMessage());
}

$queryRole = $db->prepare("SELECT role FROM users WHERE id = :userId");
$queryRole->bindParam(':userId', $_SESSION['user_id']);
$queryRole->execute();
$userRole = $queryRole->fetchColumn();

if ($userRole !== 'administrator') {
    header("Location: index.php");
    exit();
}

$query = $db->query("SELECT * FROM posts");
$posts = $query->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['editBtn'])) {
    $postIdToEdit = $_POST['postId'];
    header("Location: edit_post.php?id=$postIdToEdit");
    exit();
}

if (isset($_POST['deleteBtn'])) {
    $postIdToDelete = $_POST['postId'];
    
    $db->query("DELETE FROM posts WHERE id = $postIdToDelete");

    header("Location: edit_posts.php");
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
</head>
<body>

    <header>
        <h1>Panel Administracyjny</h1>
        <p class="welcome">Witaj, <?php echo $loggedInUsername; ?>!
        <form id="logoutForm" method="post" action="logout.php">
            <button class="logout-btn" type="submit" name="logoutBtn">Wyloguj</button>
        </form></p>
    </header>

    <div class="container">
        <div class="panel left-panel">
            <nav>
                <ul>
                    <li><a href='logout.php' class="nav-btn">Wyloguj się</a></li>
                    <?php if ($userRole === 'administrator'): ?>
                        <li><a href='add_user.php' class="nav-btn">Dodaj Użytkownika</a></li>
                    <?php endif; ?>
                    <li><a href="index.php" class="nav-btn">Powrót do Bloga</a></li>
                    <li><a href="contact_form.php" class="nav-btn">Formularz Kontaktowy</a></li>
                </ul>
            </nav>
        </div>

        <main>
            <h2>Lista Postów</h2>
            <table>
                <tr>
                    <th>Tytuł</th>
                    <th>Akcje</th>
                </tr>
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?php echo $post['title']; ?></td>
                        <td>
                            <form method="post" action="edit_posts.php">
                                <input type="hidden" name="postId" value="<?php echo $post['id']; ?>">
                                <button class="edit-btn" type="submit" name="editBtn">Edytuj</button>
                            </form>
                            <form method="post" action="">
                                <input type="hidden" name="postId" value="<?php echo $post['id']; ?>">
                                <button class="delete-btn" type="submit" name="deleteBtn">Usuń</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
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
