<?php
session_start();

$page_title="Patienttreatments";
include"../../../head.php";

?>
<ul id="cmd-buttons">
<!-- 	<li><a class="button icon" href="patienttreatments.php?admission=No">Out-Patient (Dental)</a></li> -->
	<li><a class="button icon" href="patienttreatmentss.php?admission=No">Out-Patient (General)</a></li>
<!-- 	<li><a class="button icon" href="patienttreatments.php?admission=Yes">In-Patient</a></li> -->
	<li><a class="button icon" href="../patientappointments/patientappointments.php?st=1">Patient Observations</a></li>
	<li><a class="button icon" href="../patientappointments/patientappointments.php?st=2">Waiting List</a></li>
<!-- 	<li><a class="button icon" href="../patientprescriptions/patientprescriptions.php">Patient Prescriptions</a></li> -->
	<li><a class="button icon" href="../vitalsigns/vitalsigns.php">Vital Signs</a></li>
<!-- 	<li><a class="button icon" href="../admissions/index.php">Patient Admissions</a></li> -->
	<li><a class="button icon" href="../diagnosis/diagnosis.php">Diagnosis List</a></li>

</ul>
<?php
include"../../../foot.php";
?>
