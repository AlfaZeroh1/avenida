<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Irrigationmixtures_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Irrigationmixtures";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9214";//Add
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$irrigationmixtures=new Irrigationmixtures();
if(!empty($delid)){
	$irrigationmixtures->id=$delid;
	$irrigationmixtures->delete($irrigationmixtures);
	redirect("irrigationmixtures.php");
}
//Authorization.
$auth->roleid="9213";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addirrigationmixtures_proc.php?irrigationid=<?php echo $ob->irrigationid; ?>',600,430);" value="Add Irrigationmixtures " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Tank </th>
			<th>Water Volume </th>
			<th>EC Level </th>
			<th>PH </th>
			<th>Remarks </th>
			<th>&nbsp;</th>
<?php
//Authorization.
$auth->roleid="9215";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9216";//Add
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
		$fields="prod_irrigationmixtures.id, prod_irrigations.id as irrigationid, prod_irrigationtanks.name as tankid, prod_irrigationmixtures.water, prod_irrigationmixtures.ec, prod_irrigationmixtures.ph, prod_irrigationmixtures.remarks, prod_irrigationmixtures.ipaddress, prod_irrigationmixtures.createdby, prod_irrigationmixtures.createdon, prod_irrigationmixtures.lasteditedby, prod_irrigationmixtures.lasteditedon";
		$join=" left join prod_irrigations on prod_irrigationmixtures.irrigationid=prod_irrigations.id  left join prod_irrigationtanks on prod_irrigationmixtures.tankid=prod_irrigationtanks.id ";
		$having="";
		$groupby="";
		$orderby="";
		if(!empty($ob->irrigationid))
		  $where=" where irrigationid='$ob->irrigationid' ";
		$irrigationmixtures->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$res=$irrigationmixtures->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->tankid; ?></td>
			<td><?php echo formatNumber($row->water); ?></td>
			<td><?php echo formatNumber($row->ec); ?></td>
			<td><?php echo formatNumber($row->ph); ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><a href="../mixturefertilizers/mixturefertilizers.php?mixtureid=<?php echo $row->id; ?>">Fertilizers</td>
<?php
//Authorization.
$auth->roleid="9215";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addirrigationmixtures_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9216";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='irrigationmixtures.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
