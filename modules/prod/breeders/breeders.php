<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Breeders_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Breeders";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8568";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$breeders=new Breeders();
if(!empty($delid)){
	$breeders->id=$delid;
	$breeders->delete($breeders);
	redirect("breeders.php");
}
//Authorization.
$auth->roleid="8567";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addbreeders_proc.php',600,430);" value="Add Breeders " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Code </th>
			<th>Breeder </th>
			<th>Contact </th>
			<th>Physical Address </th>
			<th>Tel </th>
			<th>Fax </th>
			<th>Email </th>
			<th>Cell Phone </th>
			<th>Status </th>
<?php
//Authorization.
$auth->roleid="8569";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8570";//View
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
		$fields="prod_breeders.id, prod_breeders.code, prod_breeders.name, prod_breeders.contact, prod_breeders.physicaladdress, prod_breeders.tel, prod_breeders.fax, prod_breeders.email, prod_breeders.cellphone, prod_breeders.status, prod_breeders.createdby, prod_breeders.createdon, prod_breeders.lasteditedby, prod_breeders.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$breeders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$breeders->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->code; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->contact; ?></td>
			<td><?php echo $row->physicaladdress; ?></td>
			<td><?php echo $row->tel; ?></td>
			<td><?php echo $row->fax; ?></td>
			<td><?php echo $row->email; ?></td>
			<td><?php echo $row->cellphone; ?></td>
			<td><?php echo $row->status; ?></td>
<?php
//Authorization.
$auth->roleid="8569";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addbreeders_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8570";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='breeders.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
