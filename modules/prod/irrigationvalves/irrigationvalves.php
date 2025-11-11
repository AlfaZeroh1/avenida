<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Irrigationvalves_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../valves/Valves_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Irrigationvalves";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9226";//Add
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];

if(!empty($delid)){
	$irrigationvalves->id=$delid;
	$irrigationvalves->delete($irrigationvalves);
	redirect("irrigationvalves.php");
}
//Authorization.
$auth->roleid="9225";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addirrigationvalves_proc.php',600,430);" value="Add Irrigationvalves " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Valve </th>
			<th>Green House </th>
			<th>Quantity </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9227";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9228";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$irrigationvalves=new Valves();
		$i=0;
		$fields="prod_valves.id valveid, prod_valves.name, prod_greenhouses.name greenhouseid";
		$join=" left join prod_greenhouses on prod_greenhouses.id=prod_valves.greenhouseid ";
		$having="";
		$groupby="";
		$orderby="";
		if(!empty($ob->systemid))
		  $where=" where prod_valves.systemid='$ob->systemid' ";
		$irrigationvalves->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$irrigationvalves->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->greenhouseid; ?></td>
			<td><input type="text" size="4" name=""/></td>
			<td><textarea name="remark"><?php echo $obj->remarks; ?></textarea></td>
<?php
//Authorization.
$auth->roleid="9227";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addirrigationvalves_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9228";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='irrigationvalves.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
