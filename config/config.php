<?php
    $host = "localhost";   
    $user = "root";        
    $pass = "";            
    $db   = "carwash_db";  

    // Create connection
    $conn = new mysqli($host, $user, $pass, $db);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        echo "✅ Database connected successfully!";
    }
?>