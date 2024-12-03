<?php
    $servername = 'blogoinatorserver.mysql.database.azure.com';
    $username = 'blogoinatoradmin@blogoinatorserver';
    $password = 'zaq1@WSX';
    $dbname = 'blog';

    $mysqli = new mysqli($servername, $username, $password, $dbname, 3306);

    // Użyj SSL
    $mysqli->ssl_set(NULL, NULL, "DigiCertGlobalRootCA.crt.pem", NULL, NULL); // Upewnij się, że ścieżka do certyfikatu jest poprawna
    if (!$mysqli->real_connect($servername, $username, $password, $dbname, 3306, NULL, MYSQLI_CLIENT_SSL)) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    echo "Connected successfully with SSL!";
?>
