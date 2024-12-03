<?php
    require_once "config.php";

    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

    if(!isset($_SESSION["loggedin"]) || (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false)){
        header("location: login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
                    <div class="lh-1">
                        <h3 class="mb-0">
                            <?php 
                                if(isset($_SESSION["name"]) && isset($_SESSION["lastName"])){
                                    echo "Witaj, ".$_SESSION["name"]." ".$_SESSION["lastName"];
                                }
                            ?>
                        </h3><br>
                        <button class="btn btn-outline-danger btn-circle btn-lg btn-circle" onclick="location.href='addArticle.php'">Dodaj Post</button><br>
                    </div>
                    <?php 
                        $sql = $conn->prepare("SELECT ArticleId, ArticleTitle, UserId FROM articles WHERE UserId = ".$_SESSION["id"]);
                        $sql->execute();
                        $sql->store_result();
                        $sql->bind_result($id, $title, $UserId);
                        if($sql->num_rows > 0){
                            echo '<div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-uppercase mb-0">Posty</h5>
                                    </div>
                                        <div class="mb-0">
                                            <div class="row pb-2 pt-2 ms-0 me-0 border-bottom border-dark">
                                                <div class="col border-0 font-medium ps-4">Tytuł</div>
                                                <div class="col border-0 font-medium">Zarządzaj</div>
                                            </div>
                                        </div>';

                            while($sql->fetch()){
                                echo '<form action="editArticle.php" method="POST">
                                            <div class="row border-bottom border-dark pb-2 pt-2 ms-0 me-0">
                                                <div class="col ps-4">'.$title.'<br> 
                                                <span class="text-danger">';
                                                if (isset($_SESSION["articleIdErr"]) && ($_SESSION["articleIdErr"] == $id)){
                                                    echo $_SESSION["updateErr"];
                                                }

                                echo            '</span></div>
                                            
                                                <div class="col">
                                                    <label for="submit'.$id.'" class="btn btn-outline-secondary btn-circle btn-lg btn-circle"><i class="bi bi-gear"></i></label>
                                                    <input id="submit'.$id.'" name="submit'.$id.'" type="submit" class="d-none">
                                                    <button type="button" class="btn btn-outline-danger btn-circle btn-lg btn-circle" onclick="javascript:location.href=`deleteArticle.php?id='.$id.'&UserId='.$UserId.'`"><i class="bi bi-trash"></i></button>
                                                    <input type="hidden" name="id" value='.$id.'>
                                                </div>
                                                </div>
                                        </form>';
                            }
                            echo '</div>';
                        }

                    ?>
                </main>
            </div>
            <footer class="text-center text-lg-start">
                <div class="text-center p-3">2023 Tomasz Wilk</div>
            </footer>
        </div>
    </body>
</html>