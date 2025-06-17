<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="bg-gray-900 border-b border-green-500 shadow-md">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16 items-center">
      <!-- Brand -->
      <div class="flex-shrink-0 text-green-400 font-bold text-lg sm:text-xl">
        💰 COM SMAKDA - <?= ucwords($_SESSION['user']['role'] ?? 'User'); ?>
      </div>

      <!-- Desktop Menu -->
      <div class="hidden md:flex items-center space-x-4">
        <a href="../../logout.php" class="text-sm px-4 py-2 border border-red-500 text-red-400 rounded-md hover:bg-red-500 hover:text-white transition">
          Logout
        </a>
      </div>

      <!-- Mobile Menu Button -->
      <div class="md:hidden">
        <button id="mobile-menu-button" class="text-green-400 focus:outline-none">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"
               viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div id="mobile-menu" class="md:hidden hidden px-4 pb-4">
    <a href="../../logout.php" class="block mt-2 text-sm px-4 py-2 border border-red-500 text-red-400 rounded-md hover:bg-red-500 hover:text-white transition">
      Logout
    </a>
  </div>
</nav>

<script>
  // Toggle Mobile Menu
  document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');

    btn.addEventListener('click', () => {
      menu.classList.toggle('hidden');
    });
  });
</script>
