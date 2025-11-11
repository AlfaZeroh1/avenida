<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Housebreakages_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Housebreakages";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4218";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$housebreakages=new Housebreakages();
if(!empty($delid)){
	$housebreakages->id=$delid;
	$housebreakages->delete($housebreakages);
	redirect("housebreakages.php");
}
//Authorization.
$auth->roleid="4217";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons">
<a class="button icon chat" onclick="showPopWin('addhousebreakages_proc.php',600,430);"><span>ADD HOUSE BREAKAGES</span></a>
</div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>House </th>
			<th>Tenant </th>
			<th>Breakage </th>
			<th>Already Fixed? </th>
			<th>Cost </th>
			<th>Paid By Tenant </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4219";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4220";//<img src="../view.png" alt="view" title="view" />
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
		$fields="em_housebreakages.id, em_houses.name as houseid, em_tenants.name as tenantid, em_housebreakages.breakage, em_housebreakages.fixed, em_housebreakages.cost, em_housebreakages.paidbytenant, em_housebreakages.remarks";
		$join=" left join em_houses on em_housebreakages.houseid=em_houses.id  left join em_tenants on em_housebreakages.tenantid=em_tenants.id ";
		$having="";
		$groupby="";
		$orderby="";
		$housebreakages->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$housebreakages->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->houseid; ?></td>
			<td><?php echo $row->tenantid; ?></td>
			<td><?php echo $row->breakage; ?></td>
			<td><?php echo $row->fixed; ?></td>
			<td><?php echo formatNumber($row->cost); ?></td>
			<td><?php echo $row->paidbytenant; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4219";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addhousebreakages_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="4220";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='housebreakages.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
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
