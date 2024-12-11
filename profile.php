<?php 
    session_start();
    require_once($_SERVER["DOCUMENT_ROOT"]."/backend/config/Directories.php");
    require_once("includes/header.php"); 
    require_once("backend/auth/auth_verifier.php");
    include_once("includes/navbar.php");
?>

<body class="bg-gray-100">
    <div class=" mx-auto px-4 py-8">
            
        <div class="flex mx-auto px-4 py-8 ">
            <div class=" flex max-w-screen-xl border border-red-400 ">
                <?php include 'includes/sidenavbar.php'; ?>
            </div>

            <div class="flex-auto">

            <?php echo '<script> alert('.$_SESSION["username"].') </script>'?>   
            <?php include 'includes/profile.php';?>
                <!-- Post card -->
               

                <!-- Feed -->
                     
            </div>       
        </div>
    </div>  
</body>
<?php include 'includes/footer.php'; ?>