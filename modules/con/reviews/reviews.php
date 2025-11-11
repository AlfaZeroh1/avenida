<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Reviews_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Reviews";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8536";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$reviews=new Reviews();
if(!empty($delid)){
	$reviews->id=$delid;
	$reviews->delete($reviews);
	redirect("reviews.php");
}
//Authorization.
$auth->roleid="8535";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addreviews_proc.php',600,430);">Add Reviews</a>
<?php }?>
<hr>
<table style="clear:both;"  class="table table-codensed table-stripped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Review Item </th>
<?php
//Authorization.
$auth->roleid="8537";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8538";//Add
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
		$fields="con_reviews.id, con_reviews.name, con_reviews.ipaddress, con_reviews.createdby, con_reviews.createdon, con_reviews.lasteditedby, con_reviews.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$reviews->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$reviews->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
<?php
//Authorization.
$auth->roleid="8537";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addreviews_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8538";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='reviews.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
