<?php

    // Database connection parameters
    $host = 'localhost'; // Database host
    $dbname = 'db_racetimes'; // Database name
    $username = 'root'; // Database username
    $password = 'root'; // Database password



            // Establishing a connection to the database
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare SQL statement to insert data
            $stmt = $conn->prepare("INSERT INTO tb_racetimes (name, time, map, car_type) VALUES (:name, :time, :map, :car_type)");

            // Bind parameters to the prepared statement
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':time', $time);
            $stmt->bindParam(':map', $map);
            $stmt->bindParam(':car_type', $car_type);

            // Execute the statement to insert the data
            $stmt->execute();




        // Close the database connection
