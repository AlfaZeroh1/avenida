<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Surchages_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Surchages";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1194";//View
$auth->levelid=$_SESSION['level'];

$obj = (object)$_POST;

auth($auth);
include"../../../head.php";

if($obj->action=="Employee Deductions"){
  
  $ids="";
  $surchages = new Surchages();
  $fields="*";
  $join=" ";
  $having="";
  $groupby="";
  $orderby="";
  $where="";
  $surchages->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  while($row=mysql_fetch_object($surchages->result)){
    if(isset($_POST[$row->id]))
      $ids.=$row->id.",";
  }
  
  $ids=substr($ids,0,-1);
  
      redirect("../employeesurchages/employeesurchage.php?ids=".$ids);

  
}

$delid=$_GET['delid'];
$surchages=new Surchages();
if(!empty($delid)){
	$surchages->id=$delid;
	$surchages->delete($surchages);
	redirect("surchages.php");
}
//Authorization.
$auth->roleid="1193";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addsurchages_proc.php',600,430);" value="Add Surchages " type="button"/></div>
<?php }?>
<form method="POST">
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>&nbsp;</th>
			<th>Name </th>
			<th>Amount </th>
			<th>Remarks </th>
			<th>Surchage Type </th>
			<th>From</th>
			<th>To</th>
			<th>Taxable</th>
			<th>Overall </th>
			<th> </th>
<?php
//Authorization.
$auth->roleid="1195";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1196";//View
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
		$fields="hrm_surchages.id, hrm_surchages.name, hrm_surchages.amount, hrm_surchages.remarks, hrm_surchages.surchagetypeid, hrm_surchages.frommonth, hrm_surchages.fromyear, hrm_surchages.tomonth, hrm_surchages.toyear, hrm_surchages.overall, hrm_surchages.status, hrm_surchages.taxable, hrm_surchages.createdby, hrm_surchages.createdon, hrm_surchages.lasteditedby, hrm_surchages.lasteditedon, hrm_surchages.ipaddress";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$surchages->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$surchages->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><input type="checkbox" name="<? echo $row->id; ?>" id="<? echo $row->id; ?>" value="<? echo $row->id; ?>"/></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->surchagetypeid; ?></td>
			<td><?php echo getMonth($row->frommonth); ?>&nbsp;<?php echo $row->fromyear; ?></td>
			<td><?php echo getMonth($row->tomonth); ?>&nbsp;<?php echo $row->toyear; ?></td>
			<td><?php echo $row->taxable; ?></td>
			<td><?php echo $row->overall; ?></td>
			<td><?php echo $row->status; ?></td>
<?php
//Authorization.
$auth->roleid="1195";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addsurchages_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="1196";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='surchages.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<hr>
<input type="submit" name="action" id="action" value="Employee Deductions" />
<hr>
</form>
<?php
include"../../../foot.php";
?>
