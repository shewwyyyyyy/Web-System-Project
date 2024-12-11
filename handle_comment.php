<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"]."/backend/config/DatabaseConnect.php");

header('Content-Type: application/json');

// Simulate user authentication (replace with actual auth logic)
$user_id = $_SESSION['user_id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new DatabaseConnect();
    $conn = $db->connectDB();
    $post_id = $_POST['post_id'] ?? null;
    $content = $_POST['content'] ?? null;

    if ($post_id && $content) {
        $insert_sql = "INSERT INTO comments (post_id, user_id, content, created_at) VALUES (:post_id, :user_id, :content, NOW())";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $insert_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $insert_stmt->bindParam(':content', $content, PDO::PARAM_STR);

        if ($insert_stmt->execute()) {
            $comment_id = $conn->lastInsertId();

            // Fetch the newly inserted comment
            $fetch_sql = "SELECT c.comment_id, c.content, c.created_at, u.username 
                          FROM comments c 
                          JOIN users u ON c.user_id = u.user_id 
                          WHERE c.comment_id = :comment_id";
            $fetch_stmt = $conn->prepare($fetch_sql);
            $fetch_stmt->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
            $fetch_stmt->execute();
            $new_comment = $fetch_stmt->fetch(PDO::FETCH_ASSOC);

            echo json_encode([
                'success' => true,
                'comment' => $new_comment
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to insert comment']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
