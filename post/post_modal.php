<div class="pt-4 sm:ml-60">
<!-- Modal toggle -->
<button data-modal-target="default-modal" data-modal-toggle="default-modal" class="w-full " type="button">
    <div class="flex justify-start bg-white rounded-lg shadow-md p-4 "> 
        <div class="flex flex-auto bg-gray-100 p-2 rounded-lg hover:bg-gray-200">
            <div class=" bg-gray-300 h-10 w-10 rounded-full ml-2 mr-4"></div>
            <p href="post/post-card.php" class="text-left text-xl font-semibold mb-4 ">What's on your mind?</p>
        </div>
    </div>                
</button>

<!-- Main modal -->
<div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Create a post
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <form action="backend/post/add_post.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                        <input type="text" id="title" name="title" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Enter title" required>
                    </div>
                            
                    <div class="mb-4">
                        <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Content</label>
                        <textarea id="content" name="content" class="w-full p-2 border border-gray-300 rounded-md" rows="3" placeholder="Share your thoughts..." required></textarea>
                    </div>
                            
                    <div class="mb-4">
                        <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                        <select id="category" name="category" class="w-full p-2 border border-gray-300 rounded-md" required>
                            <option value="">Select category</option>
                            <option value="Technology">Technology</option>
                            <option value="Health">Health</option>  
                            <option value="Education">Education</option>
                            <option value="Entertainment">Entertainment</option>
                        </select>
                    </div>
                            
                    <div class="mb-4">
                        <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Upload Image</label>
                        <input type="file" id="image" name="image" class="w-full p-2 border border-gray-300 rounded-md" accept="image/*" >
                    </div>
            </div>
            
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button  type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Post</button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>