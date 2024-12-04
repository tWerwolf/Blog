<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

    require_once "config.php";

    $id = $_GET["id"];
    $userId = $_GET["UserId"];

    if((isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) && ((isset($_SESSION["role"]) && $_SESSION["role"] === "Admin") || (isset($_SESSION["id"]) && $_SESSION["id"]*1 == $userId*1))){
        $sql = $conn->prepare("DELETE FROM articles WHERE ArticleId=".$id);
        $sql->execute();
         header("location: profilePage.php");
    }
        
?>
