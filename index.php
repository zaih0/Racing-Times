<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["name"]) && isset($_POST["time"]) && isset($_POST["map"]) && isset($_POST["car_type"])) {

        // Retrieve form data
        $name = $_POST["name"];
        $time = $_POST["time"];
        $map = $_POST["map"];
        $car_type = $_POST["car_type"];

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
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Racing-Times/css/index.css">
    <title>Racing Times</title>
</head>
<body>
<?php
echo "<table style='border: solid 1px black;  background: black; color: black; width: 200px; position: absolute; right:0vw ; top: 0vh; overflow: scroll;'>";
echo "<tr><th>ID</th><th>Name</th><th>Time</th><th>Map</th><th>Car Type</th>";



try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password); // Fixed connection string
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
?>

<div>
    <h1>Racetimes</h1>
    <button id="btn">
        <a href="../Racing-Times/html/signup.html">Sign up!</a>
    </button>
    <button>
        <a href="../Racing-Times/html/login.html">Login</a>
    </button>
    <form action="index.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="time">Time:</label>
        <input type="time" id="time" name="time" step="2" required><br><br>
        <label for="map">Map:</label>	
        <input type="text" id="map" name="map" required><br><br>
        <label for="car_type">Car:</label>
        <input type="text" id="car_type" name="car_type" required><br><br>  
        <button type="submit">Submit</button>
        </form>
</div>
</body>
</html>