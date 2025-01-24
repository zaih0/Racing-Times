<?php

    session_start();

    if (isset($_SESSION['record_saved'])) {
        echo "Record saved successfully!";
        echo "<script>alert('Record saved successfully!');</script>";
        unset($_SESSION['record_saved']);
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
<script>
        document.getElementById('racingForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData(this);
            formData.append('ajax', true);

            fetch('racingtimes.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const table = document.getElementById('racingTable');
                        const newRow = document.createElement('tr');

                        newRow.innerHTML = `
                            <td class="profile">
                                <img src="https://via.placeholder.com/40" alt="User Avatar">
                                <span class="name">${data.record.name}</span>
                                <span class="country">${data.record.car_type}</span>
                            </td>
                            <td>${data.record.time}</td>
                            <td>${data.record.car_type}</td>
                            <td>${data.record.date}</td>
                            <td>${data.record.map}</td>
                        `;
                        table.appendChild(newRow);
                        alert('Record successfully saved.');
                    } else {
                        alert('Error: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while saving the record.');
                });
        });
    </script>
<body>

    <button id="btn">
        <a href="../Racing-Times/html/signup.html">Sign up!</a>
    </button>
    <button>
        <a href="../Racing-Times/html/login.html">Login</a>
    </button>

    <form action="times.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="time">Time:</label>
        <input type="time" id="time" name="time" required><br><br>
        <label for="map">Map:</label>	
        <input type="text" id="map" name="map" required><br><br>
        <label for="car_type">Car:</label>
        <input type="text" id="car_type" name="car_type" required><br><br>  

        <button type="submit">Submit</button>
    </form>

    <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Player</th>
                        <th>Time</th>
                        <th>Car Type</th>
                        <th>Date</th>
                        <th>Map</th>
                    </tr>
                </thead>
                <tbody id="racingTable">
                    <?php if (!empty($records)): ?>
                        <?php foreach ($records as $record): ?>
                            <tr>
                                <td class="profile">
                                    <img src="https://via.placeholder.com/40" alt="User Avatar">
                                    <span class="name"><?php echo htmlspecialchars($record['name']); ?></span>
                                    <span class="country"><?php echo strtoupper($record['car_type']); ?></span>
                                </td>
                                <td><?php echo htmlspecialchars($record['time']); ?></td>
                                <td><?php echo htmlspecialchars($record['car_type']); ?></td>
                                <td><?php echo htmlspecialchars($record['date']); ?></td>
                                <td><?php echo htmlspecialchars($record['map']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No records found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>


    
</body>
</html>