<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Allowances_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../hrm/overtimes/Overtimes_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Allowances";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1100";//View
$auth->levelid=$_SESSION['level'];

$obj = (object)$_POST;


if($obj->action=="Employee Allowances"){
  
  $ids="";
  $allowances = new Allowances();
  $fields="*";
  $join=" ";
  $having="";
  $groupby="";
  $orderby="";
  $where="";
  $allowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  while($row=mysql_fetch_object($allowances->result)){
    if(isset($_POST[$row->id]))
      $ids.=$row->id.",";
  }
  
  $ids=substr($ids,0,-1);
  
      redirect("../employeeallowances/employeeallowance.php?ids=".$ids);

  
}


auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$allowances=new Allowances();
if(!empty($delid)){
	$allowances->id=$delid;
	$allowances->delete($allowances);
	redirect("allowances.php");
}
//Authorization.
$auth->roleid="1099";//View
$auth->levelid=$_SESSION['level'];
$arr=array(1,2,3,4,5,7);

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addallowances_proc.php',600,430);" value="Add Allowances " type="button"/></div>
<?php }?>
<form method="POST">
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>&nbsp;</th>
			<th>Allowance </th>
			<th>Allowance Type </th>
			<th>Expense Account </th>
			<th>Overall </th>
			<th>From </th>
			<th>To </th>
			<th>Taxable </th>
			<th>Status </th>
			<th>Non-Cash Benefit </th>
<?php
//Authorization.
$auth->roleid="1101";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1102";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<!-- 						<th>&nbsp;</th> -->

<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="hrm_allowances.id, hrm_allowances.name,hrm_allowances.allowancetypeid as allowancetype, hrm_allowances.amount, hrm_allowances.percentaxable, hrm_allowancetypes.name as allowancetypeid, fn_expenses.name as expenseid, hrm_allowances.overall, hrm_allowances.frommonth, hrm_allowances.fromyear, hrm_allowances.tomonth, hrm_allowances.toyear, hrm_allowances.status, hrm_allowances.noncashbenefit, hrm_allowances.createdby, hrm_allowances.createdon, hrm_allowances.lasteditedby, hrm_allowances.lasteditedon, hrm_allowances.ipaddress";
		$join=" left join hrm_allowancetypes on hrm_allowances.allowancetypeid=hrm_allowancetypes.id  left join fn_expenses on hrm_allowances.expenseid=fn_expenses.id ";
		$having="";
		$groupby="";
		$orderby="";
		$allowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$allowances->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><input type="checkbox" value="<? echo "$row->id"; ?>" name="<? echo "$row->id"; ?>" /></td>
			<?php
			if($row->id==3){
			  $overtimes = new Overtimes();
			  $fields=" group_concat(id) ids ";
			  $join=" ";
			  $where=" ";
			  $having="";
			  $groupby="";
			  $orderby="";
			  $overtimes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			  $overtimes = $overtimes->fetchObject;
			  
			  $obj->month=date('m');
			  $obj->year=date('Y');
			  $obj->fromdate=date('Y-m-d', mktime(0, 0, 0, date("m"), 1, date("Y")));
			  $obj->todate=date('Y-m-d', mktime(0, 0, 0, date("m"), date("t"), date("Y")));
			  ?>
			<td><a href='../../hrm/employeeovertimes/employeeovertime.php?ids=<?php echo $overtimes->ids; ?>&month=<?php echo $obj->month; ?>&year=<?php echo $obj->year; ?>&fromdate=<?php echo $obj->fromdate; ?>&todate=<?php echo $obj->todate; ?>&action=Filter'><?php echo $row->name; ?></a></td>
			<?php
			}else{
			?>
			<td><a href='../../hrm/employeeallowances/employeeallowances.php?allowanceid=<?php echo $row->id; ?>'><?php echo $row->name; ?></a></td>
			<?php
			}
			?>
			<td><?php echo $row->allowancetypeid; ?></td>
			<td><?php echo $row->expenseid; ?></td>
			<td><?php echo $row->overall; ?></td>
			<td><?php echo $row->frommonth; ?>&nbsp;<?php echo $row->fromyear; ?></td>
			<td><?php echo $row->tomonth; ?>&nbsp;<?php echo $row->toyear; ?></td>
			<td><?php echo $row->percentaxable; ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo $row->noncashbenefit; ?></td>
<?php
//Authorization.
$auth->roleid="1101";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
// if(!in_array($row->id,$arr)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addallowances_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>

<?php if($row->allowancetype==2 and $row->overall=='All'){?>
			<td>&nbsp;</td>
			<?php }else{?>
			<td><a href='../../hrm/employeeallowances/employeeallowance.php?allowanceid=<?php echo $row->id; ?>'>New</a></td>
			<?php }?>
			<td><a href='../../hrm/employeepaidallowances/employeepaidallowances.php?allowanceid=<?php echo $row->id; ?>'>Stattmt</a></td>
<?php
}
//Authorization.
$auth->roleid="1102";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
if(!in_array($row->id,$arr)){
?>
			<td><a href='allowances.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
<input type="submit" value="Employee Allowances" name="action" id="action" />

<hr>
</form>
<?php
include"../../../foot.php";
?>
