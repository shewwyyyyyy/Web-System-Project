<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"]."/backend/config/Directories.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/backend/config/DatabaseConnect.php");

$db = new DatabaseConnect();
$conn = $db->connectDB();

$sql = "SELECT p.post_id, p.title, p.image, p.content, u.username, u.user_id, p.created_at, 
               (SELECT COUNT(*) FROM votes WHERE post_id = p.post_id AND vote_type = 'upvote') as upvotes,
               (SELECT COUNT(*) FROM votes WHERE post_id = p.post_id AND vote_type = 'downvote') as downvotes,
               (SELECT COUNT(*) FROM comments WHERE post_id = p.post_id) as comment_count,
               (SELECT vote_type FROM votes WHERE post_id = p.post_id AND user_id = :user_id) as user_vote
        FROM `posts` p
        JOIN users u ON p.user_id = u.user_id
        ORDER BY p.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!function_exists('time_elapsed_string')) {
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
}
?>

<!-- Reddit-like Guest Feed -->
<div class="max-w-2xl mx-auto p-4 ">
    <?php foreach ($posts as $post): ?>
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="p-4">
                <div class="flex items-center mb-2">
                    <div class="bg-gray-300 h-8 w-8 rounded-full mr-2"></div>
                    <div>
                        <h3 class="text-sm font-medium">
                            <a href="<?php echo ($post['user_id'] == $_SESSION['user_id']) ? 'profile.php' : 'public_profile.php?user_id=' . htmlspecialchars($post['user_id']); ?>" class="text-blue-500 hover:underline">
                                <?php echo htmlspecialchars($post['username']); ?>
                            </a>
                        </h3>
                        <p class="text-xs text-gray-500">Posted <?php echo time_elapsed_string($post['created_at']); ?></p>
                    </div>
                </div>
                <h2 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($post['title']); ?></h2>
                <p class="text-gray-700 mb-4"><?php echo htmlspecialchars($post['content']); ?></p>
                <?php if (!empty($post['image'])): ?>
                    <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Post image" class="w-full h-[480px] object-cover mb-4 rounded">
                <?php endif; ?>
                <?php if (!empty($post['attachments'])): ?>
                    <?php $attachments = json_decode($post['attachments'], true); ?>
                    <?php if (is_array($attachments)): ?>
                        <div class="attachments mb-4">
                            <?php foreach ($attachments as $attachment): ?>
                                <a href="<?php echo htmlspecialchars($attachment); ?>" target="_blank" class="block text-blue-500 hover:underline">Download Attachment</a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="flex items-center space-x-4 text-sm">
                    <div class="flex items-center space-x-1">
                        <button class="vote-button upvote <?php echo $post['user_vote'] === 'upvote' ? 'text-orange-500' : 'text-gray-500'; ?> hover:text-orange-500" data-post-id="<?php echo $post['post_id']; ?>" data-vote-type="upvote">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                        </button>
                        <span class="font-medium vote-count"><?php echo $post['upvotes'] - $post['downvotes']; ?></span>
                        <button class="vote-button downvote <?php echo $post['user_vote'] === 'downvote' ? 'text-blue-500' : 'text-gray-500'; ?> hover:text-blue-500" data-post-id="<?php echo $post['post_id']; ?>" data-vote-type="downvote">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                    </div>
                    <button class="flex items-center space-x-1 text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        <span class="comment-count"><?php echo $post['comment_count']; ?> Comments</span>
                    </button>
                    <button class="flex items-center space-x-1 text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                        <span>Share</span>
                    </button>
                </div>
            </div>
            <div class="bg-gray-50 p-4 border-t">
                <h4 class="text-sm font-medium mb-2">Comments</h4>
                <div class="space-y-2 comments-container" data-post-id="<?php echo $post['post_id']; ?>">
                    <?php 
                    $commentSql = "SELECT c.comment_id, c.content, c.created_at, u.username, u.user_id 
                                   FROM comments c 
                                   JOIN users u ON c.user_id = u.user_id 
                                   WHERE c.post_id = :post_id 
                                   ORDER BY c.created_at ASC 
                                   LIMIT 5";
                    $commentStmt = $conn->prepare($commentSql);
                    $commentStmt->bindParam(':post_id', $post['post_id']);
                    $commentStmt->execute();
                    $comments = $commentStmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($comments as $comment):
                    ?>
                        <div class="flex space-x-2">
                            <div class="bg-gray-300 h-6 w-6 rounded-full"></div>
                            <div>
                                <p class="text-sm">
                                    <span class="font-medium">
                                        <a href="<?php echo ($comment['user_id'] == $_SESSION['user_id']) ? 'profile_feed.php' : 'public_profilefeed.php?user_id=' . htmlspecialchars($comment['user_id']); ?>" class="text-blue-500 hover:underline">
                                            <?php echo htmlspecialchars($comment['username']); ?>
                                        </a>
                                    </span>
                                    <?php echo htmlspecialchars($comment['content']); ?>
                                </p>
                                <p class="text-xs text-gray-500"><?php echo time_elapsed_string($comment['created_at']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>