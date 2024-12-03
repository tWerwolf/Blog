<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['username'])) {
    $loggedInUsername = $_SESSION['username'];
} else {
    $loggedInUsername = 'Gość';
}

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

$queryUsers = $db->query("SELECT * FROM users");
$users = $queryUsers->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['editUserBtn'])) {
    $userIdToEdit = $_POST['userId'];
    $newUsername = $_POST['newUsername'];
    $newRole = $_POST['newRole'];

    $queryUpdateUser = $db->prepare("UPDATE users SET username = :newUsername, role = :newRole WHERE id = :userId");
    $queryUpdateUser->bindParam(':newUsername', $newUsername);
    $queryUpdateUser->bindParam(':newRole', $newRole);
    $queryUpdateUser->bindParam(':userId', $userIdToEdit);
    $queryUpdateUser->execute();

    header("Location: edit_users.php");
    exit();
}

if (isset($_POST['deleteUserBtn'])) {
    $userIdToDelete = $_POST['userId'];

    $queryDeleteUser = $db->prepare("DELETE FROM users WHERE id = :userId");
    $queryDeleteUser->bindParam(':userId', $userIdToDelete);
    $queryDeleteUser->execute();

    header("Location: edit_users.php");
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
                <button type="submit" name="logoutBtn">Wyloguj</button>
            </form>
        </p>
    </header>

    <div class="container">
        <!-- Lewy panel -->
        <div class="panel left-panel">
            <nav>
                <ul>
                    <li><a href="index.php">Powrót do strony głównej</a></li>
                    <!-- Dodaj inne linki nawigacyjne, jeśli potrzebujesz -->
                </ul>
            </nav>
        </div>

        <main>
            <h2>Lista Użytkowników</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nazwa Użytkownika</th>
                    <th>Rola</th>
                    <th>Akcje</th>
                </tr>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['role']; ?></td>
                        <td>
                            <form method="post" action="edit_users.php">
                                <input type="hidden" name="userId" value="<?php echo $user['id']; ?>">
                                <label for="newUsername">Nowa Nazwa Użytkownika:</label>
                                <input type="text" name="newUsername" required>
                                <label for="newRole">Nowa Rola:</label>
                                <input type="text" name="newRole" required>
                                <button type="submit" name="editUserBtn">Edytuj</button>
                            </form>
                            <form method="post" action="edit_users.php">
                                <input type="hidden" name="userId" value="<?php echo $user['id']; ?>">
                                <button type="submit" name="deleteUserBtn">Usuń</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
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

    <script>
        function logout() {
            document.getElementById('logoutForm').submit();
        }
    </script>

</body>
</html>
