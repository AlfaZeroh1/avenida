<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Cards_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Cards";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4738";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$cards=new Cards();
if(!empty($delid)){
	$cards->id=$delid;
	$cards->delete($cards);
	redirect("cards.php");
}
//Authorization.
$auth->roleid="4737";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addcards_proc.php',600,430);" value="Add Cards " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Card No. </th>
			<th>Card Type </th>
			<th>Remarks </th>
			<th> </th>
<?php
//Authorization.
$auth->roleid="4739";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4740";//View
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
		$fields="inv_cards.id, inv_cards.cardno, inv_cardtypes.name as cardtypeid, inv_cards.remarks, inv_cards.createdby, inv_cards.createdon, inv_cards.lasteditedby, inv_cards.lasteditedon, inv_cards.ipaddress";
		$join=" left join inv_cardtypes on inv_cards.cardtypeid=inv_cardtypes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$cards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$cards->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->cardno; ?></td>
			<td><?php echo $row->cardtypeid; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->ipaddress; ?></td>
<?php
//Authorization.
$auth->roleid="4739";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcards_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4740";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='cards.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
