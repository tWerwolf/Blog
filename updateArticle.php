<?php

require_once "config.php";

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 


$titleUpdate = $descUpdate = $contentUpdate = $slugUpdate = "";
$_SESSION["updateErr"] = "";
$titleCheck = $descCheck = $contentCheck = false;




if($_SERVER["REQUEST_METHOD"] == "POST"){
    $articleId = $_POST["articleId"];
    if(empty($_POST["title"])) {
        $_SESSION["updateErr"] = "Tytuł jest wymagany";
    }else {
        $titleUpdate = test_input($_POST["title"]);
        $slugUpdate = slug($titleUpdate);
        $sql = $conn->prepare('SELECT ArticleId, ArticleSlug FROM articles WHERE ArticleSlug = "'.$slugUpdate.'"');
        $sql->execute();
        $sql->store_result();
        $sql->bind_result($articleIdTest, $slug);
        $sql->fetch();
        if($sql->num_rows > 0 && $articleId != $articleIdTest){
            $_SESSION["updateErr"] = "Artykuł o takim tytule już istnieje";
        }else{
            $titleCheck = true;
        }
        }
    if(empty($_POST["desc"])){
        $_SESSION["updateErr"] = "Opis jest wymagany";
    }else{
            $descUpdate = test_input($_POST["desc"]);
            $descCheck = true;
        }

    if(empty($_POST["content"])){
        $_SESSION["updateErr"] = "Treść artykułu jest wymagana";
    }else{
        $contentUpdate = trim($_POST["content"]);
        $contentCheck = true;
    }

    if (!$contentCheck || !$descCheck || !$titleCheck){
        $_SESSION["articleIdErr"] = $articleId;
        header("location: profilePage.php");
    }
    else{
        $sql = $conn->prepare("UPDATE articles SET ArticleTitle='".$titleUpdate."', ArticleDescr='".$descUpdate."', ArticleContent='".$contentUpdate."', ArticleSlug='".$slugUpdate."' WHERE ArticleId = ".$articleId);
        $sql->execute();
        header("location: profilePage.php");
    }
    
}



function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
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
