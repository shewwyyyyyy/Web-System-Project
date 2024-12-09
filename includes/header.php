<head>

    <?php
    
    if (isset($_SESSION['user_id'])) {
        $IsAuthenticated = true;
    }
    else{
        $IsAuthenticated = false;
    }
    if (isset($_SESSION['error'])) {
        // use flowbite alert component 
  
        
        echo ' 
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                document.body.insertAdjacentHTML("afterbegin", `
                    <div class="p-4 mb-4  text-red-800 text-lg font-semibold rounded-lg bg-red-100 role="alert">
                     ' . $_SESSION['error'] . '
                    </div>
                `);
                });
            </script>
        ';
        unset($_SESSION['error']);
    }if (isset($_SESSION['error'])) {
        // use flowbite alert component 
  
        
        echo ' 
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                document.body.insertAdjacentHTML("afterbegin", `
                    <div class="p-4 mb-4  text-red-800 text-lg font-semibold rounded-lg bg-red-100 role="alert">
                     ' . $_SESSION['error'] . '
                    </div>
                `);
                });
            </script>
        ';
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        // use flowbite alert component 
  
        
        echo ' 
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                document.body.insertAdjacentHTML("afterbegin", `
                    <div class="p-4 mb-4  text-green-800 text-lg font-semibold rounded-lg bg-green-100 role="alert">
                     ' . $_SESSION['success'] . '
                    </div>
                `);
                });
            </script>
        ';
        unset($_SESSION['success']);
    }
    ?>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</head>