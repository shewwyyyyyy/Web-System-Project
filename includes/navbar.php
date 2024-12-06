<div class="fixed top-0 left-0 right-0 z-50 flex justify-between p-4 border px-40 shadow-md bg-white">
    <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
        <img src="https://placehold.co/100x100" class="h-8" alt="Logo" />
        <span class="self-center text-2xl font-semibold whitespace-nowrap">Brand</span>
    </a>
    <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-default" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
        </svg>
    </button>
    <div class="hidden w-full md:block md:w-auto" id="navbar-default">
      <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white">
        <li>
          <a href="index.php" class="block text-black rounded">Home</a>
        </li>
        <li>
          <a href="login.php" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">Login</a>
        </li>
        <li>
          <a href="signup.php" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">Signup</a>
        </li>
        
        <!-- Dropdown for Signed-in User --> 
        <?php        
        if(isset($_SESSION["username"])){
        ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo htmlspecialchars($_SESSION["username"]); ?>  <!-- Replace with dynamic username -->
                </a>
                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="profile.html">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                      <li>
                          <form action="/logout.php" method="POST">
                          <button class="dropdown-item">Logout</button>
                          </form>
                      </li>
                </ul>
            </li>
        <?php
        }
        ?>
      </ul>
    </div>
</div>

<!-- Add padding to the top of the body to prevent content from being hidden behind the fixed navbar -->
<style>
  body {
    padding-top: 80px; /* Adjust this value based on the height of your navbar */
  }
</style>