<?php
session_start();

if (isset($_GET['log'])) { // Only logout if explicitly clicked
  session_destroy();
  echo "<script>
            alert('You have been logged out.');
            window.location.href = 'index.php';
          </script>";
  exit();
}
if (!isset($_SESSION['Pid'])) {
  echo "<script>
          alert('Please login to continue');
          window.location.href='index.php';
        </script>";
  exit();
}
?>
<?php
include("connection.php");
$station_id = $_SESSION['Pid'];

// Get police name based on Pid
$name_sql = "SELECT Station_incharge_name FROM stationregistration WHERE ID = $station_id";
$name_result = $conn->query($name_sql);

$officer_name = "User"; // Default value
if ($name_result->num_rows > 0) {
  $row = $name_result->fetch_assoc();
  $officer_name = $row['Station_incharge_name'];
}
if (!isset($_SESSION['Pid'])) {
  echo "<script>
          alert('Please login to continue');
          window.location.href='Login.php';
        </script>";
  exit();
}

?>
<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Royal</title>

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Roboto:400,500&display=swap"
    rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="../css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="../css/responsive.css" rel="stylesheet" />
</head>

<body>
  <!-- header section strats -->
  <header class="header_section sticky-top">
    <div class="container sticky-top">
      <nav class="navbar navbar-expand-lg custom_nav-container ">
        <a class="navbar-brand" href="#">
          <div class="logo_box">
            <img src="../images/logo.png" alt=""  style="width: 200px;"/>
          </div>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto mr-2">
            <li class="nav-item active">
              <a class="nav-link" href="police_home.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="police_view_cases.php"> Cases</a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="blog.html">Blog</a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link" href="police_update_profile.php">Update Profile</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="settingsDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false"> <?php echo ($officer_name); ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="settingsDropdown">
                <li>
                  <a class="dropdown-item" href="police_change_password.php">Change Password</a>
                </li>
                <li>
                  <a class="dropdown-item text-danger" href="?log=1"
                    onclick="return confirm('Do you really want to Logout?');">
                    Logout
                  </a>
                </li>
              </ul>
            </li>




          </ul>
        </div>
      </nav>
    </div>
  </header>
  <!-- end header section -->
  <!-- Bootstrap JS (Place before </body>) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
