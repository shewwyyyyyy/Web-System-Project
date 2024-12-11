<?php
// handle_vote.php

// Assuming you have already connected to the database
include('backend/config/DatabaseConnect.php'); 
session_start();
$db = new DatabaseConnect(); 
$conn = $db->connectDB();

$vote_type = $_POST['vote_type'] ?? null;
$post_id = $_POST['post_id'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;

if ($post_id && $vote_type && $user_id) {
    // Check if the user has already voted on this post
    $sql = "SELECT vote_type FROM votes WHERE post_id = :post_id AND user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $existing_vote = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing_vote) {
        // Update the existing vote
        $sql = "UPDATE votes SET vote_type = :vote_type WHERE post_id = :post_id AND user_id = :user_id";
    } else {
        // Insert a new vote
        $sql = "INSERT INTO votes (post_id, user_id, vote_type) VALUES (:post_id, :user_id, :vote_type)";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':vote_type', $vote_type, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch the updated vote counts
    $sql = "SELECT 
                (SELECT COUNT(*) FROM votes WHERE post_id = :post_id AND vote_type = 'upvote') as upvotes,
                (SELECT COUNT(*) FROM votes WHERE post_id = :post_id AND vote_type = 'downvote') as downvotes
            FROM votes
            WHERE post_id = :post_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->execute();
    $vote_counts = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'upvotes' => $vote_counts['upvotes'],
        'downvotes' => $vote_counts['downvotes'],
        'userVote' => $vote_type
    ]);
} else {
    echo json_encode(['post_id' => $post_id, 'vote_type' => $vote_type, 'user_id' => $user_id]);
    echo json_encode(['success' => false]);
}
?>