<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Reliefs_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Reliefs";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1182";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$reliefs=new Reliefs();
if(!empty($delid)){
	$reliefs->id=$delid;
	$reliefs->delete($reliefs);
	redirect("reliefs.php");
}
//Authorization.
$auth->roleid="1181";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addreliefs_proc.php',500,240);">ADD RELIEFS</a>
<?php }?>
<hr>
<table style="clear:both;" class="table table-bordered table-condensed table-hover table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name </th>
			<th>Amount </th>
			<th>Overall </th>
<?php
//Authorization.
$auth->roleid="1183";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1184";//View
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
		$fields="hrm_reliefs.id, hrm_reliefs.name, hrm_reliefs.amount, hrm_reliefs.overall, hrm_reliefs.createdby, hrm_reliefs.createdon, hrm_reliefs.lasteditedby, hrm_reliefs.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$reliefs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$reliefs->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<?php if($row->overall=="Yes"){?>
			<td><?php echo $row->name; ?></td>
			<?php }else{?>
			<td><a href="../employeereliefs/employeereliefs.php?reliefid=<?php echo $row->id ?>"><?php echo $row->name; ?></a></td>
			<?php }?>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->overall; ?></td>
<?php
//Authorization.
$auth->roleid="1183";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addreliefs_proc.php?id=<?php echo $row->id; ?>',500,240);"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="1184";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='reliefs.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<hr>
</div>
<?php
include"../../../foot.php";
?>
