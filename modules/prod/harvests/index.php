<?php
session_start();
require_once("../../../lib.php");
$page_title="Graded";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<?php if(checkSubModule("prod","harvests")){?>
	<li><a class="button icon chat" href="../../prod/harvests/harvests.php?status=checkedout">Pre-cool Check Out</a></li>
	<?php }if(checkSubModule("prod","harvests")){?>
	<li><a class="button icon chat" href="../../prod/harvests/harvests.php?status=stocktake">Pre-cool Stock Take</a></li>
	<?php }if(checkSubModule("prod","harvests")){?>
	<li><a class="button icon chat" href="../../prod/harvests/harvests.php?status=return">Pre-cool Returns</a></li>
	<?php }if(checkSubModule("prod","rejects")){?>
	<li><a class="button icon chat" href="../../prod/rejects/rejects.php?reduce=reduce">Pre-cool Store Rejects</a></li>
	<?php }if(checkSubModule("prod","varietys")){?>
	<li><a class="button icon chat" href="../../prod/varietys/varietys.php?precool=1">Varieties(Pre-cool)</a></li>
	
	
	<?php } ?>
</ul>
<?php
include"../../../foot.php";
?>