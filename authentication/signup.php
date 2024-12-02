<?php

    $fullName = $_POST["fullName"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];


// Get user input from the form
$fullName = htmlspecialchars($_POST['fullName']); // Sanitize input
$username = htmlspecialchars($_POST['username']); // Sanitize input
$email = htmlspecialchars($_POST['email']); // Sanitize input
$password = htmlspecialchars($_POST['password']); // Sanitize input
$confirmPassword = htmlspecialchars($_POST['confirmPassword']); // Sanitize input

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if the passwords match
        if ($password != $confirmPassword) {
            echo "Passwords do not match. Please try again.";
        } else {
            // Display the submitted information
            echo "<h2>Your Input:</h2>";
            echo "Full Name: " . $fullName . "<br>";
            echo "Username: " . $username . "<br>";
            echo "Email: " . $email . "<br>";
            echo "Password: " . str_repeat("*", strlen($password)) . "<br>"; // Display asterisks for security
            echo "Password Confirmation: " . str_repeat("*", strlen($confirmPassword)) . "<br>";
        }
    }

    
    session_start();
    $fullName = $_POST["fullName"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    /*
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(trim($password) == trim($confirmPassword))
        {  
            $host = "localhost";
            $database = "blogging";
            $dbuserame = "root";
            $dbpassword = "";
            
            $dsn = "mysql: host=$host;dbname=$database;";
            try {
                $conn = new PDO($dsn, $dbuserame, $dbpassword);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $stmt = $conn->prepare("INSERT INTO users (fullName,username,password,created_at,updated_at) VALUES (:p_fullName,:p_username,:p_password,NOW(),NOW())");
                
                $stmt->bindParam(':p_fullName', $fullName);
                $stmt->bindParam(':p_username', $username);
                $stmt->bindParam(':p_password', $password);
                
                $password = password_hash(trim($password),PASSWORD_BCRYPT);
               
                if($stmt->execute()){
                    header("location: /signup.php");
                    $_SESSION["success"] = "Registration Successful";
                    exit;
                  
                }else{
                    header("location: /signup.php");
                    $_SESSION["error"] = "Insert Error";
                    exit;
                }

            } catch (Exception $e){
                header("location: /signup.php");
                $_SESSION["error"]="Username Already Exist";
                }
            
        }
        else{
            header("location: /signup.php");
            $_SESSION["error"]="Password Incorrect";
            exit;
        }              
    }*/
?>