<?php 
    session_start();
    require_once($_SERVER["DOCUMENT_ROOT"]."/backend/config/Directories.php");
    require_once("includes/header.php"); 
?>

<body class="bg-gray-100">
    <div class=" mx-auto px-4 py-8">
        <?php include 'includes/navbar.php'; ?>        


<body class="bg-gray-50">

  <!-- Main Container -->
  <div class="min-h-screen flex">
    <!-- Sidebar -->
    <aside class="w-1/4 bg-gray-200 p-6">
      <div class="flex flex-col items-center">
        <img src="https://via.placeholder.com/100" alt="User Profile" class="w-24 h-24 rounded-full mb-4">
        <h1 class="text-lg font-bold text-gray-800" >@username</h1>
        <p class="text-gray-600">Full Name</p>
      </div>
      <nav class="mt-8">
        <ul class="space-y-4">
          <li>
            <a href="#" class="text-gray-500 font-semibold">Profile</a>
          </li>
          <li>
            <a href="#" class="text-gray-600">Password</a>
          </li>
          
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 bg-white p-8">
      <header class="flex justify-between items-center mt-10">
        <h2 class="text-2xl font-bold text-gray-800">Profile Settings</h2>
         
      </header>
      <form class="mt-6 space-y-6">
        <div>
          <label for="fullName" class="block text-gray-600 font-medium">Name</label>
          <input type="text" id="fullName" placeholder=" " class="w-full mt-2 p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
        </div>
        <div>
          <label for="username" class="block text-gray-600 font-medium">Username</label>
          <input type="text" id="username" placeholder=" " class="w-full mt-2 p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
        </div>
        <div>
          <label for="email" class="block text-gray-600 font-medium">Email</label>
          <input type="email" id="email" placeholder=" " class="w-full mt-2 p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
        </div>
        <div>
          <label for="bio" class="block text-gray-600 font-medium">Bio</label>
          <textarea id="bio" rows="3" placeholder="Maximum 200 characters" class="w-full mt-2 p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500"></textarea>
        </div>
        <button type="submit" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">Save Changes</button>
      </form>
    </main>
  </div>

</body>

