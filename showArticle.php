<?php
    require_once "config.php";

    $articleId = $_GET["id"];

    $sql = $conn->prepare("SELECT ArticleTitle, ArticleDescr, ArticleContent, Name, LastName FROM articles a INNER JOIN users u ON (a.UserId=u.User_Id) WHERE ArticleId = ".$articleId);
    $sql->execute();
    $sql->store_result();
    $sql->bind_result($title, $desc, $content, $name, $lastName);
    $sql->fetch();


?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> 
        <link rel="stylesheet" href="css.css">
        

        
        <meta name="viewport" content="width=device-width, initial-scale=1">

    </head>
    <body>
    <div class="container-flex">
            <div class="container"> 
                <?php
                    require 'navbar.php';
                ?>
                <main>
                    <div class="display-1"><?php echo $title; ?></div>
                    <div>Autor: <?php echo $name." ".$lastName ?></div>
                    <div class="display-4"><?php echo $desc; ?></div>
                    <div><?php echo $content; ?></div>
                </main>
                
                </div>
        <footer class="text-center text-lg-start">
					<div class="text-center p-3">2023 Tomasz Wilk</div>
		</footer>
    </body>

</html>