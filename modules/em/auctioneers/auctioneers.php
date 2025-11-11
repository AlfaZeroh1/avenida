<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Auctioneers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Auctioneers";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4096";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$auctioneers=new Auctioneers();
if(!empty($delid)){
	$auctioneers->id=$delid;
	$auctioneers->delete($auctioneers);
	redirect("auctioneers.php");
}
//Authorization.
$auth->roleid="4095";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addauctioneers_proc.php',600,430);" value="Add Auctioneers " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>First Name </th>
			<th>Middle Name </th>
			<th>Last Name </th>
			<th>Telephone </th>
			<th>Email </th>
			<th>Fax </th>
			<th>Mobile </th>
			<th>National ID No </th>
			<th>Passport No </th>
			<th>Postal Address </th>
			<th>Physical Address </th>
			<th> </th>
<?php
//Authorization.
$auth->roleid="4097";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4098";//View
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
		$fields="em_auctioneers.id, em_auctioneers.firstname, em_auctioneers.middlename, em_auctioneers.lastname, em_auctioneers.tel, em_auctioneers.email, em_auctioneers.fax, em_auctioneers.mobile, em_auctioneers.idno, em_auctioneers.passportno, em_auctioneers.postaladdress, em_auctioneers.address, em_auctioneers.status";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$auctioneers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$auctioneers->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->firstname; ?></td>
			<td><?php echo $row->middlename; ?></td>
			<td><?php echo $row->lastname; ?></td>
			<td><?php echo $row->tel; ?></td>
			<td><?php echo $row->email; ?></td>
			<td><?php echo $row->fax; ?></td>
			<td><?php echo $row->mobile; ?></td>
			<td><?php echo $row->idno; ?></td>
			<td><?php echo $row->passportno; ?></td>
			<td><?php echo $row->postaladdress; ?></td>
			<td><?php echo $row->address; ?></td>
			<td><?php echo $row->status; ?></td>
<?php
//Authorization.
$auth->roleid="4097";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addauctioneers_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4098";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='auctioneers.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
