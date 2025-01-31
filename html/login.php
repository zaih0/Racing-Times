<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection parameters
$host = 'localhost'; // Database host
$dbname = 'db_racetimes'; // Database name
$username = 'root'; // Database username
$password = 'root'; // Database password;

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database connected successfully!"; // Debugging line
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo "Form submitted!<br>"; // Debugging
    $stmt = $conn->prepare("SELECT * FROM tb_userdata WHERE username = :username");
    $stmt->bindParam(':username', $_POST["username"]);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
}if ($user) {
        echo "User found in database.<br>";
    } else {
        echo "No user found.<br>";
    }

    
if ($user && password_verify($_POST["password"], $user["password"])) {
    echo "✅ Password verification successful!<br>";
} else {
     echo "❌ Password verification failed!<br>";
    }
        // Check if the password needs rehashing (e.g., algorithm update)
    if (password_needs_rehash($user["password"], PASSWORD_DEFAULT)) {
        $newHashedPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);
    
        // Update the database with the new hashed password
        $updateStmt = $conn->prepare("UPDATE tb_userdata SET password = :new_password WHERE username = :username");
        $updateStmt->bindParam(':new_password', $newHashedPassword);
        $updateStmt->bindParam(':username', $user["username"]);
        $updateStmt->execute();
    
    session_start();
        // Store user data in session and redirect
    $_SESSION["username"] = $user["username"];
    $_SESSION["user_id"] = $user["id"];
    
    header("Location: ../index.php");
    exit();
} else {
        $error = "Invalid username or password.";
    }

?>