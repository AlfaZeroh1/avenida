<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");

redirect("route.php");

$page_title="Routes";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<li><a class="button icon chat" href="../../dms/documenttypes/documenttypes.php">Document Types</a></li>
	<li><a class="button icon chat" href="../../wf/routes/routes.php">Routes</a></li>
	<li><a class="button icon chat" href="../../dms/departmentcategorys/departmentcategorys.php">Dept Categories</a></li>
	<li><a class="button icon chat" href="../../wf/systemtasks/systemtasks.php">System Tasks</a></li>
	<li><a class="button icon chat" href="../../dms/departments/departments.php">Departments</a></li>
	<li><a class="button icon chat" href="../../wf/routedetails/routedetails.php">Route Details</a></li>
	<li><a class="button icon chat" href="../../dms/categorys/categorys.php">Categories</a></li>
	<li><a class="button icon chat" href="../../wf/documentflows/documentflows.php">Document Flows</a></li>
	<li><a class="button icon chat" href="../../dms/documentss/documentss.php">Documents</a></li>
</ul>
<?php
include"../../../foot.php";
?>
