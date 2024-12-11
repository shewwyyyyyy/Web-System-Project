<?php 
include('backend/config/DatabaseConnect.php'); 
$db = new DatabaseConnect(); 
$conn = $db->connectDB();

// Simulate user authentication (replace with actual auth logic)
$user_id = $_SESSION['user_id'] ?? null;

$sql = "SELECT p.post_id, p.title, p.image, p.content, u.username, u.fullname, p.created_at, 
               (SELECT COUNT(*) FROM votes WHERE post_id = p.post_id AND vote_type = 'upvote') as upvotes,
               (SELECT COUNT(*) FROM votes WHERE post_id = p.post_id AND vote_type = 'downvote') as downvotes,
               (SELECT COUNT(*) FROM comments WHERE post_id = p.post_id) as comment_count,
               (SELECT vote_type FROM votes WHERE post_id = p.post_id AND user_id = :user_id) as user_vote
        FROM `posts` p
        JOIN users u ON p.user_id = u.user_id 
        WHERE p.category = :category
        ORDER BY p.created_at DESC"; 
$stmt = $conn->prepare($sql); 
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindParam(':category', $_SESSION['category']);
$stmt->execute(); 
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

function time_elapsed_string($datetime, $full = false) {
    // datetime gmt +8
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
?>

<!-- Reddit-like Guest Feed -->
<div class="max-w-2xl mx-auto p-4">
    <?php foreach ($posts as $post): ?>
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="p-4">
                <div class="flex items-center mb-2">
                    <div class="bg-gray-300 h-8 w-8 rounded-full mr-2"></div>
                    <div>
                        <h3 class="text-sm font-medium"><?php echo htmlspecialchars($post['username']); ?></h3>
                        <p class="text-xs text-gray-500">Posted <?php echo time_elapsed_string($post['created_at']); ?></p>
                    </div>
                </div>
                <h2 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($post['title']); ?></h2>
                <p class="text-gray-700 mb-4"><?php echo htmlspecialchars($post['content']); ?></p>
                <?php if (!empty($post['image'])): ?>
                    <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Post image" class="w-full h-[480px] object-cover mb-4 rounded">
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
                    $commentSql = "SELECT c.comment_id, c.content, c.created_at, u.username 
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
                                    <span class="font-medium"><?php echo htmlspecialchars($comment['username']); ?></span>
                                    <?php echo htmlspecialchars($comment['content']); ?>
                                </p>
                                <p class="text-xs text-gray-500"><?php echo time_elapsed_string($comment['created_at']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if ($post['comment_count'] > 5): ?>
                    <button class="text-sm text-blue-500 hover:underline mt-2 load-more-comments" data-post-id="<?php echo $post['post_id']; ?>">Load more comments</button>
                <?php endif; ?>
                <form class="mt-4 comment-form" data-post-id="<?php echo $post['post_id']; ?>">
                    <textarea class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" rows="2" placeholder="Add a comment..." required></textarea>
                    <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        Post Comment
                    </button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<!-- End of Reddit-like Guest Feed -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Voting functionality
    const voteButtons = document.querySelectorAll('.vote-button');
    
    voteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const postId = this.getAttribute('data-post-id');
            const voteType = this.getAttribute('data-vote-type');
            const voteCount = this.parentElement.querySelector('.vote-count');
            const upvoteButton = this.parentElement.querySelector('.upvote');
            const downvoteButton = this.parentElement.querySelector('.downvote');

            fetch('handle_vote.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `post_id=${postId}&vote_type=${voteType}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    voteCount.textContent = data.upvotes - data.downvotes;
                    
                    upvoteButton.classList.remove('text-orange-500');
                    downvoteButton.classList.remove('text-blue-500');
                    
                    if (data.userVote === 'upvote') {
                        upvoteButton.classList.add('text-orange-500');
                    } else if (data.userVote === 'downvote') {
                        downvoteButton.classList.add('text-blue-500');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });

    // Comment functionality
    const commentForms = document.querySelectorAll('.comment-form');

    commentForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const postId = this.getAttribute('data-post-id');
            const content = this.querySelector('textarea').value;
            const commentsContainer = document.querySelector(`.comments-container[data-post-id="${postId}"]`);
            const commentCount = this.closest('.bg-white').querySelector('.comment-count');

            fetch('handle_comment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `post_id=${postId}&content=${encodeURIComponent(content)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Create new comment element
                    const newComment = document.createElement('div');
                    newComment.className = 'flex space-x-2';
                    newComment.innerHTML = `
                        <div class="bg-gray-300 h-6 w-6 rounded-full"></div>
                        <div>
                            <p class="text-sm">
                                <span class="font-medium">${data.comment.username}</span>
                                ${data.comment.content}
                            </p>
                            <p class="text-xs text-gray-500">just now</p>
                        </div>
                    `;

                    // Add new comment to the top of the comments container
                    commentsContainer.appendChild(newComment);

                    // Clear the textarea
                    this.querySelector('textarea').value = '';

                    // Update comment count
                    const currentCount = parseInt(commentCount.textContent);
                    commentCount.textContent = `${currentCount + 1} Comments`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });

    // Load more comments functionality
    const loadMoreButtons = document.querySelectorAll('.load-more-comments');

    loadMoreButtons.forEach(button => {
        button.addEventListener('click', function() {
            const postId = this.getAttribute('data-post-id');
            const commentsContainer = document.querySelector(`.comments-container[data-post-id="${postId}"]`);
            const offset = commentsContainer.children.length;

            fetch(`load_more_comments.php?post_id=${postId}&offset=${offset}`)
            .then(response => response.json())
            .then(data => {
                if (data.comments.length > 0) {
                    data.comments.forEach(comment => {
                        const newComment = document.createElement('div');
                        newComment.className = 'flex space-x-2';
                        newComment.innerHTML = `
                            <div class="bg-gray-300 h-6 w-6 rounded-full"></div>
                            <div>
                                <p class="text-sm">
                                    <span class="font-medium">${comment.username}</span>
                                    ${comment.content}
                                </p>
                                <p class="text-xs text-gray-500">${comment.created_at}</p>
                            </div>
                        `;
                        commentsContainer.appendChild(newComment);
                    });

                    if (data.comments.length < 5) {
                        this.style.display = 'none';
                    }
                } else {
                    this.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
</script>
