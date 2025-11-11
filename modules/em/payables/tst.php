<?php
echo "This Script takes sometime, do not close browser while this runs. Patience.........";
$page = shell_exec("php inv.php");
echo $page;
echo "Here";
?>
