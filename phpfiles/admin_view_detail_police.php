<?php
include("admin_nav.php");
$complaint_id = $_GET['id'];  // Fetch the complaint ID from the URL
include("connection.php");

// Fetch the station registration details based on complaint ID
$sql = "SELECT * FROM stationregistration WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $complaint_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the first row (assuming the complaint_id is unique)
    $row = $result->fetch_assoc();
} else {
    echo "<p>No station details found for this complaint ID.</p>";
    exit;
}
?>

<style>
    /* Global Styles for Premium Look */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f7f9fc;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1200px;
    }

    .cont {
        min-height: 510px;
        background: linear-gradient(to right, #ffffff, #f1f3f6);
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        text-align: center;
        font-size: 2rem;
        margin-bottom: 2rem;
        color: #333;
        font-weight: 700;
    }

    /* Card Style */
    .premium-card {
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        background: #ffffff;
        padding: 20px;
        margin: 15px 0;
        border: 1px solid #f0f1f6;
    }

    .premium-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .premium-card .card-title {
        font-size: 1.5rem;
        color: #3e4a59;
        margin-bottom: 12px;
    }

    .premium-card .card-subtitle {
        font-size: 1.2rem;
        color: #6c757d;
    }

    .info-item {
        margin-bottom: 15px;
    }

    .info-item .label {
        font-weight: 600;
        color: #5a636d;
    }

    .info-item .value {
        color: #333;
        font-size: 1.1rem;
    }

    /* Style for Buttons */
    .btn-primary {
        background-color: #0056b3;
        border-color: #0056b3;
        font-weight: bold;
    }

    .btn-primary:hover {
        background-color: #004085;
        border-color: #003366;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .premium-card {
            margin-bottom: 20px;
        }
    }
</style>

<div class="container text-center cont mb-5">
    <p class="section-title">Station Details</p>
    <div class="row justify-content-center">
        <!-- First Row with Two Columns -->
        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
            <div class="premium-card">
                <h5 class="card-title">Station Name</h5>
                <h6 class="card-subtitle"><?php echo htmlspecialchars($row['Station_name']); ?></h6>
            </div>
            <div class="premium-card">
                <h5 class="card-title">District</h5>
                <h6 class="card-subtitle"><?php echo htmlspecialchars($row['District']); ?></h6>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
            <div class="premium-card">
                <h5 class="card-title">Contact</h5>
                <h6 class="card-subtitle"><?php echo htmlspecialchars($row['Contact']); ?></h6>
            </div>
            <div class="premium-card">
                <h5 class="card-title">Registration Number</h5>
                <h6 class="card-subtitle"><?php echo htmlspecialchars($row['Registration_number']); ?></h6>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <!-- Second Row with Two Columns -->
        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
            <div class="premium-card">
                <h5 class="card-title">Station Code</h5>
                <h6 class="card-subtitle"><?php echo htmlspecialchars($row['Station_code']); ?></h6>
            </div>
            <div class="premium-card">
                <h5 class="card-title">Address</h5>
                <h6 class="card-subtitle"><?php echo htmlspecialchars($row['Address']); ?></h6>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
            <div class="premium-card">
                <h5 class="card-title">Station Incharge Name</h5>
                <h6 class="card-subtitle"><?php echo htmlspecialchars($row['Station_incharge_name']); ?></h6>
            </div>
            <div class="premium-card">
                <h5 class="card-title">Station Incharge Contact</h5>
                <h6 class="card-subtitle"><?php echo htmlspecialchars($row['Station_incharge_contact']); ?></h6>
            </div>
        </div>
    </div>
</div>

<?php include("Footer.php") ?>
