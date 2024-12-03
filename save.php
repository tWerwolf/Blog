<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

    require_once "config.php";

    $name = $lastName = $email = "";
    $nameCheck = $lastNameCheck = $emailCheck = false;
    $_SESSION["nameErr"] = $_SESSION["lastNameErr"] = $_SESSION["emailErr"] = "";
    $_SESSION["iderr"] = $_POST["id"];

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $id = $_POST["id"];
        $name = $_POST["name"];
        $lastName = $_POST["lastName"];
        $role = $_POST["role"];

        if(empty($_POST["name"])){
            $_SESSION["nameErr"] = "Imię jest wymagane";
        }else{
            $name = test_input($_POST["name"]);
            if (!preg_match("/^[a-zA-Z]*$/", $name)){
                $_SESSION["nameErr"] = "Imię zawiera nieprawidłowe znaki";
            }else{
                $nameCheck = true;
            }
        }

        if(empty($_POST["lastName"])){
            $_SESSION["lastNameErr"] = "Nazwisko jest wymagane";
        }else{
            $lastName = test_input($_POST["lastName"]);
            if (!preg_match("/^[a-zA-Z]*$/", $lastName)){
                $_SESSION["lastNameErr"] = "Imię zawiera nieprawidłowe znaki";
            }else{
                $lastNameCheck = true;
            }
        }


        if(empty($_POST["email"])) {
            $_SESSION["emailErr"] = "E-Mail jest wymagany";
        }else {
            $email = test_input($_POST["email"]);
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $_SESSION["emailErr"] = "Adres e-mail jest nieprawidłowy";
            }else{
                $sql = $conn->prepare('SELECT User_Id FROM users WHERE email = "'.$email.'"');
                $sql->execute();
                $sql->store_result();
                $sql->bind_result($id_db);
                $sql->fetch();
                if($sql->num_rows > 0 &&  $id!=$id_db){
                    $_SESSION["emailErr"] = "Takie konto już istnieje";
                }else{
                    $emailCheck = true;
                }
            }
        }


        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && isset($_SESSION["role"]) && $_SESSION["role"] == "Admin"
        && $emailCheck && $lastNameCheck && $nameCheck){
            $sql = $conn->prepare('UPDATE users SET Name="'.$name.'", LastName="'.$lastName.'", Email="'.$email.'", Role="'.$role.'" WHERE User_Id='.$id);
            $sql->execute();
        }

        header("location: manageUsers.php");

    }
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>