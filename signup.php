<?php require_once("includes/header.php"); ?>
  <!-- Navbar -->
  <?php include 'includes/navbar.php'; ?>

    <body class="bg-gray-100 min-h-screen flex flex-col">
      <main class="flex-grow container mx-auto pt-20 px-6 py-8">
        <div
          class="max-w-md mx-auto bg-white rounded-lg overflow-hidden shadow-md">
          <div class="px-6 py-8">
            <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Create your account</h2>
            
            <form action="backend/auth/signup.php" method="POST">
              <div class="mb-4">
                <label for="fullName" class="block text-gray-700 text-sm font-bold mb-2">Full Name</label>
                <input type="text" id="fullName" name="fullName" placeholder="Enter your full name"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required/>
              </div>

              <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                 <input type="text" id="username" name="username" placeholder="Enter your username"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required/>
              </div>

              <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email address"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required/>
              </div>

              <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required/>
              </div>

              <div class="mb-6">
                <label for="confirmPassword" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required/>
              </div>

              <div class="flex items-center justify-between">
                <button type="submit"
                  class="bg-blue-500 hover:bg-blue-700 flex-grow text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Sign Up</button>
              </div>

              <div class="flex items-center justify-between">
                <p class="text-center w-full font-semibold pt-2"> Already have an account? 
                  <a href="login.php" class="underline text-blue-400 font-semibold">Login here</a>
                </p>
              </div>
            </form>

          </div>
        </div>
      </main>

      <!-- Footer -->

    </body>