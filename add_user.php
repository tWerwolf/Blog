<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj Użytkownika</title>
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
        <h1>Dodaj Użytkownika</h1>
    </header>

    <main>
        <div class="form-container">
            <form method="post" action="add_user.php">
                <label for="username">Nazwa użytkownika:</label>
                <input type="text" name="username" required>

                <label for="password">Hasło:</label>
                <input type="password" name="password" required>

                <label for="role">Rola:</label>
                <select name="role" required>
                    <option value="administrator">Administrator</option>
                    <option value="użytkownik">Użytkownik</option>
                </select>

                <button type="submit">Dodaj Użytkownika</button>
            </form>
        </div>
    </main>

    <footer>
        <!-- Stopka -->
    </footer>

</body>
</html>
