<?php
session_start();

$page_title="DMS";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<li><a class="button icon chat" href="../../dms/categorys/categorys.php">Categorys</a></li>
	<li><a class="button icon chat" href="../../dms/departments/departments.php">Departments</a></li>
	<li><a class="button icon chat" href="../../dms/departmentcategorys/departmentcategorys.php">Dept Categorys</a></li>
	<li><a class="button icon chat" href="../../dms/documenttypes/documenttypes.php">Document Types</a></li>
	<li><a class="button icon chat" href="../../dms/documentss/documentss.php">Documents</a></li>
</ul>
<?php
include"../../../foot.php";
?>
