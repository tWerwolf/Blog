<?php
    $con = mysqli_init();
    mysqli_ssl_set($con,NULL,NULL, "DigiCertGlobalRootCA.crt.pem", NULL, NULL);
    mysqli_real_connect($conn, "blogoinatorserver.mysql.database.azure.com", "blogoinatoradmin", "zaq1@WSX", "blog", 3306, MYSQLI_CLIENT_SSL);
?>
