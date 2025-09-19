<!-- Sidebar -->
<div id="sidebar" class="sidebar sidebar-collapsed text-white h-screen flex flex-col py-4 transition-all duration-300 overflow-hidden bg-[#28433D] fixed top-0 left-0 z-50">

  <!-- Logo -->
  <div class="flex items-center justify-center px-4 mb-8">
    <img src="../img/Group 243 (1).png" alt="logo" class="w-8 h-8" style="width: fit-content; height: fit-content;">
  </div>

  <!-- Menu -->
  <nav class="flex-1 w-full">
    <a href="dashboard.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-900 transition">
      <i class="fas fa-home"></i><span class="sidebar-text">Dashboard</span>
    </a>
    <a href="order.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-900 transition">
      <i class="fas fa-shopping-bag"></i><span class="sidebar-text">Orders</span>
    </a>
    <a href="users.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-900 transition">
      <i class="fas fa-users"></i><span class="sidebar-text">Users</span>
    </a>
    <a href="products.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-900 transition">
      <i class="fas fa-box"></i><span class="sidebar-text">Products</span>
    </a>
    <a href="payment.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-900 transition">
      <i class="fas fa-credit-card"></i><span class="sidebar-text">Payments</span>
    </a>
    <a href="settings.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-900 transition">
      <i class="fas fa-cog"></i><span class="sidebar-text">Settings</span>
    </a>
  </nav>

  <!-- Logout -->
  <a href="../logout.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-red-600 transition">
    <i class="fas fa-sign-out-alt"></i>
    <span class="sidebar-text">Log Out</span>
  </a>
</div>

<style>
  /* Sidebar transitions */
  .sidebar {
    transition: width 0.3s ease;
    overflow: hidden;
    background-color: #28433D;
    min-height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 50;
  }

  .sidebar-collapsed {
    width: 4rem;
  }
  .sidebar-expanded {
    width: 14rem;
  }

  /* Hide text when collapsed */
  .sidebar-collapsed .sidebar-text {
    display: none;
  }

  /* Logo transition */
  .sidebar img {
    transition: all 0.3s ease;
  }

  /* Responsive adjustments */
  @media (max-width: 768px) {
    .sidebar {
      position: fixed;
      z-index: 50;
      width: 0;
      left: -100%;
      transition: left 0.3s ease;
    }
    .sidebar-expanded {
      left: 0;
      width: 14rem;
    }
  }
</style>

<script>
  // Sidebar toggle on hover (desktop)
  const sidebar = document.getElementById('sidebar');
  const body = document.body;

  sidebar.addEventListener('mouseenter', () => {
    sidebar.classList.remove('sidebar-collapsed');
    sidebar.classList.add('sidebar-expanded');
    body.classList.remove('collapsed');
  });
  sidebar.addEventListener('mouseleave', () => {
    sidebar.classList.remove('sidebar-expanded');
    sidebar.classList.add('sidebar-collapsed');
    body.classList.add('collapsed');
  });
</script>
