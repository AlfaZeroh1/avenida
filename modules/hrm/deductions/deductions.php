<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Deductions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Deductions";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1108";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$obj = (object)$_POST;


if($obj->action=="Employee Deductions"){
  
  $ids="";
  $deductions = new Deductions();
  $fields="*";
  $join=" ";
  $having="";
  $groupby="";
  $orderby="";
  $where="";
  $deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  while($row=mysql_fetch_object($deductions->result)){
    if(isset($_POST[$row->id]))
      $ids.=$row->id.",";
  }
  
  $ids=substr($ids,0,-1);
  
      redirect("../employeedeductions/employeededuction.php?ids=".$ids);

  
}



$delid=$_GET['delid'];
$deductions=new Deductions();
if(!empty($delid)){
	$deductions->id=$delid;
	$deductions->delete($deductions);
	redirect("deductions.php");
}
//Authorization.
$auth->roleid="1107";//View
$auth->levelid=$_SESSION['level'];
$arr=array(1,2,3,4,5,7);

if(existsRule($auth)){
?>
<hr>
<a class="btn btn-info" onclick="showPopWin('adddeductions_proc.php',600,430);">Add Deductions</a>
<?php }?>
<hr>
<div style="clear:both;"></div>
<form method="POST">
<table style="clear:both;" class="tgridd display" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>&nbsp;</th>
			<th>Deduction </th>
			<th>Month </th>
			<th>Year </th>
			<th>Deduction Type</th>
			<th>Amount </th>
			<th>Relief</th>
			<th>Taxable</th>
			<th>Applies To </th>
			<th>Liability Acct </th>
			<th>Status </th>
<?php
//Authorization.
$auth->roleid="1109";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1110";//View
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
		$fields="hrm_deductions.id, hrm_deductions.name, hrm_deductions.taxable, hrm_deductions.relief, hrm_deductiontypes.name deductiontype,  hrm_deductiontypes.name as deductiontypeid, hrm_deductions.frommonth, hrm_deductions.fromyear, hrm_deductions.tomonth, hrm_deductions.toyear, hrm_deductions.amount, hrm_deductions.overall, hrm_deductions.status, fn_liabilitys.name liabilityid, hrm_deductions.createdby, hrm_deductions.createdon, hrm_deductions.lasteditedby, hrm_deductions.lasteditedon";
		$join=" left join hrm_deductiontypes on hrm_deductions.deductiontypeid=hrm_deductiontypes.id left join fn_liabilitys on fn_liabilitys.id=hrm_deductions.liabilityid ";
		$having="";
		$groupby="";
		$orderby="";
		$deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$res=$deductions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><input type="checkbox" name="<? echo $row->id; ?>" id="<? echo $row->id; ?>" value="<? echo $row->id; ?>"/></td>
			<td><a href='../../hrm/employeedeductions/employeedeductions.php?deductionid=<?php echo $row->id; ?>'><?php echo $row->name; ?></a></td>
<!-- 			<td><?php echo $row->name; ?></td> -->
			<td><?php echo getMonth($row->frommonth); ?>&nbsp;<?php echo $row->fromyear; ?></td>
			<td><?php echo getMonth($row->tomonth); ?>&nbsp;<?php echo $row->toyear; ?></td>
			<td><?php echo $row->deductiontype; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->relief; ?></td>
			<td><?php echo $row->taxable; ?></td>
			<td><?php echo $row->overall; ?></td>
			<td><?php echo $row->liabilityid; ?></td>
			<td><?php echo $row->status; ?></td>
<?php
//Authorization.
$auth->roleid="1109";//View
$auth->levelid=$_SESSION['level'];


if(existsRule($auth)){
// if(!in_array($row->id,$arr)){
?>
			<td><a href="javascript:;" onclick="showPopWin('adddeductions_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>

<?php if($row->deductiontype==2 and $row->overall=='All'){?>
			<td>&nbsp;</td>
			<?php }else{?>
			<td><a href='../../hrm/employeedeductions/employeededuction.php?deductionid=<?php echo $row->id; ?>'>New</a></td>
			<?php }?>
			<td><a href='../../hrm/employeepaiddeductions/employeepaiddeductions.php?deductionid=<?php echo $row->id; ?>'>Stattmt</a></td>
<?php
}
//Authorization.
$auth->roleid="1110";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
if(!in_array($row->id,$arr)){
?>
			<td><a href='deductions.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
			
<?php }else{
?>
  <td>&nbsp;</td>

<?php
}
?>
<?php
}?>
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
<hr>
</div>
<?php
include"../../../foot.php";
?>
