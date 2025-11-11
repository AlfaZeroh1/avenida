<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patientappointments_class.php");
require_once '../../hos/payables/Payables_class.php';
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
$auth->roleid="1279";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);

$st=$_GET['st'];
if($st==1)
  $page_title="Observations";
elseif($st==2)
  $page_title="Waiting List";
elseif($st==1)
  $page_title="Treatment List";
else
  $page_title="Appointments";
//connect to db
$db=new DB();
include"../../../head.php";

$delid=$_GET['delid'];

$obj=(object)$_POST;

if(!empty($obj->action)){
	$obj->st=$obj->status;
}
if(!empty($st))
	$obj->st=$st;

if(!empty($status))
	$obj->status=$status;
if(empty($obj->action)){
	$obj->date=date("Y-m-d");
	$obj->todate=date("Y-m-d");
}

$patientappointments=new Patientappointments();
if(!empty($delid)){
	$patientappointments->id=$delid;
	$patientappointments->delete($patientappointments);
	redirect("patientappointments.php");
}
?>
<?php if(empty($st)){ ?>
<div style="float:left;" class="buttons">

<a class="button icon chat"  onclick="showPopWin('addpatientappointments_proc.php',600,430);">Add Patientappointments</a></div>
<?php } ?>
<form action="patientappointments.php" method="post">
	<table>
		<tr>
			<td>
				From Date: <input type="text" size="12" readonly="readonly" class="date_input" name="date" value="<?php echo $obj->date; ?>"/>
				To Date: <input type="text" size="12" readonly="readonly" class="date_input" name="todate" value="<?php echo $obj->todate; ?>"/>
			</td>
			<td>Status: <input type="hidden" name="st" value="<?php echo $obj->st; ?>"/>
			<select name="status" class="selectbox">
				<option value="1" <?php if($obj->status==1){echo"selected";}?>>Queued for Observation</option>
				<option value="2" <?php if($obj->status==2){echo"selected";}?>>Already observed & in doctor's waiting list</option>
				<option value="3" <?php if($obj->status==3){echo"selected";}?>>Seen by Doctor</option>
			</select>&nbsp;<input type="submit" class="btn" name="action" value="Filter"/>
		</tr>
	</table>
</form>

<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >

	<thead>
		<tr>
			<th width="5%">#</th>
			<th width="10%">Patient Name</th>
			<th width="15%">Age</th>
			<th width="15%">Gender</th>
			<th width="15%">Client</th>
			<th width="10%">Appointment Date</th>
			<th width="10%">Booked On</th>
			<th width="20%">Remarks</th>
			<th width="5%">&nbsp;</th>
			<th width="5%">&nbsp;</th>
			<th width="5%">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php		
		$i=0;
		$fields="hos_patientappointments.id, hos_patientappointments.payconsultancy, hos_patientappointments.id, hos_patients.id patient, concat(hos_patients.surname,' ', hos_patients.othernames) as patientid, hos_patientappointments.appointmentdate, hos_patientappointments.bookedon, hos_patientappointments.remarks, hos_patientappointments.createdby,hos_patientclasses.name as patientclasseid, sys_genders.name as genderid,hos_patients.dob, hos_patientappointments.createdon";
		$join=" left join hos_patients on hos_patientappointments.patientid=hos_patients.id  left join hos_patientclasses on hos_patientclasses.id=hos_patients.patientclasseid left join sys_genders on sys_genders.id=hos_patients.genderid";
		$having="";
		$groupby="";
		$where=" ";
		$orderby=" order by hos_patientappointments.id desc ";
		if(!empty($obj->status))
			$where=" where hos_patientappointments.status=$obj->status  and  hos_patientappointments.appointmentdate>='$obj->date' and  hos_patientappointments.appointmentdate<='$obj->todate'";
		elseif($obj->st==2)
			$where=" where hos_patientappointments.status=2 and hos_patientappointments.appointmentdate='$obj->date' and  hos_patientappointments.appointmentdate<='$obj->todate' ";
		else
			$where=" where  hos_patientappointments.appointmentdate='$obj->date' and  hos_patientappointments.appointmentdate<='$obj->todate'  ";
		
		if($obj->st==2){
		  if(empty($where))
		    $where=" where ";
		  else
		    $where.=" and ";
		  $where.=" hos_patientappointments.departmentid in ( select hos_departmentdoctors.departmentid from hos_departmentdoctors left join auth_users on hos_departmentdoctors.employeeid=auth_users.employeeid where  auth_users.id='".$_SESSION['userid']."') ";
		}
		$patientappointments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$patientappointments->result;
		$where="";
		while($row=mysql_fetch_object($res)){
		/*  
		if($row->payconsultancy==1){
		  $payables = new Payables();
		  $fields="*";
		  $join="";
		  $where=" where treatmentno='$row->id' and transactionid=9";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $payables->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $payables=$payables->fetchObject;
		  if($payables->paid=="No" or empty($payables->paid))
		    continue;
		 } */
		$i++;
		 //$obj->st=0;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<?php if($obj->st==2){?>
			<td><a href="../patienttreatments/addpatienttreatments_proc.php?appointmentid=<?php echo $row->id; ?>#tabs-3"><?php echo initialCap($row->patientid); ?></td>
			<?php }else if($obj->st==1){?>
			<td><a href="../patientvitalsigns/addpatientvitalsigns_proc.php?patientid=<?php echo $row->patient; ?>&appointmentid=<?php echo $row->id; ?>"><?php echo initialCap($row->patientid);?></a></td>
			<?php }else{?>
			<td><?php echo initialCap($row->patientid); ?></td>
			
			<?php }?>
			<td><?php echo $row->dob; ?></td>
			<td><?php echo $row->genderid; ?></td>
			<td><?php echo $row->patientclasseid; ?></td>
			<td><?php echo formatDate($row->appointmentdate); ?></td>
			<td><?php echo formatDate($row->bookedon); ?></td>
<!-- 			
			
			<?php if($obj->st==2){//echo $obj->st; ?>
			<td><a href="../patienttreatments/addpatienttreatments_proc.php?appointmentid=<?php echo $row->id; ?>">Treat</a></td>
			<?php ?>
			<?php }else if($obj->st==1){?>
			<td><a href="../patientvitalsigns/addpatientvitalsigns_proc.php?patientid=<?php echo $row->patient; ?>&appointmentid=<?php echo $row->id; ?>">View</a></td>
			<?php }else{   ?> 
			<!--<td><a href="../patienttreatments/addpatienttreatments_proc.php?treatmentid=<?php echo $row->id; ?>#tabs-3">View</a></td>-->
			<?php ?>
			<td>&nbsp;</td>
			<?php } ?>
			<td><a href="javascript:;" onclick="showPopWin('addpatientappointments_proc.php?id=<?php echo $row->id; ?>', 600, 350);"><img src="../edit.png" alt="edit" title="edit" /></a></td>
			<td><a href='patientappointments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
