<?php
session_start();

$page_title="Fleets";
include"../../../hd.php";
?>
<ul id="cmd-buttons" style="list-style-type:none;">
	<li><a class="button icon chat" href="../../assets/categorys/categorys.php">Categorys</a></li>
	<li><a class="button icon chat" href="../../assets/insurers/insurers.php">Insurers</a></li>
<!-- 	<li><a class="button icon chat" href="../../assets/breakdowns/breakdowns.php">Breakdowns</a></li> -->
	<li><a class="button icon chat" href="../../assets/insurances/insurances.php">Insurances</a></li>
	<li><a class="button icon chat" href="../../assets/assets/assets.php?equip=3">Equipment</a></li>
	<li><a class="button icon chat" href="../../assets/assets/assets.php?equip=4">Tools</a></li>
	<li><a class="button icon chat" href="../../con/equipments/equipments.php">Construction Equipment List</a></li>
	<li><a class="button icon chat" href="../../assets/inspectionitems/inspectionitems.php?categoryid=3">Inspection Items</a></li>
	<li><a class="button icon chat" href="../../assets/maintenancetypes/maintenancetypes.php">Maintenance Types</a></li><!--
	<li><a class="button icon chat" href="../../assets/maintenanceschedules/maintenanceschedules.php">Maintenance Schedules</a></li>
	<li><a class="button icon chat" href="../../assets/maintenances/maintenances.php">Equip Maintenance</a></li>-->
	<!--<li><a class="button icon chat" href="../../assets/fleetschedules/fleetschedules.php">Equipment Schedules</a></li>
	<li><a class="button icon chat" href="../../assets/fleetmaintenances/fleetmaintenances.php">Equipment Maintenance</a></li>--><!--
	<li><a class="button icon chat" href="../../assets/inspections/inspections.php">Equipment Inspections</a></li>
	<li><a class="button icon chat" href="../../assets/services/services.php">Equipment Services</a></li>
	<li><a class="button icon chat" href="../../assets/serviceschedules/serviceschedules.php">Services Schedules</a></li>-->
<!-- 	<li><a class="button icon chat" href="../../assets/servicetypes/servicetypes.php">Services Types</a></li> -->
</ul>
<?php
include"../../../foot.php";
?>
