<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Mixturefertilizers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Mixturefertilizers";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9230";//Add
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$mixturefertilizers=new Mixturefertilizers();
if(!empty($delid)){
	$mixturefertilizers->id=$delid;
	$mixturefertilizers->delete($mixturefertilizers);
	redirect("mixturefertilizers.php");
}
//Authorization.
$auth->roleid="9229";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addmixturefertilizers_proc.php?mixtureid=<?php echo $ob->mixtureid; ?>',600,430);" value="Add Mixturefertilizers " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Fertilizer </th>
			<th>Quantity </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9231";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9232";//Add
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
		$fields="prod_mixturefertilizers.id, prod_irrigationmixtures.id as mixtureid, prod_fetilizers.name as fertilizerid, prod_mixturefertilizers.quantity, prod_mixturefertilizers.remarks, prod_mixturefertilizers.ipaddress, prod_mixturefertilizers.createdby, prod_mixturefertilizers.createdon, prod_mixturefertilizers.lasteditedby, prod_mixturefertilizers.lasteditedon";
		$join=" left join prod_irrigationmixtures on prod_mixturefertilizers.mixtureid=prod_irrigationmixtures.id  left join prod_fetilizers on prod_mixturefertilizers.fertilizerid=prod_fetilizers.id ";
		$having="";
		$groupby="";
		$orderby="";
		if(!empty($obj->mixtureid))
		  $where=" where prod_irrigationmixtures.mixtureid='$ob->mixtureid' ";
		$mixturefertilizers->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();// echo $mixturefertilizers->sql;
		$res=$mixturefertilizers->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->fertilizerid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9231";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addmixturefertilizers_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9232";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='mixturefertilizers.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
