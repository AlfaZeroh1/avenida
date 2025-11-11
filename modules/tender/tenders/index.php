<?php
session_start();

$page_title="Tenders";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<li><a class="button icon chat" href="../../tender/tendertypes/tendertypes.php">Tender Types</a></li>
	<li><a class="button icon chat" href="../../tender/checklist/checklist.php">Action Plan</a></li>
	<li><a class="button icon chat" href="../../tender/tenders/tenders.php">Master Tender Inventory List</a></li>
	<li><a class="button icon chat" href="../../tender/checklistcategorys/checklistcategorys.php">Checklist Categories</a></li>
	<li><a class="button icon chat" href="../../tender/checklistdocuments/checklistdocuments.php">Checklist Documents</a></li>
	<li><a class="button icon chat" href="../../tender/checklists/checklists.php">Checklists</a></li>
	<li><a class="button icon chat" href="../../tender/unitofmeasures/unitofmeasures.php">Units of Measure</a></li>
	<li><a class="button icon chat" href="../../tender/bqitems/bqitems.php">BQ List</a></li>
	<li><a class="button icon chat" href="../../tender/configs/configs.php">Configuration</a></li>
</ul>
<?php
include"../../../foot.php";
?>
