<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen">

  <!-- Main Container -->
  <div class="max-w-4xl mx-auto py-8 px-4">
    <!-- Profile Header -->
    <div class="flex items-center space-x-4">
      <!-- Avatar -->
      <div class="relative">
        <img src="https://via.placeholder.com/80" alt="User Avatar" class="w-20 h-20 rounded-full border-2 border-gray-700">
        <div class="absolute bottom-0 right-0 bg-gray-800 p-1 rounded-full">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
          </svg>
        </div>
      </div>
      <!-- User Info -->
      <div>
        <h1 class="text-xl font-bold">Juan</h1>
        <h1 class="text-gray-400">@juan1234</h1>
        <p class="text-gray-400">you only live once...</p>
      </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="mt-6 border-b border-gray-700">
      <nav class="flex space-x-4">
        <a href="#" class="py-2 px-4 border-b-2 border-blue-500 text-blue-500 font-semibold">Overview</a>
        <a href="#" class="py-2 px-4 text-gray-400 hover:text-white">Posts</a>
        <a href="#" class="py-2 px-4 text-gray-400 hover:text-white">Comments</a>
        <a href="#" class="py-2 px-4 text-gray-400 hover:text-white">Upvoted</a>
        <a href="#" class="py-2 px-4 text-gray-400 hover:text-white">Downvoted</a>
      </nav>
    </div>

    <!-- Action Buttons -->
   
  </div>

</body>
</html>
