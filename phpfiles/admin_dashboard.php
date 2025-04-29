<?php include("admin_nav.php") ?>

<style>
    .box {
        height: 140px;
        border-radius: 12px;
        background-color: rgb(3, 74, 161);
    }

    .container {
        max-width: 1000px;
    }

    canvas {
        border-radius: 10px;
        background: #f4f4f4;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 15px;
    }

    .row .col-12 {
        margin-bottom: 15px;
    }
</style>

<?php
include("connection.php");

// Citizen Count
$sql = "SELECT COUNT(*) AS citizen_count FROM citizen ct INNER JOIN login lg ON ct.id = lg.PId WHERE lg.Usertype = 'Citizen'";
$result = $conn->query($sql);
$citizen = ($result && $row = $result->fetch_assoc()) ? $row['citizen_count'] : 0;

// Police Station Count
$sql2 = "SELECT COUNT(*) AS police_count FROM stationregistration st INNER JOIN login lg ON st.id = lg.PId WHERE lg.Usertype = 'Police_officer'";
$result2 = $conn->query($sql2);
$police = ($result2 && $row = $result2->fetch_assoc()) ? $row['police_count'] : 0;

// Complaints Count
$sql3 = "SELECT COUNT(*) AS complains FROM add_complaints";
$result3 = $conn->query($sql3);
$complains = ($result3 && $row = $result3->fetch_assoc()) ? $row['complains'] : 0;

// Monthly Crime Data (Only Status=1)
$monthlyCrimes = [];
$sql4 = "
    SELECT DATE_FORMAT(Date_time, '%b %Y') AS month, COUNT(*) AS crime_count 
    FROM add_complaints 
    WHERE Status = 1
    GROUP BY DATE_FORMAT(Date_time, '%Y-%m') 
    ORDER BY DATE_FORMAT(Date_time, '%Y-%m') ASC
";
$result4 = $conn->query($sql4);

$months = [];
$counts = [];
if ($result4) {
    while ($row = $result4->fetch_assoc()) {
        $months[] = $row['month'];
        $counts[] = $row['crime_count'];
    }
}

// Crimes per District (ALL, without checking Status)
$sql5 = "
    SELECT District, COUNT(*) AS crime_count 
    FROM add_complaints 
    GROUP BY District
    ORDER BY crime_count DESC
";
$result5 = $conn->query($sql5);

$districts = [];
$crimeCounts = [];
if ($result5) {
    while ($row = $result5->fetch_assoc()) {
        $districts[] = $row['District'];
        $crimeCounts[] = $row['crime_count'];
    }
}
?>

<div class="container mt-5 mb-5">
    <div class="row g-4">
        <!-- Citizen Box -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="box d-flex flex-column justify-content-between text-white p-3 h-100">
                <div class="d-flex align-items-center justify-content-center flex-grow-1">
                    <p class="m-0 fs-5 text-center w-100">Citizen</p>
                </div>
                <div class="d-flex justify-content-between px-2">
                    <span class="fw-bold"><?php echo $citizen ?></span>
                    <span>active</span>
                </div>
            </div>
        </div>

        <!-- Police Station Box -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="box d-flex flex-column justify-content-between text-white p-3 h-100">
                <div class="d-flex align-items-center justify-content-center flex-grow-1">
                    <p class="m-0 fs-5 text-center w-100">Police Station</p>
                </div>
                <div class="d-flex justify-content-between px-2">
                    <span class="fw-bold"><?php echo $police ?></span>
                    <span>active</span>
                </div>
            </div>
        </div>

        <!-- Complaints Box -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="box d-flex flex-column justify-content-between text-white p-3 h-100">
                <div class="d-flex align-items-center justify-content-center flex-grow-1">
                    <p class="m-0 fs-5 text-center w-100">Complaints</p>
                </div>
                <div class="d-flex justify-content-between px-2">
                    <span class="fw-bold"><?php echo $complains ?></span>
                    <span>active</span>
                </div>
            </div>
        </div>

        <!-- Crimes Box -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="box d-flex flex-column justify-content-between text-white p-3 h-100">
                <div class="d-flex align-items-center justify-content-center flex-grow-1">
                    <p class="m-0 fs-5 text-center w-100">Crimes</p>
                </div>
                <div class="d-flex justify-content-between px-2">
                    <span class="fw-bold"><?php echo $complains ?></span>
                    <span>active</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Crime Report -->
    <div class="container mt-5">
        <h4 class="text-center mb-4">Monthly Crime Report</h4>
        <canvas id="crimeChart" height="100"></canvas>
    </div>

    <!-- Crimes per District Report -->
    <div class="container mt-5">
        <h4 class="text-center mb-4">Total Crimes per District</h4>
        <canvas id="districtCrimeChart" height="100"></canvas>

       

    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly Crime Chart
    const ctx1 = document.getElementById('crimeChart').getContext('2d');
    const crimeChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($months); ?>,
            datasets: [{
                label: 'Complaints (Status = 1)',
                data: <?php echo json_encode($counts); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Monthly Complaints (Status = 1)'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0,
                    title: {
                        display: true,
                        text: 'Number of Complaints'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Month'
                    }
                }
            }
        }
    });

    // Crimes per District Chart
    const ctx2 = document.getElementById('districtCrimeChart').getContext('2d');
    const districtCrimeChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($districts); ?>,
            datasets: [{
                label: 'Crimes per District',
                data: <?php echo json_encode($crimeCounts); ?>,
                backgroundColor: '#007bff',
                borderColor: '#0056b3',
                borderWidth: 2,
                hoverBackgroundColor: '#0056b3',
                hoverBorderColor: '#004085'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Crimes per District'
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw + ' crimes';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0,
                    title: {
                        display: true,
                        text: 'Crime Count'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'District'
                    },
                    ticks: {
                        autoSkip: false,
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    });
</script>

<?php include("Footer.php") ?>
