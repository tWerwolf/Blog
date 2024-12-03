<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twój Blog - Dodaj/Edytuj Post</title>

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
    <!-- Dodaj link do pliku TinyMCE -->
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
</head>
<body>

    <header>
        <h1>Twój Blog</h1>
    </header>

    <main>
        <div class="container">
            
            <form method="post" action="process_post.php">
                <label for="postTitle">Tytuł:</label>
                <input type="text" name="postTitle" id="postTitle" required>

                <label for="postContent">Treść posta:</label>
                <!-- Zamień textarea na div dla TinyMCE -->
                <div id="postContent" name="postContent" required></div>

                <input type="hidden" name="postId" id="postId" value="">

                <button type="submit" name="submitBtn" id="submitBtn">Dodaj post</button>
            </form>
        </div>
    </main>

    <footer>
        <!-- Stopka -->
    </footer>

</body>
</html>
