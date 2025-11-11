<?php
session_start();

$page_title="Assets";
include"../../../head.php";
?>
<ul id="cmd-buttons" style="list-style-type:none;">
	<li><a class="button icon chat" href="../../assets/departments/departments.php">Departments</a></li>
	<li><a class="button icon chat" href="../../assets/assets/addassets_proc.php?retrieve=">Assets</a></li>	
	<li><a class="button icon chat" href="../../assets/assets/assets.php">Assets Listing</a></li>
	<li><a class="button icon chat" href="../../assets/depreciations/depreciations.php">Depreciations</a></li>
	<li><a class="button icon chat" href="../../assets/categorys/categorys.php">Categorys</a></li>
	<li><a class="button icon chat" href="../../assets/insurers/insurers.php">Insurers</a></li>
	<li><a class="button icon chat" href="../../assets/breakdowns/breakdowns.php">Breakdowns</a></li>
	<li><a class="button icon chat" href="../../assets/insurances/insurances.php">Insurances</a></li>
	<li><a class="button icon chat" href="../../assets/consumables/consumables.php">Consumables</a></li>
</ul>
<?php
include"../../../foot.php";
?>
