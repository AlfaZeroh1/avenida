<?php
session_start();
require_once("../../../lib.php");
$page_title="Sales";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<?php if(checkSubModule("crm","customers")){?>
	<li><a class="button icon chat" href="../../crm/customers/customers.php">Customers</a></li>
	<?php }if(checkSubModule("crm","customerconsignees")){?>
	<li><a class="button icon chat" href="../../crm/customerconsignees/customerconsignees.php">Customer Consignees</a></li>
	<?php }if(checkSubModule("crm","customerseasons")){?>
	<li><a class="button icon chat" href="../../crm/customerseasons/customerseasons.php">Customer Seasons</a></li>
	<?php }if(checkSubModule("crm","departments")){?>
	<li><a class="button icon chat" href="../../crm/departments/departments.php">Customer Departments</a></li>
	<?php }if(checkSubModule("crm","continents")){?>
	<?php }if(checkSubModule("crm","customerprices")){?>
<!-- 	<li><a class="button icon chat" href="../../crm/customerprices/customerprices.php">Customer Prices</a></li>-->
	
	
	<?php } ?>
</ul>
<?php
include"../../../foot.php";
?>