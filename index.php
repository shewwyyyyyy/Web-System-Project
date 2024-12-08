<?php 
    session_start();
    require_once($_SERVER["DOCUMENT_ROOT"]."/backend/config/Directories.php");
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

                <!-- Feed -->
                <?php include 'feed.php'; ?>    
            </div>       
        </div>
    </div>  
</body>
<?php include 'includes/footer.php'; ?>