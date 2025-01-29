<?php
session_start();
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


echo "</table>";
?>

<div>
    <h1>Racetimes</h1>
    <button id="btn">
        <a href="../Racing-Times/html/signup.html">Sign up!</a>
    </button>
    <button>
        <a href="../Racing-Times/html/login.hml">Login</a>
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