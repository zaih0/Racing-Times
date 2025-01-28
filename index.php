<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["name"]) && isset($_POST["time"]) && isset($_POST["map"]) && isset($_POST["car_type"])) {

        // Retrieve form data
        $name = $_POST["name"];
        $time = $_POST["time"];
        $map = $_POST["map"];
        $car_type = $_POST["car_type"];

        // Insert data into the database
        $servername = "localhost";
        $username = "root";
        $password = "Superpuck2000";
        $dbname = "db_racetimes"; // Correct database name

        try {
            // Establishing a connection to the database
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
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
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/index.css">
    <title>Racing Times</title>
</head>
<body>
<?php
echo "<div class='table-container'>";
echo "<table style='height: 10px; border: solid 1px black;  background: black; color: black; width: 200px; position: absolute; right:1vw ; top: 0vh; overflow-y: auto;'>";
echo "<tr><th>ID</th><th>Name</th><th>Time</th><th>Map</th><th>Car Type</th>";

$servername = "localhost";
$username = "root";
$password = "Superpuck2000";
$dbname = "db_racetimes";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password); // Fixed connection string
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetching data for the table
    $stmt = $conn->prepare("SELECT id, name, time, map, car_type FROM tb_racetimes");
    $stmt->execute();

    // Loop through the results and output them in the table
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        echo "<tr>";
        echo "<td style='width: 150px; border: 1px solid black;'>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td style='width: 150px; border: 1px solid black;'>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td style='width: 150px; border: 1px solid black;'>" . htmlspecialchars($row['time']) . "</td>";
        echo "<td style='width: 150px; border: 1px solid black;'>" . htmlspecialchars($row['map']) . "</td>";
        echo "<td style='width: 150px; border: 1px solid black;'>" . htmlspecialchars($row['car_type']) . "</td>";
        echo "</tr>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;

echo "</table>";
echo "</div>";
?>

<div>
    <h1>Racetimes</h1>
    <form action="index.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="time">Time:</label>
        <input type="timestamp" id="time" name="time" step="2" required><br><br>
        <label for="map">Map:</label>	
        <select name="map" required>
            <option value="Small">Small</option>
            <option value="Medium">Medium</option>
            <option value="Large">Large</option>
        </select><br><br>
        <label for="car_type">Car:</label>
        <select name="car_type" required>
            <option id="red" value="Red">Red</option>
            <option id="blue" value="Blue">Blue</option>
            <option id="green" value="Green">Green</option>
        </select><br><br>  
        <button type="submit">Submit</button>
        </form>
</div>
</body>
</html>