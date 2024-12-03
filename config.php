<?php
    $servername = 'blogoinatorserver.mysql.database.azure.com';
    $username = 'blogoinatoradmin@blogoinatorserver';
    $password = 'zaq1@WSX';
    $dbname = 'blog';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $mysqli->ssl_set(NULL, NULL, "DigiCertGlobalRootCA.crt.pem", NULL, NULL);  // Wskaż ścieżkę do certyfikatu
    if (!$mysqli->real_connect($servername, $username, $password, $dbname, 3306, NULL, MYSQLI_CLIENT_SSL)) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    echo "Connected successfully with SSL!";
?>
