<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "db_racetimes";

try {
    // Verbinden met de database met PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Fout bij verbinding: " . $e->getMessage());
}

// Controleren of het formulier is ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['naam'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['psw'] ?? ''; // Update password field
    $passwordRepeat = $_POST['psw-repeat'] ?? ''; // Added repeat password check

    // Valideren van invoer
    if (empty($name) || empty($email) || empty($password) || empty($passwordRepeat)) {
        echo "Alle velden zijn verplicht.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Ongeldig e-mailadres.";
    } elseif ($password !== $passwordRepeat) {
        echo "Wachtwoorden komen niet overeen.";
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
            header("Location: /index.php"); // Doorsturen naar main.php
            exit; // Stop verdere uitvoering van de script
        } catch (PDOException $e) {
            echo "Fout bij opslaan: " . $e->getMessage();
        }
    }
}
?>
