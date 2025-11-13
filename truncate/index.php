<?php
session_start();
require_once "../DB.php";
$db = new DB();
$conn = $db->connection;

// Fetch all tables in the database
$tables = [];
$result = mysql_query("SHOW TABLES", $conn);
while ($row = mysql_fetch_array($result)) {
    $tables[] = $row[0];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Tables - Truncate</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: #f8f9fa;
            padding: 20px;
        }
        .container-box {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
        }
        th {
            background: #343a40;
            color: #fff;
        }
        .btn {
            border-radius: 8px;
        }
        .home-btn {
            margin-bottom: 20px;
        }
        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr { display: block; }
            thead tr { display: none; }
            td { padding: 10px; border: none; position: relative; }
        }
    </style>
</head>
<body>
<div class="container container-box">
    <a href="index.php" class="btn btn-secondary home-btn">🏠 Home</a>
    <h2 class="mb-4">Database Tables</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Table Name</th>
                <th>View</th>
                <th>Truncate</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($tables as $table): ?>
            <tr>
                <td><?php echo $table; ?></td>
                <td><button class="btn btn-info btn-sm view-btn" data-table="<?php echo $table; ?>">View</button></td>
                <td><button class="btn btn-danger btn-sm truncate-btn" data-table="<?php echo $table; ?>">Truncate</button></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="viewModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Table Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="modal-content">
        Loading...
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function(){
    // View button
    $(".view-btn").click(function(){
        var table = $(this).data("table");
        $("#modal-content").html("Loading...");
        $.post("view_table.php", {table: table}, function(data){
            $("#modal-content").html(data);
            var myModal = new bootstrap.Modal(document.getElementById('viewModal'));
            myModal.show();
        });
    });

    // Truncate button
    $(".truncate-btn").click(function(){
        var table = $(this).data("table");
        Swal.fire({
            title: "Are you sure?",
            text: "This will remove ALL data from table: " + table,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, truncate it!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("truncate_table.php", {table: table}, function(data){
                    Swal.fire("Done!", data, "success");
                });
            }
        });
    });
});
</script>
</body>
</html>
