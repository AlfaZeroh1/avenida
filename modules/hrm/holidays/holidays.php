<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Holidays_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Holidays";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="10589";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$holidays=new Holidays();
if(!empty($delid)){
	$holidays->id=$delid;
	$holidays->delete($holidays);
	redirect("holidays.php");
}
//Authorization.
$auth->roleid="10588";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addholidays_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name </th>
			<th>Date </th>
			<th>Recurse </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="10590";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="10591";//Add
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
		$fields="hrm_holidays.id, hrm_holidays.name, hrm_holidays.date, hrm_holidays.recurse, hrm_holidays.remarks, hrm_holidays.ipaddress, hrm_holidays.createdby, hrm_holidays.createdon, hrm_holidays.lasteditedby, hrm_holidays.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$holidays->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$holidays->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo formatDate($row->date); ?></td>
			<td><?php echo $row->recurse; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="10590";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addholidays_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="10591";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='holidays.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
