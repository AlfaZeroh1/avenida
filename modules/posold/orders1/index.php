<?php
session_start();

$page_title="Sales";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<li><a class="button icon chat" href="../../pos/orders/orders.php">Orders</a></li>
	<li><a class="button icon chat" href="../../pos/shifts/shifts.php">Teams</a></li>
	<li><a class="button icon chat" href="../../pos/shifts/teams.php">Shifts</a></li>
	<li><a class="button icon chat" href="../../pos/teamroles/teamroles.php">Team Roles</a></li>
	<li><a class="button icon chat" href="../../pos/teamdetails/teamdetails.php">Team Details</a></li>
</ul>
<?php
include"../../../foot.php";
?>

