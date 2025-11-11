<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Bills_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Bills";
//connect to db
$db=new DB();
include"../../../head.php";

$delid=$_GET['delid'];
$bills=new Bills();
if(!empty($delid)){
	$bills->id=$delid;
	$bills->delete($bills);
	redirect("bills.php");
}
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addbills_proc.php', 600, 430);" value="Add Bills" type="button"/></div>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Amount</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="hos_bills.id, hos_bills.name, hos_bills.amount, hos_bills.createdby, hos_bills.createdon, hos_bills.lasteditedby, hos_bills.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$bills->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$bills->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><a href="javascript:;" onclick="showPopWin('addbills_proc.php?id=<?php echo $row->id; ?>', 600, 430);">Edit</a></td>
			<td><a href='bills.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
