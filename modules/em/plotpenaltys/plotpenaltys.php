<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Plotpenaltys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Plotpenaltys";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4330";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$plotpenaltys=new Plotpenaltys();
if(!empty($delid)){
	$plotpenaltys->id=$delid;
	$plotpenaltys->delete($plotpenaltys);
	redirect("plotpenaltys.php");
}
//Authorization.
$auth->roleid="4329";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addplotpenaltys_proc.php',600,430);" value="Add Plotpenaltys " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Plot </th>
			<th>Month </th>
			<th>Year </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4331";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4332";//Add
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
		$fields="em_plotpenaltys.id, em_plots.name as plotid, em_plotpenaltys.month, em_plotpenaltys.year, em_plotpenaltys.remarks";
		$join=" left join em_plots on em_plotpenaltys.plotid=em_plots.id ";
		$having="";
		$groupby="";
		$orderby="";
		$plotpenaltys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$plotpenaltys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->plotid; ?></td>
			<td><?php echo $row->month; ?></td>
			<td><?php echo $row->year; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4331";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addplotpenaltys_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4332";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='plotpenaltys.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
