<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $captchaInput = $_POST['captcha'];

    if (isset($_SESSION['captcha']) && $_SESSION['captcha'] == $captchaInput) {
        $dsn = "mysql:host=localhost;dbname=blog";
        $dbUsername = "root";
        $dbPassword = "";

        try {
            $db = new PDO($dsn, $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = $db->prepare("SELECT id, username, hashed_password FROM users WHERE username = :username");
            $query->bindParam(':username', $username);
            $query->execute();
            $userData = $query->fetch(PDO::FETCH_ASSOC);

            if ($userData && password_verify($password, $userData['hashed_password'])) {
                $_SESSION['user_id'] = $userData['id'];
                $_SESSION['username'] = $userData['username'];

                header('Location: index.php');
                exit();
            } else {
                $loginError = true;
            }
        } catch (PDOException $e) {
            die("Błąd połączenia z bazą danych: " . $e->getMessage());
        }
    } else {
        $captchaError = true;
    }
}

function generateCaptcha($length = 4)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $captcha = '';
    for ($i = 0; $i < $length; $i++) {
        $captcha .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $captcha;
}

$captcha = generateCaptcha();
$_SESSION['captcha'] = $captcha;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <h1>Twój Blog</h1>
    </header>

    <div class="container">
        <div class="panel left-panel">
            <nav>
                <ul>
                    <li><a href="index.php" class="nav-btn">Wróć do strony głównej</a></li>
                </ul>
            </nav>
        </div>

        <main>
            <div class="panel center-panel">
                <h2>Zaloguj się</h2>

                <?php
                if (isset($loginError) && $loginError) {
                    echo '<p class="error">Nieprawidłowa nazwa użytkownika lub hasło.</p>';
                }

                if (isset($captchaError) && $captchaError) {
                    echo '<p class="error">Nieprawidłowy kod captcha.</p>';
                }
                ?>

                <form method="post" action="login.php">
                    <label for="username">Nazwa użytkownika:</label>
                    <input type="text" name="username" id="username" required>

                    <label for="password">Hasło:</label>
                    <input type="password" name="password" id="password" required>

                    <label for="captcha">Wprowadź kod captcha:</label>
                    <input type="text" name="captcha" id="captcha" required>
                    <span>Kod captcha: <?php echo $captcha; ?></span>

                    <button class="nav-btn" type="submit" name="loginBtn">Zaloguj</button>
                </form>
            </div>
        </main>

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
