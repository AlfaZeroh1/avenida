<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Customers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Customers";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4791";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$customers=new Customers();
if(!empty($delid)){
	$customers->id=$delid;
	$customers->delete($customers);
	redirect("customers.php");
}
//Authorization.
$auth->roleid="4790";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addcustomers_proc.php',600,630);" value="Add Customers " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Customer Name </th>
			<th>Parent</th>
			<th>Agent Name </th>
			<th>Department </th>
			<th>Currency</th>
			<th>Status </th>
			<th>FLO</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
<?php
//Authorization.
$auth->roleid="4792";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4793";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="crm_customers.id, crm_customers.code, customers.name parent, crm_customers.name, crm_agents.name as agentid, crm_departments.name as departmentid, crm_continents.name as continentid, crm_countrys.name as countryid, sys_currencys.name as currencyid, hrm_employees.id as employeeid, crm_customers.idno, crm_customers.pinno, crm_customers.address, crm_customers.tel, crm_customers.fax, crm_customers.email, crm_customers.contactname, crm_customers.contactphone, crm_customers.nextofkin, crm_customers.nextofkinrelation, crm_customers.nextofkinaddress, crm_customers.nextofkinidno, crm_customers.nextofkinpinno, crm_customers.nextofkintel, crm_customers.creditlimit, crm_customers.creditdays, crm_customers.discount, crm_customers.showlogo, crm_statuss.name as statusid, crm_customers.flo, crm_customers.remarks, crm_customers.createdby, crm_customers.createdon, crm_customers.lasteditedby, crm_customers.lasteditedon, crm_customers.ipaddress";
		$join=" left join crm_agents on crm_customers.agentid=crm_agents.id  left join crm_departments on crm_customers.departmentid=crm_departments.id  left join crm_continents on crm_customers.continentid=crm_continents.id  left join crm_countrys on crm_customers.countryid=crm_countrys.id  left join sys_currencys on crm_customers.currencyid=sys_currencys.id  left join hrm_employees on crm_customers.employeeid=hrm_employees.id  left join crm_statuss on crm_customers.statusid=crm_statuss.id left join crm_customers customers on customers.id=crm_customers.customerid ";
		$having="";
		$groupby="";
		$orderby=" order by trim(crm_customers.name) ";
		$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$res=$customers->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo strtoupper($row->name); ?></td>
			<td><?php echo $row->parent; ?></td>
			<td><?php echo $row->agentid; ?></td>
			<td><?php echo $row->departmentid; ?></td>
			<td><?php echo $row->currencyid; ?></td>
			<td><?php echo $row->statusid; ?></td>
			<td><?php echo $row->flo; ?></td>
			<td><a href="../customerprices/customerprices.php?customerid=<?php echo $row->id; ?>">Prices</td>
			<td><a href="../customerseasons/customerseasons.php?customerid=<?php echo $row->id; ?>">Seasons</td>
<?php
//Authorization.
$auth->roleid="4792";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcustomers_proc.php?id=<?php echo $row->id; ?>',600,630);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4793";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='customers.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
