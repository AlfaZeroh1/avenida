<?php
session_start();

$page_title="Wards";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<li><a class="button icon" href="../admissions/admissions.php?status=0">Admissions</a></li>
	<li><a class="button icon" href="wards.php">Wards</a></li>
	<li><a class="button icon" href="../beds/beds.php">Beds</a></li>
</ul>
</ul>
<?php
include"../../../foot.php";
?>
