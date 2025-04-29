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
          window.location.href='Login.php';
        </script>";
  exit();
}

include("connection.php");
$station_id = $_SESSION['Pid'];

// Get police name based on Pid
$name_sql = "SELECT Name FROM citizen WHERE ID = $station_id";
$name_result = $conn->query($name_sql);

$officer_name = "User"; // Default value
if ($name_result->num_rows > 0) {
  $row = $name_result->fetch_assoc();
  $officer_name = $row['Name'];
}

// Get today's date in 'Y-m-d' format
$today = date('Y-m-d');

// Query to get the number of complaints for today in the logged-in user's district
$crime_count_sql = "SELECT COUNT(*) AS crime_count FROM add_complaints WHERE DATE(Date) = '$today' AND District = (SELECT District FROM citizen WHERE ID = $station_id)";
$crime_count_result = $conn->query($crime_count_sql);

$crime_count = 0; // Default value if no crimes found
if ($crime_count_result->num_rows > 0) {
    $row = $crime_count_result->fetch_assoc();
    $crime_count = $row['crime_count']; // The number of crimes today
}

// Query to fetch the crime alerts for today's date and the logged-in user's district
$crime_alert_sql = "SELECT Location_of_Incident, Type_of_Crime, Complainant_Description, Date FROM add_complaints WHERE DATE(Date) = '$today' AND District = (SELECT District FROM citizen WHERE ID = $station_id)";
$crime_alert_result = $conn->query($crime_alert_sql);

$crime_alerts = [];
if ($crime_alert_result->num_rows > 0) {
    while ($row = $crime_alert_result->fetch_assoc()) {
        $crime_alerts[] = $row; // Store alerts in the array
    }
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
        <!-- All items will be aligned to the right except the logo -->
        <ul class="navbar-nav ms-auto"> <!-- Use ms-auto to align the nav items to the right -->
          <li class="nav-item active">
            <a class="nav-link" href="Citizen_home.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Citizen_add_complain.php">Add Complaints</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Citizen_view_Complain.php">View Complaints</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#alertsModal">
              View Alerts
              <?php if ($crime_count > 0) { ?>
                <span class="badge bg-danger text-light"><?php echo $crime_count; ?></span>
              <?php } ?>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Citizen_profile_update.php">Update profile</a>
          </li>
          <li class="nav-item dropdown">
            <button class="nav-link dropdown-toggle btn btn-link text-decoration-none" id="settingsDropdown"
              data-bs-toggle="dropdown" aria-expanded="false">
              <?php echo ($officer_name); ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="settingsDropdown">
              <li>
                <a class="dropdown-item" href="Citizen_chnage_password.php">Change Password</a>
              </li>
              <li>
                <a class="dropdown-item text-danger" href="?log=1" onclick="return confirm('Do you really want to Logout?');">
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
   
<!-- Modal for Viewing Alerts -->
  <div class="modal fade" id="alertsModal" tabindex="-1" aria-labelledby="alertsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="alertsModalLabel">Today's Crime Alerts</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <?php if (empty($crime_alerts)) { ?>
            <p>No alerts available for today.</p>
          <?php } else { ?>
            <table class="table">
              <thead>
                <tr>
                  <th>Location of Incident</th>
                  <th>Type of Crime</th>
                  <th>Description</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($crime_alerts as $alert) { ?>
                  <tr>
                    <td><?php echo $alert['Location_of_Incident']; ?></td>
                    <td><?php echo $alert['Type_of_Crime']; ?></td>
                    <td><?php echo $alert['Complainant_Description']; ?></td>
                    <td><?php echo $alert['Date']; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          <?php } ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap JS (Place before </body>) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
