<?php
session_start();

require_once '../../../lib.php';

$sys = $_GET['sys'];

if($sys)
	redirect("../employeepayments/");
$page_title="HRM";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<?php if(checkSubModule("hrm","employees")){?>
	<li><a class="button icon chat" href="../../hrm/employees/employees.php">Employees</a></li>
	<?php }if(checkSubModule("hrm","levels")){?>
	<li><a class="button icon chat" href="../../hrm/levels/levels.php">HR Levels</a></li>
	<?php }if(checkSubModule("hrm","employeeleaves")){?>
	<li><a class="button icon chat" href="../../hrm/employeeleaves/index.php">Leave Application</a></li>
	<?php }if(checkSubModule("hrm","assignments")){?>
	<li><a class="button icon chat" href="../../hrm/assignments/assignments.php">Assignments</a></li>
	<?php }if(checkSubModule("hrm","modules")){?>
	<li><a class="button icon chat" href="../../../modules/dms/documenttypes/documenttypes.php">Documents</a></li>
	
	
	<?php }if(checkSubModule("hrm","employeeoffs")){?>
	<li><a class="button icon chat" href="../../hrm/employeeoffs/employeeoffs.php">Employee Off Days</a></li>
	
	<?php }if(checkSubModule("hrm","employeeleaveapplications")){?>
	<!-- 	<li><a class="button icon chat" href="../../hrm/employeeleaveapplications/employeeleaveapplications.php">Leave Applications</a></li> -->
	
	<?php }if(checkSubModule("hrm","insurances")){?>
	<li><a class="button icon chat" href="../../hrm/employeebanks/index.php">Employee Banks AND Insurances</a></li>
	
	<?php }if(checkSubModule("hrm","contracttypes")){?>
	<li><a class="button icon chat" href="../../hrm/contracttypes/contracttypes.php">Contract Types</a></li>
	<li><a class="button icon chat" href="../../hrm/departments/departments.php">Departments </a></li>
	
	
	<?php }if(checkSubModule("hrm","qualifications")){?>
	<li><a class="button icon chat" href="../../hrm/qualifications/index.php">Employee Qualifications</a></li>
	
	<?php }if(checkSubModule("hrm","grades")){?>
	<li><a class="button icon chat" href="../../hrm/grades/grades.php">Job Grades</a></li>	
	<?php }if(checkSubModule("hrm","sections")){?>
	<li><a class="button icon chat" href="../../hrm/sections/sections.php">Sections</a></li>
	
	
	<?php }if(checkSubModule("hrm","employeestatuss")){?>
	<li><a class="button icon chat" href="../../hrm/employeestatuss/employeestatuss.php">Employee Status</a></li>
	<?php }if(checkSubModule("hrm","disciplinarytypes")){?>
	<li><a class="button icon chat" href="../../hrm/disciplinarytypes/disciplinarytypes.php">Disciplinary Types</a></li>
	<?php }if(checkSubModule("hrm","employeeclockings")){?>
	<li><a class="button icon chat" href="../../hrm/employeeclockings/employeeclocking.php">Casuals Register</a></li>
	<?php }if(checkSubModule("hrm","configs")){?>
	<li><a class="button icon chat" href="../../hrm/configs/configs.php">Hrm Configs</a></li>
	<li><a class="button icon chat" href="../../hrm/employeedeductionexempt/employeedeductionexempt.php">Employee Deduction Exempt</a></li>
	<?php }?>
</ul>
<?php
include"../../../foot.php";
?>
