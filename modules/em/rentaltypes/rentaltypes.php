<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Rentaltypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Rentaltypes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4152";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$rentaltypes=new Rentaltypes();
if(!empty($delid)){
	$rentaltypes->id=$delid;
	$rentaltypes->delete($rentaltypes);
	redirect("rentaltypes.php");
}
//Authorization.
$auth->roleid="4151";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons">
<a class="button icon chat" onclick="showPopWin('addrentaltypes_proc.php',540,220);" ><span>ADD RENTAL TYPES</span></a>
</div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Rental Type </th>
			<th>Payable After (Months) </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4153";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4154";//<img src="../view.png" alt="view" title="view" />
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
		$fields="em_rentaltypes.id, em_rentaltypes.name, em_rentaltypes.months, em_rentaltypes.remarks";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$rentaltypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$rentaltypes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->months; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4153";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addrentaltypes_proc.php?id=<?php echo $row->id; ?>',540,220);"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="4154";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='rentaltypes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
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
