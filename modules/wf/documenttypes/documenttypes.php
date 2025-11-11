<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Documenttypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Documenttypes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7471";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../hd.php";

$delid=$_GET['delid'];
$documenttypes=new Documenttypes();
if(!empty($delid)){
	$documenttypes->id=$delid;
	$documenttypes->delete($documenttypes);
	redirect("documenttypes.php");
}
//Authorization.
$auth->roleid="7470";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('adddocumenttypes_proc.php',600,430);" value="Add Documenttypes " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
<?php
//Authorization.
$auth->roleid="7472";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7473";//View
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
		$fields="";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$documenttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$documenttypes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
<?php
//Authorization.
$auth->roleid="7472";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('adddocumenttypes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7473";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='documenttypes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
