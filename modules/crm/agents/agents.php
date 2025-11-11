<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Agents_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Agents";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4775";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$agents=new Agents();
if(!empty($delid)){
	$agents->id=$delid;
	$agents->delete($agents);
	redirect("agents.php");
}
//Authorization.
$auth->roleid="4774";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addagents_proc.php',600,430);" value="Add Agents " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Agent Name </th>
			<th>Address </th>
			<th>Tel No. </th>
			<th>Fax </th>
			<th>E-mail </th>
			<th>Status </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4776";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4777";//Add
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
		$fields="crm_agents.id, crm_agents.name, crm_agents.address, crm_agents.tel, crm_agents.fax, crm_agents.email, crm_statuss.name as statusid, crm_agents.remarks, crm_agents.createdby, crm_agents.createdon, crm_agents.lasteditedby, crm_agents.lasteditedon";
		$join=" left join crm_statuss on crm_agents.statusid=crm_statuss.id ";
		$having="";
		$groupby="";
		$orderby="";
		$agents->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$agents->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->address; ?></td>
			<td><?php echo $row->tel; ?></td>
			<td><?php echo $row->fax; ?></td>
			<td><?php echo $row->email; ?></td>
			<td><?php echo $row->statusid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4776";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addagents_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4777";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='agents.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
