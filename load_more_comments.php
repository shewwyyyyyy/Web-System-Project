<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"]."/backend/config/DatabaseConnect.php");

header('Content-Type: application/json');

$db = new DatabaseConnect();
$conn = $db->connectDB();

$post_id = filter_input(INPUT_GET, 'post_id', FILTER_VALIDATE_INT);
$offset = filter_input(INPUT_GET, 'offset', FILTER_VALIDATE_INT);

if ($post_id !== false && $offset !== false) {
    $sql = "SELECT c.comment_id, c.content, c.created_at, u.username 
            FROM comments c 
            JOIN users u ON c.user_id = u.user_id 
            WHERE c.post_id = :post_id 
            ORDER BY c.created_at ASC 
            LIMIT 5 OFFSET :offset";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format the created_at date
    foreach ($comments as &$comment) {
        $comment['created_at'] = time_elapsed_string($comment['created_at']);
    }

    echo json_encode(['success' => true, 'comments' => $comments]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime; 
    $ago = new DateTime($datetime, new DateTimeZone('Asia/Manila')); 
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

