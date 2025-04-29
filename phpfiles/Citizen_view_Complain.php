<style>
    .cont {
        min-height: 450px;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

<?php include("Citizen_nav.php") ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="container">
    <p class="text-danger fs-4 ms-3 mt-4">My Cases</p>
</div>

<div class="container mt-3 p-3 cont">
    <div class="table-responsive">
        <?php
        include("connection.php");
        if (isset($_SESSION['Pid']) && !empty($_SESSION['Pid'])) {
            $station_id = $_SESSION['Pid'];

            $sql = "SELECT * FROM add_complaints WHERE UserId = $station_id";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                ?>

                <table class="table align-middle">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th style="min-width: 150px;">Victim Name</th>
                            <th style="min-width: 200px;">Type of Crime</th>
                            <th style="min-width: 150px;">Date</th>
                            <th style="min-width: 120px;">Location</th>
                            <th style="min-width: 120px;">Evidance</th>
                            <th style="min-width: 120px;">Status</th>
                            <th style="min-width: 150px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['Name']; ?></td>
                                <td><?php echo $row['Type_of_Crime']; ?></td>
                                <td><?php echo date('Y-m-d', strtotime($row['Date_time'])); ?></td>
                                <td><?php echo $row['Location_of_Incident']; ?></td>
                                <td>
                                    <?php if ($row['Status'] == 1) { ?>
                                        <a href="Citizen_view_evidance.php?id=<?php echo $row['ID']; ?>"
                                            class="btn btn-outline-success btn-sm">
                                            <i class="bi bi-paperclip"></i> Evidence
                                        </a>
                                    <?php } else { ?>
                                        <span class="text-muted">Not Available</span>
                                    <?php } ?>
                                </td>

                                <td>
                                    <?php
                                    if ($row['Status'] == 0) {
                                        echo '<span class="badge bg-warning text-dark mt-2"><i class="bi bi-clock-fill"></i> Pending</span>';
                                    } elseif ($row['Status'] == 1) {
                                        echo '<span class="badge bg-success mt-2"><i class="bi bi-check-circle-fill"></i> Approved</span>';
                                    } else {
                                        echo '<span class="badge bg-secondary">Unknown</span>';
                                    }
                                    ?>
                                </td>

                                <td>
                                    <a href="Citizen_Update_complain.php?id=<?php echo $row['ID']; ?>"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye-fill"></i> View
                                    </a>
                                </td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo "<div class='alert alert-info text-center'>Not found.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Station ID is not set in session.</div>";
        }
        ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

<?php include('Footer.php') ?>