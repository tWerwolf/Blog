<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    
    $email = $topic = $content = "";
    $emailCheck = $topicCheck = $contentCheck = false;
    $emailErr = $topicErr = $contentErr = $mailError = "";
    $mailSuccess = "";
    $emailLogin = "";

    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        $emailLogin = $_SESSION["email"];
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(empty($_POST["email"])  || trim($_POST["email"]) == '') {
            $emailErr = "E-Mail jest wymagany";
        }else {
            $email = test_input($_POST["email"]);
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $emailErr = "Adres e-mail jest nieprawidłowy";
            }else{
                $emailCheck = true;
            }
        }

            if(empty($_POST["topic"]) || trim($_POST["topic"]) == ''){
                 $topicErr = "Tytuł jest wymagany";
            }else{
                $topic = test_input($_POST["topic"]);
                $topicCheck = true;
            }

            if(empty($_POST["content"]) || trim($_POST["content"]) == ''){
                $contentErr = "Treść jest wymagana";
           }else{
               $content = test_input($_POST["content"]);
               $contentCheck = true;
           }

           if($emailCheck && $topicCheck && $contentCheck){
                try{
                    $mail = new PHPMailer();
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->Port = 465;
                    $mail->SMTPSecure = PHPMAILER::ENCRYPTION_SMTPS;
                    $mail->Username = '';
                    $mail->Password = '';
                    $mail->CharSet = 'UTF-8';
                    $mail->setFrom($email, $email);
                    $mail->addAddress('');
                    $mail->addReplyTo($email);
                    $mail->Subject = $topic;
                    $mail->Body = $content;
                    $mail->SMTPAuth = true;
                    
                    if($mail->send()){
                        $mailSuccess = "Dziękujemy za skontaktowanie się. Wiadomość wysłana.";
                    }else{
                        $mailError = "Wystąpił błąd podczas wysyłania wiadomości";
                    }
                }catch(Exception $e){
                    $mailError = "Wystąpił błąd podczas wysyłania wiadomości";
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
                <div class="h1">Formularz kontaktowy:</div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" novalidate>
                        <div class="form-group">
                            <label for="email">E-mail:</label></br>
                            <input type="email" name="email" class="form-control border border-dark" value="<?php echo $emailLogin; ?>" required>
                            <span class="text-danger"><?php echo $emailErr; ?></span></br>
                        </div>
                        <div class="form-group">
                            <label for="topic">Temat:</label></br>
                            <input type="text" name="topic" class="form-control border border-dark" required>
                            <span class="text-danger"><?php echo $topicErr; ?></span></br>
                        </div>
                        <div class="form-group">
                            <label for="content">Treść:</label></br>
                            <textarea name="content" class="form-control border border-dark" required></textarea>
                            <span class="text-danger"><?php echo $contentErr; ?></span></br>
                        </div>

                        
                        <input type="submit" class="btn btn-dark" value="Wyślij">
                        <span class="text-danger"><?php $mailError ?></span>
                        <span class="text-success"><?php $mailSuccess ?></span>
                    </form>
                </div>
                
            </main>
        </div>
        <footer class="text-center text-lg-start">
					<div class="text-center p-3">2023 Tomasz Wilk</div>
		</footer>
    </body>
    
</html>
