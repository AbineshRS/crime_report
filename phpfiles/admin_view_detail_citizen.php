<?php
include("admin_nav.php");
$complaint_id = $_GET['id'];  // Fetch the complaint ID from the URL
include("connection.php");

// Fetch the citizen details based on complaint ID
$sql = "SELECT * FROM citizen WHERE Id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $complaint_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the first row (assuming the complaint_id is unique)
    $row = $result->fetch_assoc();
} else {
    echo "<p>No citizen details found for this complaint ID.</p>";
    exit;
}

// Handling the approve/reject button clicks
if (isset($_POST['approve'])) {
    // Update status to 'Approved'
    $update_sql = "UPDATE citizen SET Status = 0 WHERE Id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("i", $complaint_id);
    $update_stmt->execute();
    echo "<script>alert('Complaint Approved'); window.location.href = 'admin_view_citizen.php';</script>";
} elseif (isset($_POST['reject'])) {
    // Update status to 'Rejected'
    $update_sql = "UPDATE login SET Status = 'inactive' WHERE Pid = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("i", $complaint_id);
    $update_stmt->execute();
    echo "<script>alert('Complaint Rejected'); window.location.href = 'admin_view_citizen.php';</script>";
}
?>

<style>
    /* Global Styles for Premium Look */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f8f9fa;
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
    .btn-approve {
        background-color: #28a745;
        border-color: #28a745;
        font-weight: bold;
        padding: 12px 20px;
        font-size: 1rem;
        border-radius: 10px;
    }

    .btn-approve:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .btn-reject {
        background-color: #dc3545;
        border-color: #dc3545;
        font-weight: bold;
        padding: 12px 20px;
        font-size: 1rem;
        border-radius: 10px;
    }

    .btn-reject:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .premium-card {
            margin-bottom: 20px;
        }

        .btn-approve, .btn-reject {
            width: 100%;
            margin-top: 10px;
        }
    }
</style>

<div class="container text-center cont mb-5">
    <p class="section-title">Citizen Details</p>
    <div class="row justify-content-center">
        <!-- First Row with Two Columns -->
        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
            <div class="premium-card">
                <h5 class="card-title">Name</h5>
                <h6 class="card-subtitle"><?php echo htmlspecialchars($row['Name']); ?></h6>
            </div>
            <div class="premium-card">
                <h5 class="card-title">Contact</h5>
                <h6 class="card-subtitle"><?php echo htmlspecialchars($row['Contact']); ?></h6>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
            <div class="premium-card">
                <h5 class="card-title">Gender</h5>
                <h6 class="card-subtitle"><?php echo htmlspecialchars($row['Gender']); ?></h6>
            </div>
            <div class="premium-card">
                <h5 class="card-title">DOB</h5>
                <h6 class="card-subtitle"><?php echo htmlspecialchars($row['DOB']); ?></h6>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <!-- Second Row with Two Columns -->
        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
            <div class="premium-card">
                <h5 class="card-title">District</h5>
                <h6 class="card-subtitle"><?php echo htmlspecialchars($row['District']); ?></h6>
            </div>
            <div class="premium-card">
                <h5 class="card-title">Address</h5>
                <h6 class="card-subtitle"><?php echo htmlspecialchars($row['Address']); ?></h6>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
            <div class="premium-card">
                <h5 class="card-title">Aadhar</h5>
                <h6 class="card-subtitle"><?php echo htmlspecialchars($row['Aadhar']); ?></h6>
            </div>
        </div>
    </div>

    <!-- Approve/Reject Buttons -->
    <div class="button-container">
        <form method="POST">
            <button type="submit" name="approve" class="btn btn-approve">Approve</button>
            <button type="submit" name="reject" class="btn btn-reject">Reject</button>
        </form>
    </div>
</div>

<?php include("Footer.php") ?>
