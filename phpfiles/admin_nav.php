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
if (!isset($_SESSION['email'])) {
    echo "<script>
            alert('Please login to continue');
            window.location.href='Login.php';
          </script>";
    exit();
}
include("connection.php");
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
              <a class="nav-link" href="admin_dashboard.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="Police_officer_register.php">Add Police Station </a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="admin_view_police_station.php">View Police Station </a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="admin_view_citizen.php">View Citizen </a>
            </li>
             <li class="nav-item">
              <a class="nav-link" href="admin_view_complaints.php">Complaints</a>
            </li> 
            <li class="nav-item">
            <a href="?log=1" class="nav-item nav-link"
            onclick="return confirm('Do you really want to Logout?');">Logout</a>
            </li>
            

          </ul>
        </div>
      </nav>
    </div>
  </header>
  <!-- end header section -->
  <!-- Bootstrap JS (Place before </body>) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
