<?php
    require_once "config.php";

    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css.css">
    </head>

    <body>
        <div class="container-flex">
            <div class="container"> 
                <?php
                    require 'navbar.php';
                ?>
                
                <main> 

                    <?php
                        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && isset($_SESSION["role"]) && $_SESSION["role"] == "Admin"){
                            $sql = $conn->prepare("SELECT User_Id, Name, LastName, Email, Role FROM users");
                            $sql->execute();
                            $sql->store_result();
                            $sql->bind_result($id, $name, $lastName, $email, $role);
                            if($sql->num_rows > 0){
                                echo '
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title text-uppercase mb-0">Zarządzaj użytkownikami</h5>
                                                </div>
                                                
                                                
                                                    <div class="mb-0">
                                                        <div class="row">
                                                            <div class="col border-0 font-medium ps-4">ID</div>
                                                            <div class="col border-0 font-medium">Imię</div>
                                                            <div class="col border-0 font-medium">Nazwisko</div>
                                                            <div class="col border-0 font-medium">Email</div>
                                                            <div class="col border-0 font-medium">Rola</div>
                                                            <div class="col border-0 font-medium">Zarządzaj</div>
                                                        </div>
                                                    </div>';

                                while($sql->fetch()){
                                    echo '<form action="save.php" method="POST">
                                            <div class="row">
                                                <div class="col ps-4"><input type="hidden" name="id" value='.$id.'>'.$id.'</div>
                                                <div class="col">
                                                    <input type="text" name="name" value="'.$name.'"><br>
                                                    <span class="text-danger">';
                                    if(isset($_SESSION["iderr"]) && $id==$_SESSION["iderr"]){
                                        echo $_SESSION["nameErr"];
                                    }
                                    echo '</span>
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="lastName" value="'.$lastName.'"><br>
                                                    <span class="text-danger">';
                                    if(isset($_SESSION["iderr"]) && $id==$_SESSION["iderr"]){
                                        echo $_SESSION["lastNameErr"];
                                    }
                                    echo '</span>
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="email" value="'.$email.'"><br>
                                                    <span class="text-danger">';
                                    if(isset($_SESSION["iderr"]) && $id==$_SESSION["iderr"]){
                                        echo $_SESSION["emailErr"];
                                    }
                                    echo '</span>
                                                </div>
                                                <div class="col">
                                                    <select style="width:auto;" class="form-select form-select-* category-select" name="role">
                                                        <option value="Author" ';
                                    if($role == "Author") echo "selected";
                                    echo '>Autor</option>
                                                        <option value="Admin" ';
                                    if($role == "Admin") echo "selected";
                                    echo'>Administrator</option>
                                                    </select>
                                                </div>
                                                
                                                    <div class="col">
                                                        <label for="submit'.$id.'" class="btn btn-outline-success btn-circle btn-lg btn-circle"><i class="bi bi-floppy"></i></label>
                                                        <input id="submit'.$id.'" name="submit'.$id.'" type="submit" class="d-none">
                                                        
                                                        <button type="button" class="btn btn-outline-danger btn-circle btn-lg btn-circle" onclick="javascript:location.href=`deleteUser.php?id='.$id.'`"><i class="bi bi-trash"></i></button>
                                                    </div>  
                                                    </div>     
                                            </form>                                            
                                        ';
                                }

                                echo '                  
                                                </div>
                                            
                                        ';
                            }
                        }else{
                            echo "Wow, trochę się zagalopowałeś! Nie masz uprawnień by tu być! Wróć na stronę główną";
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
