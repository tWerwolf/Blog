<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

    require_once "config.php";

    $id = $_GET["id"];

    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && isset($_SESSION["role"]) && $_SESSION["role"] == "Admin"){
        $sql = $conn->prepare("DELETE FROM articles WHERE UserID=".$id);
        $sql->execute();
        $sql = $conn->prepare("DELETE FROM users WHERE User_ID=".$id);
        $sql->execute();
    }

    
    
    if($_SESSION["id"]==$id){
        header("location: logout.php");
    }else{
        header("location: manageUsers.php");
    }
?>