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

    /*
    // Handle image upload
    $target_dir = "../uploads/"; 
    $target_file = $target_dir . basename($image["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($image["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        exit();
    }

    // Check file size
    if ($image["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        exit();
    }
        */

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        exit();
    }

    // Move the uploaded file to the target directory
    if (!move_uploaded_file($image["tmp_name"], $target_file)) {
        echo "Sorry, there was an error uploading your file.";
        exit();
    }

    try {
        $stmt = $conn->prepare('INSERT INTO posts (user_id, title, content, category, image) VALUES (:user_id, :title, :content, :category, :image)');
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':image', $target_file);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    header("Location: /index.php");
    exit();
}
?>