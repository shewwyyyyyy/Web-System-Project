<?php 
    session_start();
    require_once($_SERVER["DOCUMENT_ROOT"]."/backend/config/Directories.php");
    require_once("includes/header.php"); 


    $_SESSION["category"] = $_GET["category"];
?>

<body class="bg-gray-300">
    <div class="mx-auto px-4 py-8">
        <?php include 'includes/navbar.php'; ?>        
        <div class="flex mx-auto px-4 py-8">
            <div class="flex max-w-screen-xl">
                <?php include 'includes/sidenavbar.php'; ?>
            </div>

            <div class="flex-auto">
                <!-- Reddit-like Guest Feed -->
                <?php include 'category_feed.php'; ?>    
            </div>       
        </div>
    </div>  
</body>
<?php include 'includes/footer.php'; ?>
