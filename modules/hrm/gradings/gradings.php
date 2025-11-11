<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Gradings_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Gradings";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4322";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$gradings=new Gradings();
if(!empty($delid)){
	$gradings->id=$delid;
	$gradings->delete($gradings);
	redirect("gradings.php");
}
//Authorization.
$auth->roleid="4321";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">

<a class="btn btn-info" onclick="showPopWin('addgradings_proc.php',540,210);">ADD GRADINGS</a>
<?php }?>

<table style="clear:both;"  class="table table-bordered table-condensed table-hover table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Grade </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4323";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4324";//Add
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
		$fields="hrm_gradings.id, hrm_gradings.name, hrm_gradings.remarks";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$gradings->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$res=$gradings->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4323";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addgradings_proc.php?id=<?php echo $row->id; ?>',540,210);"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="4324";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='gradings.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>

</div>
<?php
include"../../../foot.php";
?>
