<?php
session_start();
require_once("../../../lib.php");
$page_title="Sales";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<?php if(checkSubModule("pos","categorys")){?>
	<li><a class="button icon chat" href="../../pos/categorys/index.php">Products</a></li>
	<?php }if(checkSubModule("crm","customers")){?>
	<li><a class="button icon chat" href="../../crm/customerissues/index.php">Customers</a></li>
	
	<?php }if(checkSubModule("pos","seasons")){?>
	<li><a class="button icon chat" href="../../pos/seasons/seasons.php">Seasons</a></li>
	<li><a class="button icon chat" href="../../crm/continents/continents.php">Continents</a></li>
	<?php }if(checkSubModule("crm","countrys")){?>
	<li><a class="button icon chat" href="../../crm/countrys/countrys.php">Countries</a></li><!--
	
	
	<?php }if(checkSubModule("crm","agents")){?>
	<li><a class="button icon chat" href="../../crm/agents/agents.php">Shipping Agents</a></li>
	<?php }if(checkSubModule("pos","orders")){?>
	<li><a class="button icon chat" href="../../pos/orders/orders.php">Orders</a></li>
	<?php }if(checkSubModule("pos","orders")){?>
	<li><a class="button icon chat" href="../../pos/orders/orders.php?retrieve=1">Retrieve Orders</a></li>
	<?php }if(checkSubModule("pos","confirmedorders")){?>
	<li><a class="button icon chat" href="../../pos/confirmedorders/confirmedorders.php">Confirmed Orders</a></li><!--
	<?php }if(checkSubModule("pos","packinglists")){?>
	<li><a class="button icon chat" href="../../pos/packinglists/packinglists.php">Packing Lists</a></li>-->
	<?php }if(checkSubModule("pos","packinglists")){?>
	<li><a class="button icon chat" href="../../pos/packinglists/addpackinglists_proc.php?returns=1&retrieve=1">Box 
	Returns</a></li>
	<?php }if(checkSubModule("pos","packinglists")){?>
	<li><a class="button icon chat" href="../../pos/packinglists/addpackinglists_proc.php?retrieve=1">Retrieve Packing 
	Lists</a></li>
	<!-- 	<?php }if(checkSubModule("pos","invoices")){?>
	<li><a class="button icon chat" href="../../pos/invoices/invoices.php">Invoices</a></li> -->
	<?php }if(checkSubModule("pos","invoices")){?>
	<li><a class="button icon chat" href="../../pos/invoices/invoices.php?retrieve=1&parent=1">Shipping Invoice</a></li>
	<?php }if(checkSubModule("pos","invoices")){?>
	<li><a class="button icon chat" href="../../pos/invoices/invoices.php?retrieve=1">Retrieve Invoices</a></li>
	<?php }if(checkSubModule("pos","returninwards")){?>
	<li><a class="button icon chat" href="../../pos/returninwards/returninwards.php">Credit Note</a></li>
	<?php }if(checkSubModule("sys","currencys")){?>
	<li><a class="button icon chat" href="../../sys/currencys/currencys.php">Currencies</a></li>
	<?php }if(checkSubModule("pos","sales")){?>
	<li><a class="button icon chat" href="../../pos/sales/barcodegen.php">Graded Bar Codes</a></li>
	<?php }if(checkSubModule("pos","sales")){?>
	<li><a class="button icon chat" href="../../pos/sales/barcodegen.php?downsize=1">Downsizing Bar Codes</a></li>
	<?php }if(checkSubModule("pos","sales")){?>
	<li><a class="button icon chat" href="../../pos/sales/barcodegen2.php">Box Bar Codes</a></li>
	<?php }if(checkSubModule("pos","config")){?>
	<li><a class="button icon chat" href="../../pos/config/config.php">Configuration</a></li>
	<?php }if(checkSubModule("pos","configaccounts")){?>
	<li><a class="button icon chat" href="../../pos/configaccounts/configaccounts.php">Configuration Accounts</a></li>
	<?php }if(checkSubModule("pos","saletypes")){?>
	<li><a class="button icon chat" href="../../pos/saletypes/saletypes.php">Sale Types</a></li>
	<?php }if(checkSubModule("pos","freights")){?>
	<li><a class="button icon chat" href="../../pos/freights/freights.php">Inco Terms</a></li>
	
	<?php } ?>
</ul>
<?php
include"../../../foot.php";
?>

