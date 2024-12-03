<?php
// Początek sesji
session_start();

// Zniszcz sesję
session_destroy();

// Przekieruj na stronę główną po wylogowaniu
header("Location: index.php");
exit();
?>
