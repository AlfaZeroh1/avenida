<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Stocktakes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$ob = (object)$_GET;

$page_title="Stocktakes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="11153";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$stocktakes=new Stocktakes();
if(!empty($delid)){
	$stocktakes->id=$delid;
	$stocktakes->delete($stocktakes);
	redirect("stocktakes.php");
}
//Authorization.
$auth->roleid="11152";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a class="btn btn-info" href="addstocktakes_proc.php">NEW</a></div>
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Stock Take No </th>
			<th>Opened On </th>
			<th>Closed On </th>
			<th>Remarks </th>
			<th>Status </th>
<?php
//Authorization.
$auth->roleid="11154";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="11155";//Add
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
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		if(!empty($ob->categoryid)){
		  $where.=" where inv_items.categoryid='$ob->categoryid' ";
		}
		$stocktakes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$stocktakes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><a href="stocktake.php?documentno=<?php echo $row->documentno; ?>"><?php echo $row->documentno; ?></a></td>
			<td><?php echo formatDate($row->openedon); ?></td>
			<td><?php echo formatDate($row->closedon); ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->status; ?></td>
<?php
//Authorization.
$auth->roleid="11154";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addstocktakes_proc.php?id=<?php echo $row->id; ?>"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="11155";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='stocktakes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
