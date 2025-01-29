<?php

    // Database connection parameters
    $host = 'localhost'; // Database host
    $dbname = 'db_racetimes'; // Database name
    $username = 'root'; // Database username
    $password = 'root'; // Database password

try {
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

            echo "<h2 style='position: absolute; float:right; background: red; color: white;'>Added new racer!</h2>";

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        // Close the database connection
        $conn = null;