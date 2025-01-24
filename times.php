<?php

    session_start();

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
                $map = htmlspecialchars($_POST['map']);
                $car_type =htmlspecialchars($_POST['car_type']);



            // Prepare SQL statement
                $stmt = $pdo->prepare("INSERT INTO tb_racingtimes (name, time, date, map, car_type) VALUES (:name, :time, :date, :map, :car_type)");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':time', $time);
                $stmt->bindParam(':date', $date);
                $stmt->bindParam(':map', $map);
                $stmt->bindParam(':car_type', $car_type);


            // Execute the statement
                if ($stmt->execute()) {
                $_SESSION['record_saved'] = true;
                header("Location: index.php");
                } else {
                echo "Error saving record.";
                }
            }

            $fetchStmt = $pdo->prepare("SELECT * FROM tb_racingtimes");
            $fetchStmt->execute();
            $records = $fetchStmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result = $mysqli->query($query)) {

                /* fetch associative array */
                while ($row = $result->fetch_assoc()) {
                    $field1name = $row["col1"];
                    $field2name = $row["col2"];
                    $field3name = $row["col3"];
                    $field4name = $row["col4"];
                    $field5name = $row["col5"];
                }
            
                /* free result set */
                $result->free();
            }
        } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
            }
?>