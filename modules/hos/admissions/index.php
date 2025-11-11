<?php
session_start();

?>
<?php
session_start();

$page_title="PatientAdmissions";
include"../../../head.php";

?>
<ul id="cmd-buttons">
	<li><a class="button icon" href="../admissions/admissions.php?status=1">Admissions Waiting List</a></li>
	<li><a class="button icon" href="../patientfoods/patientfoods.php?st=1">Patient's Food</a></li>
	<li><a class="button icon" href="../meals/meals.php?"> Meal Types</a></li>
	<li><a class="button icon" href="../foods/foods.php">Food Types</a></li>
	

</ul>
<?php
include"../../../foot.php";
?>
