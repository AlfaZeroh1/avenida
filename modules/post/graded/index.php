<?php
session_start();
require_once("../../../lib.php");
$page_title="Graded";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<?php if(checkSubModule("post","teams")){?>
	<li><a class="button icon chat" href="../../post/teams/index.php">Teams</a></li>
	<?php } if(checkSubModule("post","teamroles")){?>
	<li><a class="button icon chat" href="../../post/teamroles/index.php">Barcodes</a></li>
	<?php }if(checkSubModule("prod","harvests")){?>
	<li><a class="button icon chat" href="../../prod/harvests/index.php?status=checkedout">Pre-cool Stores</a></li>
	<?php } if(checkSubModule("post","teamsmembers")){?>
	<li><a class="button icon chat" href="../../post/teammembers/index.php">Cold Stores</a></li>
	<?php } if(checkSubModule("post","harvestrejects")){?>
	<li><a class="button icon chat" href="../../post/harvestrejects/harvestrejects.php">Packing Hall Rejects</a></li>
	<?php } if(checkSubModule("post","graded")){?>
	<li><a class="button icon chat" href="../../post/graded/addgraded_proc.php?status=checkedin">Newly Graded To Cold Store</a></li>
	<li><a class="button icon chat" href="../../post/graded/addgraded_proc.php?status=regradedout">From Cold Store for Downsizing</a></li>
	<li><a class="button icon chat" href="../../post/graded/addgraded_proc.php?status=regradedin">Downsizing Back To Cold Store </a></li>
	<li><a class="button icon chat" href="../../post/graded/addgraded_proc.php?status=rebunchingin">Rebunching Back To Cold Store</a></li>
	<li><a class="button icon chat" href="../../post/graded/addgraded_proc.php?status=rebunchinout"> From Cold Store for Rebunching</a></li>
	<?php } if(checkSubModule("post","graded")){?>
	<li><a class="button icon chat" href="../../post/graded/addgraded_proc.php?status=discarded returns">Discarded Returns</a></li>
	<?php } if(checkSubModule("prod","harvests")){?>
	<li><a class="button icon chat" href="../../prod/harvests/harvests.php?status=checkedin">Harvest</a></li>
	<?php } if(checkSubModule("pos","confirmedorders")){?>
	<li><a class="button icon chat" href="../../pos/confirmedorders/confirmedorders.php">Confirmed Orders</a></li>
	
	<li><a class="button icon chat" href="../../post/graded/check.php">Audit Barcodes</a></li>
	<li><a class="button icon chat" href="../../post/barcodes/check.php">Barcodes Ageing</a></li>
	
	<?php } ?>
</ul>
<?php
include"../../../foot.php";
?>
