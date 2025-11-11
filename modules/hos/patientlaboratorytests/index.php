<?php
session_start();

$page_title="Patientlaboratorytests";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<li><a class="button icon" href="patientslaboratorytests.php">PATIENT LABORATORY TESTS</a></li>
	<li><a class="button icon" href="../laboratorytests/laboratorytests.php">LABORATORY TESTS</a></li>
	<li><a class="button icon" href="../../hos/tests/tests.php">TESTS LIST</a></li>
	<li><a class="button icon" href="javascript:;" onclick="showPopWin('../patientlaboratorytests/addpatientlaboratorytestss_proc.php?id=<?php echo $row->id; ?>', 600, 430);">Laboratory Self request</a></li>
	<li><a class="button icon chat" href="../../inv/items/items.php?departmentid=2">Items</a></li>
	<li><a class="button icon chat" href="../../inv/departmentcategorys/departmentcategorys.php?departmentid=2">Dept Categories</a></li>
	
	<li><a class="button icon chat" href="../../inv/issuance/issuance.php">Issuance</a></li>
</ul>
</div>

</div>
</div>

</div>
<div class="clearb"></div>
<?php
include"../../../foot.php";
?>
