<?php
session_start();

$page_title="Items";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<li><a class="button icon chat" href="../../pos/categorys/categorys.php">Categories</a></li>
	<li><a class="button icon chat" href="../../pos/departments/departments.php">Departments</a></li>
	<li><a class="button icon chat" href="../../pos/items/items.php">Item List</a></li>
	<li><a class="button icon chat" href="../../motor/vehicles/vehicles.php">Vehicles</a></li>
	<li><a class="button icon chat" href="../../motor/shippings/shippings.php">Shippings</a></li>
</ul>
<?php
include"../../../foot.php";
?>
