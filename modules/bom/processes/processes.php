<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Processes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Processes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="12615";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$ob = (object)$_GET;
$obj = (object)$_POST;

if(!empty($ob->processedon)){
  $obj->fromdate=$ob->processedon;
  $obj->todate=$ob->processedon;
}

$delid=$_GET['delid'];
$processes=new Processes();
if(!empty($delid)){
	$processes->id=$delid;
	$processes->delete($processes);
	redirect("processes.php");
}
//Authorization.
$auth->roleid="12614";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- <div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addprocesses_proc.php',600,430);" value="NEW" type="button"/></div> -->
<?php }?>

<form action="processes.php" method="post">
  <table class="table">
    <tr>
      <td align="right">From Date:</td>
      <td><input type="text" readonly name="fromdate" id="fromdate" value="<?php echo $obj->fromdate; ?>"/></td>
      <td align="right">To Date:</td>
      <td><input type="text" readonly name="todate" id="todate" value="<?php echo $obj->todate; ?>"/></td>
      <td><input type="submit" class="btn btn-primary" name="action" value="Filter"/>
    </tr>
  </table>
</form>

<table style="clear:both;"  class="table display" width="100%" id="" >
	<thead>
		<tr>
			<th>#</th>
			<th>Estimation </th>
			<th>Processed On </th>
			<th>Expected </th>
			<th>Actual </th>
			<th>Variance</th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="12616";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="12617";//Add
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
		$fields="bom_processes.id, inv_items.name as estimationid, bom_processes.processedon, bom_processes.quantity, bom_processes.actual, bom_processes.remarks, bom_processes.ipaddress, bom_processes.createdby, bom_processes.createdon, bom_processes.lasteditedby, bom_processes.lasteditedon";
		$join=" left join bom_estimations on bom_processes.estimationid=bom_estimations.id left join inv_items on inv_items.id=bom_estimations.itemid ";
		$having="";
		$groupby="";
		$orderby=" order by bom_processes.id desc ";
		$where=" where bom_processes.processedon>='$obj->fromdate' and bom_processes.processedon<='$obj->todate' ";
		$processes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$processes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
		
		$variance=$row->quantity-$row->actual;
		$color="";
		
		if($variance>0 and $row->actual>0)
		  $color="red";
		if($variance<=0)
		  $color="green";
	?>
		<tr style="color:<?php echo $color; ?>">
			<td><?php echo $i; ?></td>
			<td><?php echo $row->estimationid; ?></td>
			<td><?php echo formatDate($row->processedon); ?></td>
			<td><?php echo ($row->quantity); ?></td>
			<td><?php echo ($row->actual); ?></td>
			<td><?php echo ($variance); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="12616";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addprocesses_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="12617";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='processes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
