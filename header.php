<?php include('config.php');

// date_default_timezone_set('Asia/Calcutta');




$token = ($_SESSION['ADVANTAGE_advantagetoken'] ? $_SESSION['ADVANTAGE_advantagetoken'] : 'NA');


if (!function_exists('verifyToken')) {
  function verifyToken($token)
  {
    global $con;

    $sql = mysqli_query($con, "select * from user where token='" . $token . "' and user_status=1");
    if ($sql_result = mysqli_fetch_assoc($sql)) {
      return 1;
    } else {
      return 0;
    }
  }
}


if (verifyToken($token) != 1 || $token == 'NA') {

  ob_start();
  header('Location: /corona/pages/auth/login.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Corona Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet"
    href="<? $_SERVER["DOCUMENT_ROOT"]; ?>/corona/assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<? $_SERVER["DOCUMENT_ROOT"]; ?>/corona/assets/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="<? $_SERVER["DOCUMENT_ROOT"]; ?>/corona/assets/vendors/jvectormap/jquery-jvectormap.css">
  <link rel="stylesheet"
    href="<? $_SERVER["DOCUMENT_ROOT"]; ?>/corona/assets/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet"
    href="<? $_SERVER["DOCUMENT_ROOT"]; ?>/corona/assets/vendors/owl-carousel-2/owl.carousel.min.css">
  <link rel="stylesheet"
    href="<? $_SERVER["DOCUMENT_ROOT"]; ?>/corona/assets/vendors/owl-carousel-2/owl.theme.default.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="<? $_SERVER["DOCUMENT_ROOT"]; ?>/corona/assets/css/style.css">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="<? $_SERVER["DOCUMENT_ROOT"]; ?>/corona/assets/images/favicon.png" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <link rel="stylesheet" type="text/css" href="<? $_SERVER["DOCUMENT_ROOT"]; ?>/corona/datatable/dataTables.bootstrap.css">


</head>

<body>
  <div class="container-scroller">
    <?php include('nav.php'); ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_navbar.html -->
      <nav class="navbar p-0 fixed-top d-flex flex-row">
        <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
          <a class="navbar-brand brand-logo-mini" href="<? $_SERVER["DOCUMENT_ROOT"]; ?>/corona/index.php"><img
              src="<? $_SERVER["DOCUMENT_ROOT"]; ?>/corona/assets/images/logo-mini.svg" alt="logo" /></a>
        </div>
        <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          <ul class="navbar-nav w-100">
            <li class="nav-item w-100">
              <!-- <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search" >
                  <input type="text" name="atmid" class="form-control" placeholder="Search ATMID">
                  <a href="#" data-bs-toggle="modal" class="history-link" data-bs-target="#atmmodal"
                                        data-act="add" data-siteid="<?php echo $id; ?>">History</a>

                </form> -->
              <!-- header.php -->
              <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search" id="searchForm">
                <input type="text" name="atmid" class="form-control" placeholder="Search ATMID" id="atmSearchInput" style="width:100%;">
              </form>

            </li>
          </ul>
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item dropdown d-none d-lg-block">
              <a class="nav-link btn btn-success create-new-button" id="createbuttonDropdown" data-bs-toggle="dropdown"
                aria-expanded="false" href="#">+ Create New Project</a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                aria-labelledby="createbuttonDropdown">
                <h6 class="p-3 mb-0">Projects</h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-file-outline text-primary"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1">Software Development</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-web text-info"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1">UI Development</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-layers text-danger"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1">Software Testing</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <p class="p-3 mb-0 text-center">See all projects</p>
              </div>
            </li>
            <!-- <li class="nav-item nav-settings d-none d-lg-block">
              <a class="nav-link" href="#">
                <i class="mdi mdi-view-grid"></i>
              </a>
            </li> -->
            <!-- <li class="nav-item dropdown border-left">
              <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-email"></i>
                <span class="count bg-success"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                aria-labelledby="messageDropdown">
                <h6 class="p-3 mb-0">Messages</h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="../../assets/images/faces/face4.jpg" alt="image" class="rounded-circle profile-pic">
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1">Mark send you a message</p>
                    <p class="text-muted mb-0"> 1 Minutes ago </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="../../assets/images/faces/face2.jpg" alt="image" class="rounded-circle profile-pic">
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1">Cregh send you a message</p>
                    <p class="text-muted mb-0"> 15 Minutes ago </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="../../assets/images/faces/face3.jpg" alt="image" class="rounded-circle profile-pic">
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1">Profile picture updated</p>
                    <p class="text-muted mb-0"> 18 Minutes ago </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <p class="p-3 mb-0 text-center">4 new messages</p>
              </div>
            </li> -->
            <!-- <li class="nav-item dropdown border-left">
              <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                data-bs-toggle="dropdown">
                <i class="mdi mdi-bell"></i>
                <span class="count bg-danger"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                aria-labelledby="notificationDropdown">
                <h6 class="p-3 mb-0">Notifications</h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-calendar text-success"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject mb-1">Event today</p>
                    <p class="text-muted ellipsis mb-0"> Just a reminder that you have an event today </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-settings text-danger"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject mb-1">Settings</p>
                    <p class="text-muted ellipsis mb-0"> Update dashboard </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-link-variant text-warning"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject mb-1">Launch Admin</p>
                    <p class="text-muted ellipsis mb-0"> New admin wow! </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <p class="p-3 mb-0 text-center">See all notifications</p>
              </div>
            </li> -->
            <li class="nav-item dropdown">
              <a class="nav-link" id="profileDropdown" href="#" data-bs-toggle="dropdown">
                <div class="navbar-profile">
                  <p class="mb-0 d-none d-sm-block navbar-profile-name">
                    <?= ucwords($username); ?>
                  </p>
                  <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                aria-labelledby="profileDropdown">
                <h6 class="p-3 mb-0">Profile</h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-settings text-success"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject mb-1">Settings</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item" href="<?= $base_url; ?>/logout.php">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-logout text-danger"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject mb-1">Log out</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <p class="p-3 mb-0 text-center">Advanced settings</p>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="mdi mdi-format-line-spacing"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">



          <script>
            function unlockIPs() {
              $.ajax({
                type: 'GET',
                url: '<? $_SERVER["DOCUMENT_ROOT"]; ?>/corona/unLockIPs.php',
                success: function (response) { },
                error: function (xhr, status, error) {
                  console.error(xhr.responseText);
                }
              });
            }

            // Call unlockIPs function every 10 seconds
            setInterval(unlockIPs, 10000); // 10,000 milliseconds = 10 seconds
          </script>





          <div class="modal fade" id="atmmodal" tabindex="-1" aria-labelledby="ModalLabel" style="display: none;"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="ModalLabel">New message</h5>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div id="atmhistoryContent" style="overflow: scroll;max-height: 70vh;"></div>
                </div>
                <div class="modal-footer">

                  <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>


          <!-- At the end of your HTML file -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var searchForm = document.getElementById('searchForm');
        var searchInput = document.getElementById('atmSearchInput');
        var atmhistoryContent = document.getElementById('atmhistoryContent');

        searchForm.addEventListener('submit', function (event) {
            event.preventDefault();

            // Fetch data using AJAX
            $.ajax({
                url: '<? $_SERVER["DOCUMENT_ROOT"]; ?>/corona/getatmHistory.php',
                type: 'GET',
                data: { atmid: searchInput.value },
                success: function (response) {
                    // Update #atmhistoryContent with the response
                    atmhistoryContent.innerHTML = response;

                    // Trigger modal on form submission
                    var myModal = new bootstrap.Modal(document.getElementById('atmmodal'));
                    myModal.show();
                },
                error: function () {
                    console.error('Error fetching ATM history data.');
                }
            });
        });

        searchInput.addEventListener('keyup', function (event) {
            // Check if Enter key is pressed (keyCode 13)
            if (event.key === 'Enter') {
                event.preventDefault();

                // Fetch data using AJAX
                $.ajax({
                    url: '<? $_SERVER["DOCUMENT_ROOT"]; ?>/corona/getatmHistory.php',
                    type: 'GET',
                    data: { atmid: searchInput.value },
                    success: function (response) {
                        // Update #atmhistoryContent with the response
                        atmhistoryContent.innerHTML = response;

                        // Trigger modal on Enter key press
                        var myModal = new bootstrap.Modal(document.getElementById('atmmodal'));
                        myModal.show();
                    },
                    error: function () {
                        console.error('Error fetching ATM history data.');
                    }
                });
            }
        });
    });
</script>
