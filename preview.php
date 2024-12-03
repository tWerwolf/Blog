<?php

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

require_once 'htmlpurifier/HTMLPurifier.standalone.php';
$config = HTMLPurifier_Config::createDefault();
$config->set('HTML.ForbiddenElements', ['img']);
$purifier = new HTMLPurifier($config);


$_SESSION["title"] = $_SESSION["desc"] = $_SESSION["content"] = "";
$_SESSION["descErr"] = $_SESSION["contentErr"] = $_SESSION["titleErr"] = $_SESSION["imageErr"] = $_SESSION["fileData"] =  $_SESSION["fileType"] = $_SESSION["fileName"] = "";
$titleCheck = $descCheck = $contentCheck = $imageCheck = false;
$allowTypes = array('jpg', 'png', 'jpeg');




if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($purifier->purify($_POST["title"]))) {
        $_SESSION["titleErr"] = "Tytuł jest wymagany";
    }else {
        $_SESSION["title"] = test_input($purifier->purify($_POST["title"]));
        $titleCheck = true;
        }
    
    if(empty($purifier->purify($_POST["desc"]))){
        $_SESSION["descErr"] = "Opis jest wymagany";
    }else{
            $_SESSION["desc"] = test_input($purifier->purify($_POST["desc"]));
            $descCheck = true;
        }

    if(empty($purifier->purify($_POST["content"]))){
        $_SESSION["contentErr"] = "Treść artykułu jest wymagana";
    }else{
        $_SESSION["content"] = $purifier->purify(trim($_POST["content"]));
        $contentCheck = true;
    }

    if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
        $_SESSION["fileName"] = $_FILES["image"]["name"];
        $_SESSION["fileType"] = $_FILES["image"]["type"];
        $_SESSION["fileData"] = file_get_contents(addslashes($_FILES["image"]["tmp_name"]));
        if($_FILES["image"]["size"] < 5242880){
            if($_SESSION["fileType"] == "image/jpg" || $_SESSION["fileType"] == "image/png" || $_SESSION["fileType"] == "image/jpeg"){
                $imageCheck = true;
            }else{
                $_SESSION["imageErr"] = "Niedozwolony typ";
            }
        }else{
           $_SESSION["imageErr"] = "Za duży plik";
        }
    }else{
        $imageCheck = true;
    }


    if (!$contentCheck || !$descCheck || !$titleCheck || !$imageCheck){
        header("location: addArticle.php");
    }
    
}



function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


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
                    <div class="display-1"><?php echo $_SESSION["title"]; ?></div>
                    <div>Autor: 
                    <?php
                        if(isset($_SESSION["name"]) && isset($_SESSION["lastName"])){
                            echo $_SESSION["name"]." ".$_SESSION["lastName"];
                        }
                    ?>   
                    </div>
                    <div class="display-4"><?php echo $_SESSION["desc"]; ?></div>
                    <div><?php echo ($_SESSION["content"]); ?></div>
                    <form method="post" action="addArticleConfirm.php">
                        <input type="button" onclick="location.href='addArticle.php';" value="Powrót">
                        <input type="submit" value="Zatwierdź">
                    </form>

                </main>
                
                </div>
        <footer class="text-center text-lg-start">
					<div class="text-center p-3">2023 Tomasz Wilk</div>
		</footer>
    </body>

</html>