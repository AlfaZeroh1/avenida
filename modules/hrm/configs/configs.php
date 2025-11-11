<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Configs_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../fn/expenses/Expenses_class.php");
require_once("../../fn/liabilitys/Liabilitys_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Configs";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9435";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$configs=new Configs();
if(!empty($delid)){
	$configs->id=$delid;
	$configs->delete($configs);
	redirect("configs.php");
}
//Authorization.
$auth->roleid="9434";//View
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
$auth->roleid="9436";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9437";//View
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
		$fields="hrm_configs.id, hrm_configs.name, hrm_configs.value";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$configs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$configs->result;
		while($row=mysql_fetch_object($res)){
		$i++;
		if($row->id==4){
		  $expenses = new Expenses();
		  $where=" where id='$row->value' ";
		  $fields="*";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $expenses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  $expenses = $expenses->fetchObject;
		  $row->value=$expenses->name;
		}else if($row->id==3){
		  $liabilitys = new Liabilitys();
		  $where=" where id='$row->value' ";
		  $fields="*";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $liabilitys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  $liabilitys = $liabilitys->fetchObject;
		  $row->value=$liabilitys->name;
		}
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->value; ?></td>
<?php
//Authorization.
$auth->roleid="9436";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addconfigs_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9437";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<td>&nbsp;</td>
<!-- 			<td><a href='configs.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td> -->
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
