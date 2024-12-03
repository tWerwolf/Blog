<?php
    session_start(); 
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && isset($_SESSION["role"]) && $_SESSION["role"] == "Author"){
        echo '<nav class="navbar navbar-expand-md bg-dark navbar-dark justify-content-center">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="index.php">GuitarWolf</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="collapsibleNavbar">
                                <ul class="navbar-nav">
                                    <li class="nav-item"><a class="nav-link" href="index.php">Posty</a></li>
                                    <li class="nav-item"><a class="nav-link" href="contact.php">Kontakt</a></li>
                                </ul>
                                <ul class="nav navbar-nav ms-auto">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Twoje konto</a>
                                        <div class="dropdown-menu dropdown-menu-dark">
                                            <a class="dropdown-item" href="profilePage.php">Twój panel</a>
                                            <a class="dropdown-item" href="logout.php">Wyloguj się</a>
                                        </div>
                                    </li>
                                </ul>
                            
                        </div>
                    </div>
                </nav>';
    }else if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && isset($_SESSION["role"]) && $_SESSION["role"] == "Admin"){
        echo '<nav class="navbar navbar-expand-md bg-dark navbar-dark justify-content-center">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php">GuitarWolf</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="collapsibleNavbar">
                            <ul class="navbar-nav">
                                <li class="nav-item"><a class="nav-link" href="index.php">Posty</a></li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Panel administracyjny</a>
                                    <div class="dropdown-menu dropdown-menu-dark">
                                        <a class="dropdown-item" href="manageUsers.php">Zarządzanie użytkownikami</a>
                                        <a class="dropdown-item" href="manageArticles.php">Zarządzanie postami</a>
                                    </div>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="contact.php">Kontakt</a></li>
                            </ul>
 
                            <ul class="nav navbar-nav ms-auto">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Twoje konto</a>
                                    <div class="dropdown-menu dropdown-menu-dark">
                                        <a class="dropdown-item" href="profilePage.php">Twój panel</a>
                                        <a class="dropdown-item" href="logout.php">Wyloguj się</a>
                                    </div>
                                </li>
                            </ul>
                        
                    </div>
                </div>
            </nav>';
    }
    else{
        echo '<nav class="navbar navbar-expand-md bg-dark navbar-dark justify-content-center">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="index.php">GuitarWolf</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="collapsibleNavbar">
                                <ul class="navbar-nav">
                                    <li class="nav-item"><a class="nav-link" href="index.php">Posty</a></li>
                                    <li class="nav-item"><a class="nav-link" href="contact.php">Kontakt</a></li>
                                </ul>
                            
                            
                                <ul class="nav navbar-nav ms-auto">
                                    <li class="nav-item"><a class="nav-link" href="login.php">Zaloguj się</a></li>
                                </ul>
                            
                        </div>
                    </div>
                </nav>';
    }

?>
