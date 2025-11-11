<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Config_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Config";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9258";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$config=new Config();
if(!empty($delid)){
	$config->id=$delid;
	$config->delete($config);
	redirect("config.php");
}
//Authorization.
$auth->roleid="9257";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>

<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name </th>
			<th>Value </th>
<?php
//Authorization.
$auth->roleid="9259";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9260";//Add
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
		$fields="pos_config.id, pos_config.name, pos_config.value";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$config->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$config->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->value; ?></td>
<?php
//Authorization.
$auth->roleid="9259";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addconfig_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9260";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='config.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"></a></td>
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
