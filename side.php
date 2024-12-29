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
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="admin.php" class="text-nowrap logo-img">
         <!-- <h1 class="fw-bold">CEYNAP</h1> -->
         <img src="../assets/images/logos/logo-black.png" class="img-fluid w-100" alt="">
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Home</span>
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
              <a class="sidebar-link" href="manage-order.php" aria-expanded="false">
                <span>
                <i class="fa fa-archive" aria-hidden="true"></i>
                </span>
                <span class="hide-menu">Manage orders</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="add-product.php" aria-expanded="false">
                <span>
                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                </span>
                <span class="hide-menu">Add Product</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="manage-product.php" aria-expanded="false">
                <span>
                <i class="fa fa-list" aria-hidden="true"></i>
                </span>
                <span class="hide-menu">manage Products</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="add-variations.php" aria-expanded="false">
                <span>
                <i class="fa fa-database" aria-hidden="true"></i>

                </span>
                <span class="hide-menu">Manage Variations</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="add-discount.php" aria-expanded="false">
                <span>
                <i class="fa fa-money" aria-hidden="true"></i>
                </span>
                <span class="hide-menu">Discount</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="user-manage.php" aria-expanded="false">
                <span>
                <i class="fa-solid fa-user"></i>
                </span>
                <span class="hide-menu"> User Management</span>
              </a>
            </li>
            
            <li class="sidebar-item">
              <a class="sidebar-link" href="invoice-view.php" aria-expanded="false">
                <span>
                <i class="fa-solid fa-receipt"></i>
                </span>
                <span class="hide-menu">Invoice</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="ai-bot.php" aria-expanded="false">
                <span>
                <i class="fa-brands fa-bots"></i>                </span>
                <span class="hide-menu">CODY AI</span>
                <span class="badge text-bg-success">Beta</span>
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