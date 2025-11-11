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
$auth->roleid="8412";//View
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
$auth->roleid="8411";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addagents_proc.php',600,430);" value="Add Agents " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Agent </th>
			<th>Agent ID </th>
			<th>Agent Type </th>
			<th>Region </th>
			<th>Sub Region </th>
			<th>Contact Person </th>
			<th>Telephone </th>
			<th>Mobile </th>
			<th>E-mail </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8413";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8414";//View
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
		$fields="reg_agents.id, reg_agents.name, reg_agents.agentid, reg_agents.agenttypeid, reg_regions.name as regionid, reg_subregions.name as subregionid, reg_agents.contactperson, reg_agents.tel, reg_agents.mobile, reg_agents.email, reg_agents.remarks, reg_agents.ipaddress, reg_agents.createdby, reg_agents.createdon, reg_agents.lasteditedby, reg_agents.lasteditedon";
		$join=" left join reg_regions on reg_agents.regionid=reg_regions.id  left join reg_subregions on reg_agents.subregionid=reg_subregions.id ";
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
			<td><?php echo $row->agentid; ?></td>
			<td><?php echo $row->agenttypeid; ?></td>
			<td><?php echo $row->regionid; ?></td>
			<td><?php echo $row->subregionid; ?></td>
			<td><?php echo $row->contactperson; ?></td>
			<td><?php echo $row->tel; ?></td>
			<td><?php echo $row->mobile; ?></td>
			<td><?php echo $row->email; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8413";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addagents_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8414";//View
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
