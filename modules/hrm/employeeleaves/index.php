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
	  <?php if(checkSubModule("hrm","levelleavedays")){?>
	  <li><a class="button icon chat" href="../../hrm/levelleavedays/levelleavedays.php">HR Levels Leave Days</a></li>
	  <?php }if(checkSubModule("hrm","employeeleaves")){?>  
	  <li><a class="button icon chat" href="../../hrm/employeeleaves/employeeleaves.php">Employee Leave</a></li>
	  <?php }if(checkSubModule("hrm","leaves")){?>
	<li><a class="button icon chat" href="../../hrm/leaves/leaves.php">Leave Types</a></li>
	  <?php }
	  if(checkSubModule("hrm","leavesections")){?>
	<li><a class="button icon chat" href="../../hrm/leavesections/leavesections.php">Leave Sections</a></li>
	  <?php }if(checkSubModule("hrm","leavesections")){?>
	<li><a class="button icon chat" href="../../hrm/leavesectiondetails/leavesectiondetails.php">Leave Section Details</a></li>
	  <?php }if(checkSubModule("hrm","leavesections")){?>
	<li><a class="button icon chat" href="../../hrm/employeeleaves/employeeleaveapplications.php">Manage Leaves</a></li>
	  <?php }?>
</ul>
<?php
include"../../../foot.php";
?>