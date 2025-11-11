<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Nationalitys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Nationalitys";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4206";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$nationalitys=new Nationalitys();
if(!empty($delid)){
	$nationalitys->id=$delid;
	$nationalitys->delete($nationalitys);
	redirect("nationalitys.php");
}
//Authorization.
$auth->roleid="4205";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons">
<a class="button icon chat" onclick="showPopWin('addnationalitys_proc.php',500,180);"><span>ADD NATIONILITYS</span></a>
</div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Nationality </th>
<?php
//Authorization.
$auth->roleid="4207";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4208";//View
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
		$fields="hrm_nationalitys.id, hrm_nationalitys.name";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$nationalitys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$nationalitys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
<?php
//Authorization.
$auth->roleid="4207";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addnationalitys_proc.php?id=<?php echo $row->id; ?>',500,180);"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="4208";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='nationalitys.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
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
