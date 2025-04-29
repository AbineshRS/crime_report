<style>
    .cont {
        min-height: 450px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table thead {
        background-color: #4e73df;
        color: #fff;
    }

    .table td,
    .table th {
        vertical-align: middle;
    }

    .table a {
        text-decoration: none;
    }

    .btn-custom {
        border-radius: 50px;
        padding: 8px 16px;
    }

    .header-title {
        font-size: 1.25rem;
        font-weight: 600;
    }

    .custom-card {
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .custom-card .card-body {
        padding: 2rem;
    }
</style>

<?php include("admin_nav.php") ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="container mt-4">
    <p class="header-title text-primary">Police Station List</p>
</div>

<div class="container mt-3 p-4 cont custom-card">
    <div class="table-responsive">
        <?php
        include("connection.php");

        $sql = "SELECT sr.Station_name, sr.District, sr.Address, sr.Registration_number,
                sr.Station_code, lg.Email, lg.Password, sr.ID  
                FROM stationregistration sr 
                INNER JOIN login lg ON sr.ID = lg.PId 
                WHERE lg.Usertype = 'Police_officer'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            ?>

            <table class="table">
                <thead>
                    <tr>
                        <th style="min-width: 150px;">Station Name</th>
                        <th style="min-width: 200px;">District</th>
                        <th style="min-width: 150px;">Address</th>
                        <th style="min-width: 120px;">Registration Number</th>
                        <th style="min-width: 120px;">Station Code</th>
                        <th style="min-width: 120px;">Username</th>
                        <th style="min-width: 120px;">Password</th>
                        <th style="min-width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Station_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['District']); ?></td>
                            <td><?php echo htmlspecialchars($row['Address']); ?></td>
                            <td><?php echo htmlspecialchars($row['Registration_number']); ?></td>
                            <td><?php echo htmlspecialchars($row['Station_code']); ?></td>
                            <td><?php echo htmlspecialchars($row['Email']); ?></td>
                            <td>pwd@123</td>
                            <td>
                                <a href="admin_view_detail_police.php?id=<?php echo $row['ID']; ?>"
                                    class="btn btn-outline-primary btn-custom">
                                    <i class="bi bi-eye-fill"></i> View
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <?php
        } else {
            echo "<div class='alert alert-info'>No stations found.</div>";
        }
        ?>
    </div>
</div>

<?php include('Footer.php') ?>