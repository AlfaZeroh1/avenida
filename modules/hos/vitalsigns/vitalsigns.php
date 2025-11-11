<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Vitalsigns_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Vital Signs";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4364";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$vitalsigns=new Vitalsigns();
if(!empty($delid)){
	$vitalsigns->id=$delid;
	$vitalsigns->delete($vitalsigns);
	redirect("vitalsigns.php");
}
//Authorization.
$auth->roleid="4363";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons">
<a class="button icon chat" onclick="showPopWin('addvitalsigns_proc.php',600,250);">ADD VITAL SIGNS</a>

 </div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th width="5%">#</th>
			<th width="15%">Vital Sign </th>
			<th width="25%">Remarks </th>
<?php
//Authorization.
$auth->roleid="4365";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th width="5%">&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4366";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th width="5%">&nbsp;</th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="hos_vitalsigns.id, hos_vitalsigns.name, hos_vitalsigns.remarks";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		$vitalsigns->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$vitalsigns->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4365";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addvitalsigns_proc.php?id=<?php echo $row->id; ?>',600,250);"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="4366";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='vitalsigns.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
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
