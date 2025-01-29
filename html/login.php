<?php
    require_once '../db_connect.php';
try {

    // Verbinden met de database met PDO

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    die("Fout bij verbinding: " . $e->getMessage());

}

 

// Controleren of het formulier is ingediend

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Valideren van invoer
    if (empty($name) || empty($email) || empty($password)) {
        echo "Alle velden zijn verplicht.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Ongeldig e-mailadres.";
    } else {

        // Wachtwoord hashen
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        try {
            // Voorbereide SQL-query
            $sql = "INSERT INTO tb_userdata (name, email, password) VALUES (:name, :email, :password)";
            $stmt = $pdo->prepare($sql);
            // Waarden binden
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            // Query uitvoeren
            $stmt->execute();
            echo "Registratie succesvol!";
        } catch (PDOException $e) {

            echo "Fout bij opslaan: " . $e->getMessage();

        }

    }

} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    // Valideren van invoer
    if (empty($email) || empty($password)) {
        echo "Alle velden zijn verplicht.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Ongeldig e-mailadres.";
    } else {
        try {
            // Voorbereide SQL-query om gebruiker op te halen
            $sql = "SELECT * FROM tb_userdata WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            // Waarde binden
            $stmt->bindParam(':email', $email);
            // Query uitvoeren
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user && password_verify($password, $user['password'])) {
                echo "Login succesvol! Welkom, " . htmlspecialchars($user['name']) . "!";
            } else {
                echo "Ongeldige inloggegevens.";
            }
        } catch (PDOException $e) {
            echo "Fout bij inloggen: " . $e->getMessage();
        }

    }

}

?>

