<?php
session_start();

$page_title="Projects";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<li><a class="button icon chat" href="../../con/projectreviews/projectreviews.php">Project Reviews</a></li>
	<li><a class="button icon chat" href="../../con/subregions/subregions.php">Sub Region</a></li>
	<li><a class="button icon chat" href="../../con/projectquantities/projectquantities.php">Project Quantities</a></li>
	<li><a class="button icon chat" href="../../con/statuss/statuss.php">Status</a></li>
	<li><a class="button icon chat" href="../../con/projecttypes/projecttypes.php">Project Types</a></li>
	<li><a class="button icon chat" href="../../con/regions/regions.php">Regions</a></li>
	<li><a class="button icon chat" href="../../con/materialcategorys/materialcategorys.php">Material Categories</a></li>
	<li><a class="button icon chat" href="../../con/materialsubcategorys/materialsubcategorys.php">Material Sub-Categories</a></li>
	<li><a class="button icon chat" href="../../con/projects/projects.php">Projects</a></li>
	<li><a class="button icon chat" href="../../con/projectusage/projectusage.php">Project Usage</a></li>
	<li><a class="button icon chat" href="../../con/projectstatus/projectstatus.php">Project Status</a></li>
	<li><a class="button icon chat" href="../../proc/suppliers/suppliers.php?suppliercategoryid=1">Sub Contractors</a></li>
	<li><a class="button icon chat" href="../../con/projectsubcontractors/projectsubcontractors.php">Project Subcontractors</a></li>
	<li><a class="button icon chat" href="../../con/equipments/equipments.php">Equipment</a></li>
	<li><a class="button icon chat" href="../../con/estimationmanuals/estimationmanuals.php?type=material">Material Estimation Manuals</a></li>
	<li><a class="button icon chat" href="../../con/estimationmanuals/estimationmanuals.php?type=labour">Labour Estimation Manuals</a></li>
	<li><a class="button icon chat" href="../../con/labours/labours.php">Labour Lists</a></li>
	<li><a class="button icon chat" href="../../con/reviews/reviews.php">Review Items</a></li>
	<li><a class="button icon chat" href="../../con/projectreviews/projectreviews.php">Project Reviews</a></li>
</ul>
<?php
include"../../../foot.php";
?>
