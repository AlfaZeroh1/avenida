<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Categorysizes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Categorysizes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8817";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$categorysizes=new Categorysizes();
if(!empty($delid)){
	$categorysizes->id=$delid;
	$categorysizes->delete($categorysizes);
	redirect("categorysizes.php");
}
//Authorization.
$auth->roleid="8816";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addcategorysizes_proc.php',600,430);" value="Add Categorysizes " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Category </th>
			<th>Size </th>
			<th>Price </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8818";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8819";//Add
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
		$fields="pos_categorysizes.id, pos_categorys.name as categoryid, pos_sizes.name as sizeid, pos_categorysizes.price, pos_categorysizes.remarks, pos_categorysizes.ipaddress, pos_categorysizes.createdby, pos_categorysizes.createdon, pos_categorysizes.lasteditedby, pos_categorysizes.lasteditedon";
		$join=" left join pos_categorys on pos_categorysizes.categoryid=pos_categorys.id  left join pos_sizes on pos_categorysizes.sizeid=pos_sizes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$categorysizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$categorysizes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->categoryid; ?></td>
			<td><?php echo $row->sizeid; ?></td>
			<td><?php echo formatNumber($row->price); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8818";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcategorysizes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8819";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='categorysizes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
