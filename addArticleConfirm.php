<?php

    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

    if(!isset($_SESSION["loggedin"]) || (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false)){
        header("location: login.php");
        exit;
    }

    $articleSlug = slug($_SESSION["title"]);

    require_once "config.php";

    $sql = $conn->prepare('SELECT ArticleSlug FROM articles WHERE ArticleSlug = "'.$articleSlug.'"');
    $sql->execute();
    $sql->store_result();
    if($sql->num_rows > 0){
        $_SESSION["titleErr"] = "Artykuł o takim tytule już istnieje";
        header("location: addArticle.php");
    }

    $sql = $conn->prepare('INSERT INTO articles (ArticleTitle, ArticleSlug, ArticleDescr, ArticleContent, ArticleDate, ImageName, ImageType, ImageData, UserID) VALUES (?, ?, ?, ?, now(), ?, ?, ?, ?)');
    $sql->bind_param('sssssssi', $_SESSION["title"], $articleSlug, $_SESSION["desc"], $_SESSION["content"], $_SESSION["fileName"], $_SESSION["fileType"], $_SESSION["fileData"], $_SESSION["id"]);
    $sql->execute();
    if ($sql->affected_rows == 1) {
        $_SESSION["title"] = "";
        $_SESSION["desc"] = "";
        $_SESSION["content"] = "";
        header("location: index.php");
        } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        }

    function slug($text){ 
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = strtolower($text);
        $text = preg_replace('~[^-\w]+~', '', $text);   
        if (empty($text))
        {
            $_SESSION['titleErr'] = "Tytuł jest wymagany";
            header("location: addArticle.php");
        }
        return $text;
      }

?>