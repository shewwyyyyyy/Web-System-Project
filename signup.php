<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register - My App</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>

  <!-- Navbar -->
  <?php include 'includes/navbar.php'; ?>

  <body class="bg-gray-100 min-h-screen flex flex-col">
    <main class="flex-grow container mx-auto px-6 py-8">
      <div
        class="max-w-md mx-auto bg-white rounded-lg overflow-hidden shadow-md"
      >
        <div class="px-6 py-8">
          <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">
            Create your account
          </h2>
          
          <form action="authentication/signup.php" method="POST">
            <div class="mb-4">
              <label for="fullName" class="block text-gray-700 text-sm font-bold mb-2">Full Name</label>
              <input type="text" id="fullName" name="fullName"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                required/>
            </div>

            <div class="mb-4">
              <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
              <input type="username" id="username" name="username"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                required/>
            </div>

            <div class="mb-4">
              <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
              <input type="email" id="email" name="email"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                required/>
            </div>

            <div class="mb-4">
              <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
              <input type="password" id="password" name="password"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                required/>
            </div>

            <div class="mb-6">
              <label for="confirmPassword" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
              <input type="password" id="confirmPassword" name="confirmPassword"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                required/>
            </div>

            <div class="flex items-center justify-between">
              <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 flex-grow text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                >Sign Up</button>
            </div>

            <div class="flex items-center justify-between">
              <p class="text-center w-full font-semibold"> Already have an account? <a href="login.php"
                  class="underline text-blue-400 font-semibold"
                  >Login here</a></p>
            </div>
          </form>

        </div>
      </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow mt-8">
      <div class="container mx-auto px-6 py-3">
        <p class="text-center text-gray-600 text-sm">
          &copy; 2023 My App. All rights reserved.
        </p>
      </div>
    </footer>

  </body>
</html>
