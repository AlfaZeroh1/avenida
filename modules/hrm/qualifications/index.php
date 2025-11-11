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
	<?php if(checkSubModule("hrm","qualifications")){?>
	<li><a class="button icon chat" href="../../hrm/qualifications/qualifications.php">Qualifications</a></li>
	<?php }if(checkSubModule("hrm","gradings")){?>
	<li><a class="button icon chat" href="../../hrm/gradings/gradings.php">Qualification Grades</a></li>






<?php } ?>
</ul>
<?php
include"../../../foot.php";
?>