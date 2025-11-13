<?php
require_once "../DB.php";
$db = new DB();
$conn = $db->connection;

if (!empty($_POST['table'])) {
    // Disable foreign key checks
    mysql_query("SET FOREIGN_KEY_CHECKS = 0", $conn);
    
    $table = mysql_real_escape_string($_POST['table']);
    $query = "TRUNCATE TABLE `$table`";
    if (mysql_query($query, $conn)) {
        echo "Table '$table' truncated successfully!";
    } else {
        echo "Failed to truncate table.";
    }
}
