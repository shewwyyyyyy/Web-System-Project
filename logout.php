<?php 
session_start();
require_once($_SERVER["DOCUMENT_ROOT"]."/backend/config/Directories.php");
require_once("includes/header.php");

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $_SESSION = [];
    session_destroy();
}
?>  

<!-- Navbar -->
<?php require_once("includes/navbar.php")?>

<div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>
  <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
            <div class="justify-center ">
              <h3 class="text-xl font-semibold text-black-900 text-center " id="modal-title">You are logged out</h3>
              <div class="mt-8 text-center">
                <p class="text-sm text-gray-900">Thank you for visiting our website. You are now logged out.</p>
              </div>
            </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 flex justify-center">
          <a href="login.php" class="items-center justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-400 sm:w-auto">Go to Login</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once(ROOT_DIR."includes/footer.php")?>