<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Overtimes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Overtimes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9393";//Add
$auth->levelid=$_SESSION['level'];

$obj = (object)$_POST;

if($obj->action=="Employee Overtimes"){
  
  $ids="";
  $overtimes = new Overtimes();
  $fields="*";
  $join=" ";
  $having="";
  $groupby="";
  $orderby="";
  $where="";
  $overtimes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  while($row=mysql_fetch_object($overtimes->result)){
    if(isset($_POST[$row->id]))
      $ids.=$row->id.",";
  }
  
  $ids=substr($ids,0,-1);
  
      redirect("../employeeovertimes/employeeovertime.php?ids=".$ids);

  
}

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$overtimes=new Overtimes();
if(!empty($delid)){
	$overtimes->id=$delid;
	$overtimes->delete($overtimes);
	redirect("overtimes.php");
}
//Authorization.
$auth->roleid="9392";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addovertimes_proc.php',600,430);" value="Add Overtimes " type="button"/></div>
<?php }?>
<form action="" method="post">
<input type="submit" name="action" value="Employee Overtimes"/>

<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>&nbsp;</th>
			<th>Overtime </th>
			<th>Value </th>
			<th>Hrs </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9394";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9395";//Add
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
		$fields="hrm_overtimes.id, hrm_overtimes.name, hrm_overtimes.value, hrm_overtimes.hrs, hrm_overtimes.remarks, hrm_overtimes.ipaddress, hrm_overtimes.createdby, hrm_overtimes.createdon, hrm_overtimes.lasteditedby, hrm_overtimes.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$overtimes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$overtimes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><input type="checkbox" value="<? echo "$row->id"; ?>" name="<? echo "$row->id"; ?>" /></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo formatNumber($row->value); ?></td>
			<td><?php echo formatNumber($row->hrs); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9394";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addovertimes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9395";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='overtimes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
</form>
<?php
include"../../../foot.php";
?>
