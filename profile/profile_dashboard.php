<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<?php 
    session_start();
    require_once($_SERVER["DOCUMENT_ROOT"]."../backend/config/Directories.php");
?>

<body class="bg-gray-100">
    <div class=" mx-auto px-4 py-8">
        <?php include '../includes/navbar.php'; ?>        
        <div class="flex mx-auto px-4 py-8 ">
            <div class=" flex max-w-screen-xl border border-red-400 ">
                <?php include '../includes/sidenavbar.php'; ?>
            </div>

            <div class="flex-auto">

            <?php echo '<script> alert('.$_SESSION["username"].') </script>'?>   
            <?php include '../includes/profile.php';?>
                
                <!-- Post card -->
                <?php include '../post/post_modal.php'; ?>  

                <!-- Feed -->
                <?php include '../user/user_post.php'; ?>  

            </div>       
        </div>
    </div>  
</body>
<?php include '../includes/footer.php'; ?>