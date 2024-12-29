<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Boozebites New Zealand || Admin-Panel</title>
  <link rel="shortcut icon" href="../assets/images/logos/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="../admin-panel/assets-admin/css/styles.min.css" />
</head>

<body style="background-color: #FBD1A9;">
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="../assets/images/logos/logo-black.png" width="180" alt="">
                </a>
                <h1 class="text-center">Booze Bites</h1>
                <form>
                  <div class="mb-3">
                    <label for="u" class="form-label">Username</label>
                    <input type="text" class="form-control" id="u" aria-describedby="emailHelp">
                  </div>
                  <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password">
                  </div>
         
                  <a href="#" class="btn x w-100 py-8 fs-4 mb-4 rounded-2" onclick="adminLogin();">Sign In</a>        
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../script.js"></script>
  <script src="assets-admin\js\script.js"></script>
  
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>