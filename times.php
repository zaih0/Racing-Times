<?php
    // Database connection parameters
    $host = 'localhost'; // Database host
    $dbname = 'db_racetimes'; // Database name
    $username = 'root'; // Database username
    $password = 'root'; // Database password

    try {
        // Create a PDO instance
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if form data is submitted
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Retrieve and sanitize inputs
                $name = htmlspecialchars($_POST['name']);
                $time = $_POST['time'];
                $date = date('Y-m-d'); // Get current date



            // Prepare SQL statement
                $stmt = $pdo->prepare("INSERT INTO tb_racingtimes (name, time, date) VALUES (:name, :time, :date)");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':time', $time);
                $stmt->bindParam(':date', $date);

            // Execute the statement
                if ($stmt->execute()) {
                echo "Record successfully saved.";
                } else {
                echo "Error saving record.";
                }
            }
        } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
            }
?>