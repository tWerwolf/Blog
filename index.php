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
                    <?php
                        include 'articles.php';
                    ?>
                </main>
            </div>
            <footer class="text-center text-lg-start">
                <div class="text-center p-3">2023 Tomasz Wilk</div>
            </footer>
        </div>
    </body>
</html>