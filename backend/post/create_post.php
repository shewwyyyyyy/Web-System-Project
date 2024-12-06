<?php
// backend/posts/create_post.php
include('../config/DatabaseConnect.php');
session_start();

if (isset($_POST['title'], $_POST['content'], $_SESSION['user_id'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $title, $body);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
}