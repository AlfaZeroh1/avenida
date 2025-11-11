<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Expensecategorys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Expensecategorys";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="2149";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$expensecategorys=new Expensecategorys();
if(!empty($delid)){
	$expensecategorys->id=$delid;
	$expensecategorys->delete($expensecategorys);
	redirect("expensecategorys.php");
}
//Authorization.
$auth->roleid="2148";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons">
<a class="button icon chat" onclick="showPopWin('addexpensecategorys_proc.php', 540, 200);"><span>ADD EXPENSE CATEGORIES</span></a>
</div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Expense Category </th>
			<th>Expense Type</th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="2150";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="2151";//<img src="../view.png" alt="view" title="view" />
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
		$fields="fn_expensecategorys.id, fn_expensecategorys.name, fn_expensecategorys.remarks, fn_expensetypes.name expensetypeid ";
		$join=" left join fn_expensetypes on fn_expensetypes.id=fn_expensecategorys.expensetypeid ";
		$where="";
		if(!empty($ob->id)){
		  $where.=" where fn_expensecategorys.expensetypeid='$ob->id' ";
		}
		$having="";
		$groupby="";
		$orderby="";
		$expensecategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$expensecategorys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><a href="../expenses/expenses.php?expensecategoryid=<?php echo $row->id; ?>"><?php echo $row->name; ?></a></td>
			<td><?php echo $row->expensetypeid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="2150";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addexpensecategorys_proc.php?id=<?php echo $row->id; ?>', 540, 200);"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="2151";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='expensecategorys.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
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
