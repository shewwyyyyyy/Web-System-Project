<?php
session_start();

// Ensure the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $fullName = htmlspecialchars($_POST['fullName']);
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $confirmPassword = htmlspecialchars($_POST['confirmPassword']);

    // Check if the passwords match
    if ($password != $confirmPassword) {
        $_SESSION["error"] = "Passwords do not match.";
        header("Location: /signup.php");
        exit;
    }

    // Database credentials
    $host = "localhost";
    $database = "blogging";
    $dbusername = "root";
    $dbpassword = "";

    // DSN (Data Source Name) for MySQL
    $dsn = "mysql:host=$host;dbname=$database;";

    try {
        // Create a new PDO instance for database connection
        $conn = new PDO($dsn, $dbusername, $dbpassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Fetch associative arrays

        // Prepare SQL query to insert user data into the 'users' table
        $stmt = $conn->prepare("INSERT INTO users (fullName, username, email, password, created_at, updated_at)
                                VALUES (:p_fullName, :p_username, :p_email, :p_password, NOW(), NOW())");

        // Bind parameters to the prepared statement
        $stmt->bindParam(':p_fullName', $fullName);
        $stmt->bindParam(':p_username', $username);
        $stmt->bindParam(':p_email', $email);
        $stmt->bindParam(':p_password', $password);

        // Hash the password before storing it in the database
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Execute the prepared statement
        if ($stmt->execute()) {
            $_SESSION["success"] = "Registration Successful!";
            header("Location: /login.php");
            exit;
        } else {
            $_SESSION["error"] = "There was an error during registration.";
            header("Location: /signup.php");
            exit;
        }

    } catch (PDOException $e) {
        $_SESSION["error"] = "Database connection failed: " . $e->getMessage();
        header("Location: /signup.php");
        exit;
    }
}
?>
