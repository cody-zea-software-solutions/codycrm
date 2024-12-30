<?php

session_start();

?>
<!---Icons-->
<script src="https://kit.fontawesome.com/dfdb94433e.js" crossorigin="anonymous"></script>
<script src="assets-admin\js\script.js"></script>

<!---Icons-->
<!-- Sidebar Start -->
<aside class="left-sidebar" style="overflow: auto;">
  <!-- Sidebar scroll-->
  <div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
      <ul id="sidebarnav">
        <li class="sidebar-item py-5">
          <div class="brand-logo d-flex align-items-center justify-content-center">
            <a href="admin.php" class="text-nowrap logo-img">
              <img src="assets-admin/images/logos/logo.webp" class="img-fluid" style="width: 100px;" alt="">
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
              <i class="ti ti-x fs-8"></i>
            </div>
          </div>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="./admin.php" aria-expanded="true">
            <span>
              <i class="ti ti-layout-dashboard"></i>
            </span>
            <span class="hide-menu">Dashboard</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="call-manage.php" aria-expanded="false">
            <span>
              <i class="fa fa-archive" aria-hidden="true"></i>
            </span>
            <span class="hide-menu">Call Management</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="call-reminder.php" aria-expanded="false">
            <span>
              <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
            </span>
            <span class="hide-menu">Call Reminder</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="ongoing.php" aria-expanded="false">
            <span>
              <i class="fa fa-plus-circle" aria-hidden="true"></i>
            </span>
            <span class="hide-menu">On going</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="high.php" aria-expanded="false">
            <span>
              <i class="fa fa-list" aria-hidden="true"></i>
            </span>
            <span class="hide-menu">High</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="missed.php" aria-expanded="false">
            <span>
              <i class="fa fa-database" aria-hidden="true"></i>

            </span>
            <span class="hide-menu">Missed</span>
          </a>
        </li>

        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">AUTH</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link bg-red-hover text-danger" href="#" onclick="admin_logout();" aria-expanded="false">
            <span class="hide-menu fw-bold"><i class="ti ti-login"></i>&nbsp;Log Out</span>
          </a>
        </li>
      </ul>

    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>
<!--  Sidebar End -->