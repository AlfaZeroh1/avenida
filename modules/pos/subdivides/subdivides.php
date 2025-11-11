<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Subdivides_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Subdivides";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="2217";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$subdivides=new Subdivides();
if(!empty($delid)){
	$subdivides->id=$delid;
	$subdivides->delete($subdivides);
	redirect("subdivides.php");
}
//Authorization.
$auth->roleid="2216";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addsubdivides_proc.php',600,430);" value="Add Subdivides " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Item </th>
			<th>New Item </th>
			<th>Subdivided On </th>
			<th>Remarks </th>
			<th>Memo </th>
<?php
//Authorization.
$auth->roleid="2218";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="2219";//View
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
		$fields="pos_subdivides.id, pos_items.name as itemid, pos_items2.name as newitemid, pos_subdivides.subdividedon, pos_subdivides.remarks, pos_subdivides.memo, pos_subdivides.createdby, pos_subdivides.createdon, pos_subdivides.lasteditedby, pos_subdivides.lasteditedon, pos_subdivides.ipaddress";
		$join=" left join pos_items on pos_subdivides.itemid=pos_items.id  left join pos_items2 on pos_subdivides.newitemid=pos_items2.id ";
		$having="";
		$groupby="";
		$orderby="";
		$subdivides->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$subdivides->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo $row->newitemid; ?></td>
			<td><?php echo formatDate($row->subdividedon); ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->memo; ?></td>
<?php
//Authorization.
$auth->roleid="2218";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addsubdivides_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="2219";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='subdivides.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
