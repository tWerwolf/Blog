<?php 
require_once "config.php";

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

$name = $lastName = $email = $password = $repeatPassword = $captcha = "";
$nameCheck = $lastNameCheck = $emailCheck = $passwordCheck = $repeatPasswordCheck = $captchaCheck = false;
$nameErr = $lastNameErr = $emailErr = $passwordErr = $repeatPasswordErr = $captchaErr = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    if(empty($_POST["name"])){
        $nameErr = "Imię jest wymagane";
    }else{
        $name = test_input($_POST["name"]);
        if (!preg_match("/^[a-zA-Z]*$/", $name)){
            $nameErr = "Imię zawiera nieprawidłowe znaki";
        }else{
            $nameCheck = true;
        }
    }

    if(empty($_POST["lastName"])){
        $lastNameErr = "Nazwisko jest wymagane";
    }else{
        $lastName = test_input($_POST["lastName"]);
        if (!preg_match("/^[a-zA-Z]*$/", $lastName)){
            $lastNameErr = "Nazwisko zawiera nieprawidłowe znaki";
        }else{
            $lastNameCheck = true;
        }
    }


    if(empty($_POST["email"])) {
        $emailErr = "E-Mail jest wymagany";
    }else {
        $email = test_input($_POST["email"]);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $emailErr = "Adres e-mail jest nieprawidłowy";
        }else{
            $sql = $conn->prepare('SELECT User_Id, Password, Name, LastName FROM users WHERE email = "'.$email.'"');
            $sql->execute();
            $sql->store_result();
            if($sql->num_rows > 0){
                $emailErr = "Takie konto już istnieje";
            }else{
                $emailCheck = true;
            }
        }
    }

    if(empty($_POST["password"])){
        $passwordErr = "Hasło jest wymagane";
    }else{
        $password = trim($_POST["password"]);
        if(strlen($password)<8){
            $passwordErr = "Hasło za krókie";
        }else{
            $passwordCheck = true;
        }
    }


    if(strcmp(trim($_POST["repeatPassword"]), trim($_POST["password"])) !== 0){
        $repeatPasswordErr = "Hasła są różne";
    }else{
        $repeatPasswordCheck = true;
    }

    if(empty($_POST["captcha"])){
        $captchaErr = "Uzupełnij CAPTCHA";
    }else{
        $captcha = test_input($_POST["captcha"]);
        if(isset($_SESSION["captcha"])){
            if(strcasecmp($_SESSION["captcha"], $captcha) !== 0){
                $captchaErr = "CAPTCHA nieprawidłowa";
            }else{
                $captchaCheck = true;
            }

        }else{
            $captchaErr = "Coś poszło nie tak. Odśwież stronę i spróbuj jeszcze raz";
        }
    }

    if($nameCheck == true && $lastNameCheck == true && $emailCheck == true && $passwordCheck == true && $repeatPasswordCheck == true && $captchaCheck == true){
        $sql = 'INSERT INTO users (Name, LastName, Password, Email, Role) VALUES ("'.$name.'", "'.$lastName.'", "'.password_hash($password, PASSWORD_DEFAULT).'", "'.$email.'", "Author")';
        if ($conn->query($sql) === TRUE) {
            header("location: login.php");
          } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }
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
        
    </head>

    <body>
        <div class="container-flex">
			<div class="container"> 
				<?php
                    require 'navbar.php';
                ?>
				
            <main>
                <div id="content">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="commentForm" novalidate>
                        <div class="form-group">
                            <label for="name">Imię:</label></br>
                            <input type="text" name="name" class="form-control border border-dark" required>
                            <span class="text-danger"><?php echo $nameErr ?></span></br>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Nazwisko:</label></br>
                            <input type="text" name="lastName" class="form-control border border-dark" required>
                            <span class="text-danger"><?php echo $lastNameErr ?></span></br>
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail:</label></br>
                            <input type="email" name="email" class="form-control border border-dark" required>
                            <span class="text-danger"><?php echo $emailErr ?></span><br>
                        </div>
                        <div class="form-group">
                            <label for="password">Hasło</label></br>
                            <input type="password" name="password" class="form-control border border-dark" min=8 required>
                            <span class="text-danger"><?php echo $passwordErr ?></span></br>
                        </div>
                        <div class="form-group">
                            <label for="repeatPassword">Powtórz hasło</label></br>
                            <input type="password" name="repeatPassword" class="form-control border border-dark" required>
                            <span class="text-danger"><?php echo $repeatPasswordErr ?></span></br>
                        </div>
                        <div class="form-group">
                            <label for="captcha">Rozwiąż CAPTCHA:</label></br>
                            <input type="text" name="captcha" class="form-control border border-dark" required><br>
                            <img src="captcha.php?rand=<?php echo rand(); ?>" id="captchaImage">
                            <span class="text-danger"><?php  echo $captchaErr ?></span></br>
                        </div>
                        
                        <input type="submit" class="btn btn-dark" value="Zarejestruj się">
                    </form>
                </div>
                
            </main>
        </div>
        <footer class="text-center text-lg-start">
					<div class="text-center p-3">2023 Tomasz Wilk</div>
		</footer>
    </body>
    
</html>