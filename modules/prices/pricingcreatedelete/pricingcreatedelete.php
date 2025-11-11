<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Pricingcreatedelete_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Pricingcreatedelete";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8292";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$deactivateid=$_GET['deactivateid'];
$pricingcreatedelete=new Pricingcreatedelete();
if(!empty($deactivateid)){
	$pricingcreatedelete=new Pricingcreatedelete();
	$fields="*";
	$where=" where id='$deactivateid'";
	$having="";
	$groupby="";
	$orderby="";
	$join="";
	$pricingcreatedelete->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$pricingcreatedelete = $pricingcreatedelete->fetchObject;
	$pricingcreatedelete->status="Dropped";
	
	//if(mysql_query("alter table prices_pricings drop $pricingcreatedelete->fieldname ")){
	  $pr = new Pricingcreatedelete();
	  $pr->setObject($pricingcreatedelete);
	  $pr->edit($pr);
	//}
	
	redirect("pricingcreatedelete.php");
}
//Authorization.
$auth->roleid="8291";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addpricingcreatedelete_proc.php',600,430);" value="Add Pricingcreatedelete " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Field Name </th>
			<th>Field Size </th>
			<th>Field Category </th>
			<th>Status </th>
<?php
//Authorization.
$auth->roleid="8294";//View
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
		$fields="prices_pricingcreatedelete.id, prices_pricingcreatedelete.fieldname, prices_pricingcreatedelete.fieldsize, prices_pricingcreatedelete.category, prices_pricingcreatedelete.status, prices_pricingcreatedelete.ipaddress, prices_pricingcreatedelete.createdby, prices_pricingcreatedelete.createdon, prices_pricingcreatedelete.lasteditedby, prices_pricingcreatedelete.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where status='Active'";
		$pricingcreatedelete->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$pricingcreatedelete->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->fieldname; ?></td>
			<td><?php echo $row->fieldsize; ?></td>
			<td><?php echo $row->category; ?></td>
			<td><?php echo $row->status; ?></td>
<?php

//Authorization.
$auth->roleid="8294";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='pricingcreatedelete.php?deactivateid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to deactivate?')">De-activate</a></td>
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
