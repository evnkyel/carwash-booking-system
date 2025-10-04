<?php
    $host = "localhost";   
    $user = "root";        
    $pass = "";            
    $db   = "carwash_db";  

    // Create connection
    $conn = new mysqli($host, $user, $pass, $db);

    // Check connection
    if ($conn) {
        echo "Database connected successfully!";
    } else {
        echo "Connection failed";
    }
?>