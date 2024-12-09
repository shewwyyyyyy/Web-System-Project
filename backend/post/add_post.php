<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"]."/backend/config/Directories.php");
include('../config/DatabaseConnect.php');

$db = new DatabaseConnect();
$conn = $db->connectDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $postTitle    = htmlspecialchars($_POST["title"]);
    $postContent  = htmlspecialchars($_POST["content"]);
    $postCategory = htmlspecialchars($_POST["category"]);
    $image = $_FILES["image"];
    $imageFileType = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));
    $target_dir = $_SERVER["DOCUMENT_ROOT"] . "/uploads/";
    
    // Generate a random file name to avoid duplication
    $random_file_name = uniqid() . '.' . $imageFileType;
    $target_file = $target_dir . $random_file_name;
    
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        exit();
    }

    // Ensure the target directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Move the uploaded file to the target directory
    if (!move_uploaded_file($image["tmp_name"], $target_file)) {
        echo "Sorry, there was an error uploading your file.";
        exit();
    }

    // Get the relative path to save in the database
    $image_path = "/uploads/" . $random_file_name;

    try {
        date_default_timezone_set('Asia/Manila');
        $date_today = date('Y-m-d H:i:s');
        $stmt = $conn->prepare('INSERT INTO posts (user_id, title, content, category, image, created_at, updated_at) VALUES (:user_id, :title, :content, :category, :image, :created_at, :updated_at)');
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':title', $postTitle);
        $stmt->bindParam(':content', $postContent);
        $stmt->bindParam(':category', $postCategory);
        $stmt->bindParam(':image', $image_path);
        $stmt->bindParam(':created_at', $date_today);
        $stmt->bindParam(':updated_at', $date_today);
        $stmt->execute();
        $_SESSION["success"] = "Post created successfully!";
        header("Location: /index.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    exit();
}
?>