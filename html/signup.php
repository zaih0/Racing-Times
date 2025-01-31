<?php
session_start();

$host = "localhost";
$username = "root";
$password = "root";
$dbname = "db_racetimes";

try {
    // Verbinden met de database met PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Controleren of het formulier is ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['psw'] ?? ''; // Update password field
    $passwordRepeat = $_POST['psw-repeat'] ?? ''; // Added repeat password check
    

    // Valideren van invoer
    if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat)) {
        echo "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
    } elseif ($password !== $passwordRepeat) {
        echo "Passwords do not match.";
    } else {
        // Wachtwoord hashen
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Voorbereide SQL-query
            $sql = "INSERT INTO tb_userdata (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $pdo->prepare($sql);

            // Waarden binden
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);

            // Query uitvoeren
            $stmt->execute();

            // Succesbericht en doorverwijzing naar main.php
            echo "Registratie succesvol!";
            header("Location: ../index.php"); // Doorsturen naar main.php
            exit; // Stop verdere uitvoering van de script
        } catch (PDOException $e) {
            echo "Fout bij opslaan: " . $e->getMessage();
        }
    }
}
?>
