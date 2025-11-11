<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeeleaves_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../hrm/leavesectiondetails/Leavesectiondetails_class.php");
require_once("../../hrm/leaves/Leaves_class.php");
require_once("../../hrm/leavetypes/Leavetypes_class.php");
require_once("../../hrm/employeeleaveapplications/Employeeleaveapplications_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeeleaves";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4238";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$obj = (object)$_POST;

$delid=$_GET['delid'];
$employeeleaves=new Employeeleaves();
if(!empty($delid)){
	$employeeleaves->id=$delid;
	$employeeleaves->delete($employeeleaves);
	redirect("employeeleaves.php");
}
//Authorization.
$auth->roleid="4237";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addemployeeleaves_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>

<form name="" action="" method="post">
<table>
  <tr>
    <td align="right">Leave:</td>
    <td>
      <select name="leaveid" class="selectbox">
      <option value="">Select...</option>
      <?php
	$leaves=new Leavetypes();
	$where="  ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$leaves->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($leaves->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->leaveid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
      </select></td>&nbsp;
      <td align="right"><strong>Year:</strong></td>
      <td> 
        <select name="year" class="input-small">
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
        </select></td>
        <td>
      <input type="submit" name="action" class="btn btn-info" value="Filter"/>
    </td>
  </tr>
</table>
</form>
<table style="clear:both;"  class="table display" width="100%" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name </th>
			<th>Assignment</th>
			<th>Total Allowable days</th>
			<th>Total Taken Days</th>
			<th>Total days Remaining</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$employees = new Employees();
		$fields=" concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) names ,hrm_employees.id, hrm_assignments.levelid leavesectionid, hrm_assignments.name assignmentid ";
		$join=" left join hrm_assignments on hrm_assignments.id=hrm_employees.assignmentid ";
		$having="";
		$groupby=" ";
		$orderby=" order by names ";
		$where="  ";
		$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employees->result;
		while($row=mysql_fetch_object($res)){
		$i++;
		
		$employeeleaves = new Employeeleaveapplications();
		$fields=" sum(hrm_employeeleaveapplications.duration) duration ";
		$join=" ";
		$having="";
		$groupby=" ";
		$orderby="";
		$where=" where hrm_employeeleaveapplications.employeeid='$row->id' and hrm_employeeleaveapplications.leavetypeid='$obj->leaveid' and hrm_employeeleaveapplications.status='granted' and year(hrm_employeeleaveapplications.startdate)='$obj->year' ";
		$employeeleaves->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$employeeleaves = $employeeleaves->fetchObject;
		
		$leavesectiondetails = new Leavetypes();
		$fields=" * ";
		$join=" ";
		$having="";
		$groupby=" ";
		$orderby="";
		$where=" where id='$obj->leaveid'  ";
		$leavesectiondetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$leavesectiondetails = $leavesectiondetails->fetchObject;
		
		$balance=0;
		$balance=$leavesectiondetails->noofdays-$employeeleaves->duration;
		
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->names; ?></td>
			<td><?php echo $row->assignmentid; ?></td>
			<td><?php echo $leavesectiondetails->noofdays; ?></td>
			<td><?php echo $employeeleaves->duration; ?></td>
			<td><?php echo $balance; ?></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
