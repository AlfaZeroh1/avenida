<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Houserents_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Houserents";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4104";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$houserents=new Houserents();
if(!empty($delid)){
	$houserents->id=$delid;
	$houserents->delete($houserents);
	redirect("houserents.php");
}
//Authorization.
$auth->roleid="4103";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons">
<a class="button icon chat" onclick="showPopWin('addhouserents_proc.php', 600, 280);"><span>ADD HOUSE RENTS</span></a>
</div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>House </th>
			<th>Previous Rent </th>
			<th>End Date </th>
			<th>Current Rent </th>
<?php
//Authorization.
$auth->roleid="4105";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4106";//<img src="../view.png" alt="view" title="view" />
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
		$fields="em_houserents.id, em_houses.name as houseid, em_houserents.previous, em_houserents.enddate, em_houserents.current";
		$join=" left join em_houses on em_houserents.houseid=em_houses.id ";
		$having="";
		$groupby="";
		$orderby="";
		$houserents->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$houserents->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->houseid; ?></td>
			<td><?php echo formatNumber($row->previous); ?></td>
			<td><?php echo formatDate($row->enddate); ?></td>
			<td><?php echo formatNumber($row->current); ?></td>
<?php
//Authorization.
$auth->roleid="4105";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addhouserents_proc.php?id=<?php echo $row->id; ?>', 600, 280);"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="4106";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='houserents.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
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
