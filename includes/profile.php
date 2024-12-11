<?php 

require_once($_SERVER["DOCUMENT_ROOT"]."/backend/config/Directories.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/backend/config/DatabaseConnect.php");
include_once('header.php');

$db = new DatabaseConnect(); 
$conn = $db->connectDB();

// Fetch user data based on user_id parameter or current session
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : $_SESSION['user_id'];
$sql = "SELECT username, FullName, email FROM users WHERE user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="path/to/your/css/file.css">
</head>
<body class="bg-gray-900 text-white min-h-screen">

  <!-- Main Container -->
  <div class="max-w-4xl mx-auto py-8 px-4">
    <!-- Profile Header -->
    <div class="flex items-center space-x-4">
      <!-- Avatar -->
      <div class="relative">
        <img src="path/to/default/avatar.jpg" alt="User Avatar" class="w-20 h-20 rounded-full border-2 border-gray-700">
        <div class="absolute bottom-0 right-0 bg-gray-800 p-1 rounded-full">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
          </svg>
        </div>
      </div>
      <!-- User Info -->
      <div>
        <h1 class="text-xl font-bold"><?php echo htmlspecialchars($user['FullName']); ?></h1>
        <h1 class="text-gray-400">@<?php echo htmlspecialchars($user['username']); ?></h1>
        <p class="text-gray-400"><?php echo htmlspecialchars($user['email']); ?></p>
      </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="mt-6 border-b border-gray-700">
      <nav class="flex space-x-4">
        <a href="#" class="py-2 px-4 border-b-2 border-blue-500 text-blue-500 font-semibold">Overview</a>
        <a href="#" class="py-2 px-4 text-gray-400 hover:text-white">Comments</a>
        <a href="#" class="py-2 px-4 text-gray-400 hover:text-white">Upvoted</a>
        <a href="#" class="py-2 px-4 text-gray-400 hover:text-white">Downvoted</a>
      </nav>
    </div>

    <!-- Action Buttons -->
    <?php if ($user_id == $_SESSION['user_id']): ?>
    <div class="mt-6 flex justify-between items-center">
      <button id="create-post-button" class="flex items-center space-x-2 bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
        <span>Create Post</span>
      </button>
    </div>
    <?php endif; ?>

    <!-- Include the post modal --> 
    <!-- Profile Feed -->
    <?php include 'profile_feed.php'; ?>
  </div>

  <script>
    document.getElementById('create-post-button').addEventListener('click', function() {
      document.getElementById('default-modal').classList.remove('hidden');
    });

    document.querySelectorAll('[data-modal-hide="default-modal"]').forEach(function(element) {
      element.addEventListener('click', function() {
        document.getElementById('default-modal').classList.add('hidden');
      });
    });
  </script>
</body>
 
