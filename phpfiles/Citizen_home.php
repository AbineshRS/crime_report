<?php include("Citizen_nav.php") ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container text-center mt-5">
    <div class="row">
        <div class="col">
            <div id="carouselExample" class="carousel slide">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="../images/Rectangle 106.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="../images/Rectangle 106.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="../images/Rectangle 106.png" class="d-block w-100" alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
</div>

<?php
include("connection.php");

// Fetch from completed_crime table
$sql = "SELECT * FROM completed_crime ORDER BY Id DESC LIMIT 5";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<div class="container text-center mt-5"><div class="row justify-content-center">';

    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <img src="' . htmlspecialchars($row['proof']) . '" class="img-fluid" alt="Proof Image" style="height: 150px; object-fit: cover;">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h6 class="card-title">' . htmlspecialchars($row['title']) . '</h6>
                            <p class="card-text text-muted small mb-1" style="text-align: left;">
                                ' . htmlspecialchars($row['description']) . '
                            </p>
                            <p class="card-text text-muted small" style="text-align: right;">
                                ' . date("d M Y", strtotime($row['Date'])) . '
                            </p>
                        </div>
                    </div>
                </div>
              </div>';
    }

    echo '</div></div>'; // Close row and container
} else {
    echo "<div class='alert alert-info'>No records found in completed_crime.</div>";
}
?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<?php include("Footer.php") ?>