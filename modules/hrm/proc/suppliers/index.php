<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../inv/departments/Departments_class.php");

$db=new DB();

$page_title="Suppliers";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<?php if(checkSubModule("proc","requisitions")){?>
<!-- 	<li><a class="button icon chat" href="../../proc/requisitions/index.php">Requisitions</a></li> -->
	<?php } if(checkSubModule("proc","supplieritems")){?>
	<li><a class="button icon chat" href="../../proc/supplieritems/index.php">Suppliers</a></li>
	<?php } if(checkSubModule("proc","purchaseorders")){?>
	<li><a class="button icon chat" href="../../proc/purchaseorders/addpurchaseorders_proc.php">L.P.O's</a></li>
	<?php }if(checkSubModule("proc","deliverynotes")){?>
<!-- 	<li><a class="button icon chat" href="../../proc/deliverynotes/index.php">Delivery Notes</a></li> -->
	<?php } if(checkSubModule("proc","supplieritems")){?>
<!-- 	<li><a class="button icon chat" href="../../proc/inwards/index.php">G.R.N's</a></li> -->
 	<?php }if(checkSubModule("proc","requisitions")){?>
<!-- 	<li><a class="button icon chat" href="../../proc/requisitions/reconciliation.php">Reconciliation</a></li> -->
	<?php }if(checkSubModule("proc","config")){?>
<!-- 	<li><a class="button icon chat" href="../../proc/config/config.php">Configuration</a></li> -->
	<?php
	}
	?>
</ul>
<?php
include"../../../foot.php";
?>