<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeeloans_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../hrm/employeepaiddeductions/Employeepaiddeductions_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
// 	$loanid=$_GET['loanid'];
// 	$where=" where loanid='$loanid'";

$page_title="Employeeloans";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1136";//View
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

$obj = (object)$_POST;

if(!empty($ob->loanid))
  $obj->loanid=$ob->loanid;

if(empty($obj->month))
  $obj->month=date("m");
if(empty($obj->year))
  $obj->year=date("Y");
  
auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeeloans=new Employeeloans();
if(!empty($delid)){
	$employeeloans->id=$delid;
	$employeeloans->delete($employeeloans);
	redirect("employeeloans.php");
}
//Authorization.
$auth->roleid="1135";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addemployeeloans_proc.php?loanid=<?php echo $loanid; ?>',600,430);">Add Employeeloans</a>
<?php }?>

<form method="post" action="">
  <table align="center">
    <tr>
      <td><input type="checkbox" name="breakdown" value="yes" <?php if($obj->breakdown=="yes"){echo "checked";}?>/>Breakdown&nbsp;
      <td>Month:<input type="hidden" name="deductionid" value="<?php echo $obj->deductionid; ?>"/> 
    <select name="month" id="month" class="selectbox">
        <option value="">Select...</option>
        <option value="1" <?php if($obj->month==1){echo"selected";}?>>January</option>
        <option value="2" <?php if($obj->month==2){echo"selected";}?>>February</option>
        <option value="3" <?php if($obj->month==3){echo"selected";}?>>March</option>
        <option value="4" <?php if($obj->month==4){echo"selected";}?>>April</option>
        <option value="5" <?php if($obj->month==5){echo"selected";}?>>May</option>
        <option value="6" <?php if($obj->month==6){echo"selected";}?>>June</option>
        <option value="7" <?php if($obj->month==7){echo"selected";}?>>July</option>
        <option value="8" <?php if($obj->month==8){echo"selected";}?>>August</option>
        <option value="9" <?php if($obj->month==9){echo"selected";}?>>September</option>
        <option value="10" <?php if($obj->month==10){echo"selected";}?>>October</option>
        <option value="11" <?php if($obj->month==11){echo"selected";}?>>November</option>
        <option value="12" <?php if($obj->month==12){echo"selected";}?>>December</option>
      </select>
    Year:
    <select name="year" id="year" class="selectbox">
          <option value="">Select...</option>
          <?php
	  $i=date("Y")-10;
	  while($i<date("Y")+10)
	  {
		?>
		  <option value="<?php echo $i; ?>" <?php if($obj->year==$i){echo"selected";}?>><?php echo $i; ?></option>
		  <?
	    $i++;
	  }
	  ?>
        </select>
      &nbsp;<input type="submit" name="action" vaue="Filter"/>
      <input type="hidden" name="loanid" value="<?php echo $obj->loanid; ?>"/>
      </td>
    </tr>
  </table>
</form>

<hr/>
<table style="clear:both;" class="table table-bordered table-condensed table-hover table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Loan </th>
			<th>PF NUM. </th>
			<th>Employee </th>
			<th>Principal </th>
			<th>Method </th>
			<th>Initial Value </th>
			<th>Payable </th>
			<th>Duration </th>
			<th> </th>
			<th>Interest </th>
			<th>Month </th>
			<th>Year </th>
			<?php
			if($obj->breakdown=='yes'){
			$i=1;
			while($i<=$obj->month){
			?>
			  <th><?php echo getMonth($i);?></th>
			  <th>&nbsp;</th>
			<?php
			$i++;
			}
			}
			?>
			<th>&nbsp;</th>
<?php
//Authorization.
$auth->roleid="1137";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1138";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<!--<th>&nbsp;</th>-->
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="hrm_employeeloans.id, hrm_loans.id loan, hrm_loans.name as loanid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hrm_employees.id employee,hrm_employees.pfnum pfnum, hrm_employeeloans.principal, hrm_employeeloans.method, hrm_employeeloans.initialvalue, hrm_employeeloans.payable, hrm_employeeloans.duration, hrm_employeeloans.interesttype, hrm_employeeloans.interest, hrm_employeeloans.month, hrm_employeeloans.year, hrm_employeeloans.createdby, hrm_employeeloans.createdon, hrm_employeeloans.lasteditedby, hrm_employeeloans.lasteditedon, hrm_employeeloans.ipaddress";
		$join=" left join hrm_loans on hrm_employeeloans.loanid=hrm_loans.id  left join hrm_employees on hrm_employeeloans.employeeid=hrm_employees.id ";
		$having="";
		$groupby=" group by hrm_employees.id,hrm_employeeloans.id ";
		$orderby="";
		$where="";
		if(!empty($obj->loanid))
		  $where=" where hrm_employeeloans.loanid='$obj->loanid'";
// 		$where.=" and hrm_employeeloans.principal>0 ";
		$employeeloans->retrieve($fields,$join,$where,$having,$groupby,$orderby); //echo $employeeloans->sql;
		$res=$employeeloans->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->loanid; ?></td>
			<td><?php echo $row->pfnum; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo formatNumber($row->principal); ?></td>
			<td><?php echo $row->method; ?></td>
			<td><?php echo formatNumber($row->initialvalue); ?></td>
			<td><?php echo formatNumber($row->payable); ?></td>
			<td><?php echo formatNumber($row->duration); ?></td>
			<td><?php echo $row->interesttype; ?></td>
			<td><?php echo formatNumber($row->interest); ?></td>
			<td><?php echo $row->month; ?></td>
			<td><?php echo $row->year; ?></td>
			<?php
			if($obj->breakdown=='yes'){
			$x=1;
			$ln=0;
			while($x<=$obj->month){
			
			$employeepaiddeduction = new Employeepaiddeductions();
			$fields="sum(hrm_employeepaiddeductions.amount) amount";
			$join="";
			$having="";
			$groupby=" group by deductionid, month, year, loanid ";
			$orderby="";
			$where=" where hrm_employeepaiddeductions.employeeid='$row->employee' and deductionid in(4,5) and loanid='$obj->loanid' and month='$x' and month>0 and year>0 and year='$obj->year'";
			$employeepaiddeduction->retrieve($fields,$join,$where,$having,$groupby,$orderby);//if($row->employee==100)echo $employeepaiddeduction->sql."<br/>";
			//$employeepaiddeduction=$employeepaiddeduction->fetchObject;
			$num=$employeepaiddeduction->affectedRows;
			while($wr=mysql_fetch_object($employeepaiddeduction->result)){
			
			?>
			  <td align="right"><?php echo formatNumber($wr->amount);?></td>
			<?php
			}
			
			$g=0;
			while($g<(2-$num)){
			  ?>
			  <td align="right"><?php echo formatNumber(0);?></td>
			  <?
			  $g++;
			}
			
			$x++;
			}			
			
			}
			?>
			<td><?php if($row->principal>0){?><a href="javascript:;" onclick="showPopWin('../employeepaiddeductions/addemployeepaiddeductions_proc.php?loanid=<?php echo $row->loan; ?>&employeeloanid=<?php echo $row->id; ?>&employeeid=<?php echo $row->employee; ?>&reducing=No',600,430);">Pay</a><?php }else{ ?> <?php } ?></td>
<?php
//Authorization.
$auth->roleid="1137";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addemployeeloans_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="1138";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<!--<td><a href='employeeloans.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>-->
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<hr>
</div>
<?php
include"../../../foot.php";
?>
