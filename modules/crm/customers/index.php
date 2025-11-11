<?php
session_start();

$page_title="Sales";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<li><a class="button icon chat" href="../../crm/categorys/categorys.php">Customer Categories</a></li>
	<li><a class="button icon chat" href="../../crm/agents/agents.php">Sale Agents</a></li>
	<li><a class="button icon chat" href="../../crm/departmentcategorys/departmentcategorys.php">Dept Category</a></li>
	<li><a class="button icon chat" href="../../crm/departments/departments.php">Customer Departments</a></li>
	<li><a class="button icon chat" href="../../crm/customerconsignees/customerconsignees.php">Customer Consignees</a></li>
	<li><a class="button icon chat" href="../../crm/customers/customers.php">Customers</a></li>
	<li><a class="button icon chat" href="../../crm/customerissues/customerissues.php">Customer Issues</a></li>
	<li><a class="button icon chat" href="../../crm/customervisits/customervisits.php">Customer Visits</a></li>	
	<li><a class="button icon chat" href="../../crm/potentialcustomers/potentialcustomers.php">Potential Customers</a></li>
	<li><a class="button icon chat" href="../../crm/potentialcustomervisits/potentialcustomervisits.php">Potential Customer Visits</a></li>
</ul>
<?php
include"../../../foot.php";
?>
