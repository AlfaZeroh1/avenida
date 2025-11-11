<?php
session_start();

$page_title="Sales";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<li><a class="button icon chat" href="../../pos/departments/departments.php">Product Depts</a></li>
	<li><a class="button icon chat" href="../../pos/categorys/categorys.php">Product Categories</a></li>
	<li><a class="button icon chat" href="../../pos/sizes/sizes.php">Product Sizes</a></li>
	<li><a class="button icon chat" href="../../pos/colours/colours.php">Product Colours</a></li>
	<li><a class="button icon chat" href="../../pos/items/items.php">Products</a></li>
	<li><a class="button icon chat" href="../../pos/seasons/seasons.php">Seasons</a></li>
	<li><a class="button icon chat" href="../../crm/customers/customers.php">Customers</a></li>
	<li><a class="button icon chat" href="../../crm/customerconsignees/customerconsignees.php">Customer Consignees</a></li>
	<li><a class="button icon chat" href="../../crm/continents/continents.php">Continents</a></li>
	<li><a class="button icon chat" href="../../crm/countrys/countrys.php">Countries</a></li><!--
	<li><a class="button icon chat" href="../../crm/customerprices/customerprices.php">Customer Prices</a></li>-->
	<li><a class="button icon chat" href="../../crm/customerseasons/customerseasons.php">Customer Seasons</a></li>
	<li><a class="button icon chat" href="../../crm/agents/agents.php">Shipping Agents</a></li>
	<li><a class="button icon chat" href="../../crm/departments/departments.php">Customer Departments</a></li>
	<li><a class="button icon chat" href="../../pos/orders/orders.php">Orders</a></li>
	<li><a class="button icon chat" href="../../pos/orders/orders.php?retrieve=1">Retrieve Orders</a></li>
	<li><a class="button icon chat" href="../../pos/confirmedorders/confirmedorders.php">Confirmed Orders</a></li><!--
	<li><a class="button icon chat" href="../../pos/packinglists/packinglists.php">Packing Lists</a></li>-->
<!--	<li><a class="button icon chat" href="../../pos/packinglists/addpackinglists_proc.php?returns=1&retrieve=1">Box Returns</a></li>-->
	<li><a class="button icon chat" href="../../pos/packinglists/addpackinglists_proc.php?retrieve=1">Retrieve Packing Lists</a></li>
<!-- 	<li><a class="button icon chat" href="../../pos/invoices/invoices.php">Invoices</a></li> -->
	<li><a class="button icon chat" href="../../pos/invoices/invoices.php?retrieve=1&parent=1">Shipping Invoice</a></li>
	<li><a class="button icon chat" href="../../pos/invoices/invoices.php?retrieve=1">Retrieve Invoices</a></li>
	<li><a class="button icon chat" href="../../pos/returninwards/returninwards.php?types=credit">Credit Note</a></li>
	<li><a class="button icon chat" href="../../pos/returninwards/returninwards.php?types=debit">Debit Note</a></li>
	<li><a class="button icon chat" href="../../pos/returninwards/returninwards.php?retrieve=1">Retrieve Credit Note</a></li>
	<li><a class="button icon chat" href="../../sys/currencys/currencys.php">Currencies</a></li>
	<li><a class="button icon chat" href="../../pos/sales/barcodegen.php">Graded Bar Codes</a></li>
	<li><a class="button icon chat" href="../../post/barcodes/barcodes.php">Reprint Graded Bar Codes</a></li>
	<li><a class="button icon chat" href="../../pos/sales/barcodegen.php?downsize=1">Downsizing Bar Codes</a></li>
	<li><a class="button icon chat" href="../../pos/sales/barcodegen2.php">Box Bar Codes</a></li>
	<li><a class="button icon chat" href="../../pos/config/config.php">Configuration</a></li>
	<li><a class="button icon chat" href="../../pos/configaccounts/configaccounts.php">Configuration Accounts</a></li>
	<li><a class="button icon chat" href="../../pos/saletypes/saletypes.php">Sale Types</a></li>
	<li><a class="button icon chat" href="../../pos/freights/freights.php">Inco Terms</a></li>
</ul>
<?php
include"../../../foot.php";
?>

