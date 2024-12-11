<?php 
    session_start();
    require_once($_SERVER["DOCUMENT_ROOT"]."/backend/config/Directories.php");
    include('backend/config/DatabaseConnect.php');
    require_once("includes/header.php"); 
?>

<body class="bg-gray-100">
    <div class=" mx-auto px-4 py-8">
        <?php include 'includes/navbar.php'; ?>        
        <div class="flex mx-auto px-4 py-8 ">
            <div class=" flex max-w-screen-xl border border-red-400 ">
                <?php include 'includes/sidenavbar.php'; ?>
            </div>

            <div class="flex-auto">
                <!-- Post card -->
                <?php include 'post/post_modal.php'; ?> 
                
                <?php
                $category = isset($_GET['category']) ? $_GET['category'] : '';

                // Database connection
                $conn = new mysqli('localhost', 'root', '', 'blogging');

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT posts.*, users.username FROM posts 
                        JOIN users ON posts.user_id = users.user_id 
                        WHERE posts.category = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $category);
                $stmt->execute();
                $result = $stmt->get_result();

                $stmt->close();
                $conn->close();
                ?>

                <!-- Feed -->
                <div class="p-4 sm:ml-60">
                    <?php foreach ($result as $row): ?>
                    <!-- Post card -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-4">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-gray-300 h-10 w-10 rounded-full mr-4"></div>
                                <div>
                                    <h3 class="font-semibold text-lg"><?php echo htmlspecialchars($row['username']); ?></h3>
                                    <p class="text-sm text-gray-500">Posted on: <?php echo date('F j, Y', strtotime($row['created_at'])); ?></p>
                                </div>
                            </div>
                            <h4 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($row['title']); ?></h4>
                            <p class="text-gray-700 mb-4"><?php echo htmlspecialchars($row['content']); ?></p>
                            <div class="flex items-center justify-between border-t pt-4">
                                <div class="flex space-x-4">
                                    <button class="flex items-center space-x-2 text-gray-500 hover:text-blue-500 transition duration-300">
                                        <!-- Like SVG -->
                                        <span>Like</span>
                                    </button>
                                    <button class="flex items-center space-x-2 text-gray-500 hover:text-blue-500 transition duration-300">
                                        <!-- Dislike SVG -->
                                        <span>Dislike</span>
                                    </button>
                                </div>
                                <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-300">Comment</button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
              
            </div>       
        </div>
    </div>  
</body>
<?php include 'includes/footer.php'; ?>