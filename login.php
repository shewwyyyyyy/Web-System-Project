<?php 
session_start(); 
require_once("includes/header.php"); 
?>
  
<!-- Navbar -->
<?php include 'includes/navbar.php'; ?>

<body class="bg-gray-100">
  <main class="flex flex-auto items-center min-h-screen  justify-center">
    <!-- Login Form -->
    <div class="max-w-md w-full bg-white rounded-lg overflow-hidden shadow-md">
      <div class="px-6 py-8">
        <h2 class="text-2xl font-bold text-center text-gray-700 mb-6"> Welcome Back! </h2>
        
        <form action="backend/auth/login.php" method="POST">
          <div class="mb-4">
            <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter your username"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required/>
          </div>

          <div class="mb-4">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required/>
          </div>
      
          <div class="flex items-center justify-between">
            <button type="submit"
              class="bg-blue-500 hover:bg-blue-700 flex-grow text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
              Login
            </button>
          </div>

          <div class="flex items-center justify-between">
            <p class="text-center w-full font-semibold"> Don't have an account? <a href="signup.php" class="underline text-blue-400 font-semibold"
                >Register here</a></p>
          </div>

        </form>

      </div>
    </div>
  </main>


  </body>
</html>
