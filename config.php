<?php
    $servername = 'blogoinatorserver.mysql.database.azure.com';
    $username = 'blogoinatoradmin';
    $password = 'zaq1@WSX';
    $dbname = 'blog';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
?>