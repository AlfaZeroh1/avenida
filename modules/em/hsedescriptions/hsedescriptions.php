<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Hsedescriptions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Hsedescriptions";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4124";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$hsedescriptions=new Hsedescriptions();
if(!empty($delid)){
	$hsedescriptions->id=$delid;
	$hsedescriptions->delete($hsedescriptions);
	redirect("hsedescriptions.php");
}
//Authorization.
$auth->roleid="4123";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons">
<a class="button icon chat" onclick="showPopWin('addhsedescriptions_proc.php', 540, 180);"><span>ADD HSE DESCRIPTIONS</span></a>
</div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Description </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4125";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4126";//<img src="../view.png" alt="view" title="view" />
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
		$fields="em_hsedescriptions.id, em_hsedescriptions.name, em_hsedescriptions.remarks";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$hsedescriptions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$hsedescriptions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4125";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addhsedescriptions_proc.php?id=<?php echo $row->id; ?>', 540, 180);"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="4126";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='hsedescriptions.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
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
