<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: index.php");
        exit;
    }

    require_once "config.php";

    $email = $password = "";
    $error = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        $email = test_input($_POST["email"]);
        $password = trim($_POST["password"]);
        if(empty($email) || empty($password)){
            $error = "Uzupełnij dane";
        }else{
            $sql = $conn->prepare('SELECT User_Id, Password, Name, LastName, Email, Role FROM users WHERE email = "'.$email.'"');

            $sql->execute();
            $sql->store_result();

            if($sql->num_rows > 0){
                $sql->bind_result($id, $hashed_password, $name, $lastName, $email, $role);
                $sql->fetch();
                if(password_verify($password, $hashed_password)){
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $id;
                    $_SESSION["name"] = $name;
                    $_SESSION["lastName"] = $lastName;
                    $_SESSION["email"] = $email;
                    $_SESSION["role"] = $role;
                    header("Location: index.php");
                    exit;
                }else{
                    $error = "Dane nieprawidłowe";
                }
            }else{
                $error = "Dane nieprawidłowe";
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
                            <label for="email">E-mail:</label></br>
                            <input type="email" name="email" class="form-control border border-dark" required>
                            <br>
                        </div>
                        <div class="form-group">
                            <label for="password">Hasło</label></br>
                            <input type="password" name="password" class="form-control border border-dark" min=8 required>
                            </br>
                        </div>                        
                        <input type="submit" class="btn btn-dark" value="Zaloguj"><br>
                        <span class="text-danger"><?php echo $error ?></span></br>
                    </form>
                    <span>Nie masz konta? <a href="register.php">Kliknij tutaj!</a></span>
                </div>
                
                
            </main>
        </div>
        <footer class="text-center text-lg-start">
					<div class="text-center p-3">2023 Tomasz Wilk</div>
		</footer>
    </body>

</html>