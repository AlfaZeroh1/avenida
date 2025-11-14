<?php
require_once "../DB.php";
$db = new DB();
$conn = $db->connection;

if (!empty($_POST['table'])) {
    $table = mysql_real_escape_string($_POST['table']);

    $result = mysql_query("SELECT * FROM `$table` LIMIT 100", $conn);
    if (!$result) {
        echo "Error fetching data.";
        exit;
    }

    echo "<table class='table table-bordered table-sm'>";
    echo "<thead><tr>";
    for ($i = 0; $i < mysql_num_fields($result); $i++) {
        $field = mysql_fetch_field($result, $i);
        echo "<th>{$field->name}</th>";
    }
    echo "</tr></thead><tbody>";

    while ($row = mysql_fetch_assoc($result)) {
        echo "<tr>";
        foreach ($row as $val) {
            echo "<td>".htmlspecialchars($val)."</td>";
        }
        echo "</tr>";
    }
    echo "</tbody></table>";
}
