<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/backend/config/Directories.php");
include('../config/DatabaseConnect.php');

session_start(); // Ensure session is started at the beginning

// Check if user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    echo "User is not logged in.";
    exit();
}

$db = new DatabaseConnect();
$conn = $db->connectDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $postTitle    = htmlspecialchars($_POST["title"]);
    $postContent  = htmlspecialchars($_POST["content"]);
    $postCategory = htmlspecialchars($_POST["category"]);
    $image = $_FILES["image"];
    $attachments = $_FILES['attachments'];
    $imageFileType = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));
    $image_target_dir = $_SERVER["DOCUMENT_ROOT"] . "/uploads/images/";
    $attachment_target_dir = $_SERVER["DOCUMENT_ROOT"] . "/uploads/attachments/";
    
    // Generate a random file name to avoid duplication
    $random_file_name = uniqid() . '.' . $imageFileType;
    $target_file = $image_target_dir . $random_file_name;
    
    // Allow certain file formats
    $allowed_image_types = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowed_image_types)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        exit();
    }

    // Ensure the target directory exists
    if (!is_dir($image_target_dir)) {
        mkdir($image_target_dir, 0777, true);
    }

    // Move the uploaded file to the target directory
    if (!move_uploaded_file($image["tmp_name"], $target_file)) {
        echo "Sorry, there was an error uploading your file.";
        exit();
    }

    // Get the relative path to save in the database
    $image_path = "/uploads/images/" . $random_file_name;

    // Handle attachment uploads
    $attachment_paths = [];
    $allowed_attachment_types = ["pdf", "doc", "docx", "txt"];
    if (is_array($attachments['name'])) {
        foreach ($attachments['name'] as $key => $attachment_name) {
            $attachmentFileType = strtolower(pathinfo($attachment_name, PATHINFO_EXTENSION));
            $random_attachment_name = uniqid() . '.' . $attachmentFileType;
            $target_attachment_file = $attachment_target_dir . $random_attachment_name;

            // Allow certain file formats for attachments
            if (!in_array($attachmentFileType, $allowed_attachment_types)) {
                echo "Sorry, only PDF, DOC, DOCX & TXT files are allowed for attachments.";
                exit();
            }

            // Ensure the target directory exists
            if (!is_dir($attachment_target_dir)) {
                mkdir($attachment_target_dir, 0777, true);
            }

            // Move the uploaded attachment to the target directory
            if (!move_uploaded_file($attachments["tmp_name"][$key], $target_attachment_file)) {
                echo "Sorry, there was an error uploading your attachment.";
                exit();
            }

            // Get the relative path to save in the database
            $attachment_paths[] = "/uploads/attachments/" . $random_attachment_name;
        }
    }

    // Convert attachment paths array to JSON for storage
    $attachment_paths_json = json_encode($attachment_paths);

    try {
        date_default_timezone_set('Asia/Manila');
        $date_today = date('Y-m-d H:i:s');
        $stmt = $conn->prepare('INSERT INTO posts (user_id, title, content, category, image, attachments, created_at, updated_at) VALUES (:user_id, :title, :content, :category, :image, :attachments, :created_at, :updated_at)');
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':title', $postTitle);
        $stmt->bindParam(':content', $postContent);
        $stmt->bindParam(':category', $postCategory);
        $stmt->bindParam(':image', $image_path);
        $stmt->bindParam(':attachments', $attachment_paths_json);
        $stmt->bindParam(':created_at', $date_today);
        $stmt->bindParam(':updated_at', $date_today);
        $stmt->execute();
        $_SESSION["success"] = "Post created successfully!";
        header("Location: /index.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>