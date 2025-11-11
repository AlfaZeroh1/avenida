<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patientappointments_class.php");
require_once '../../hos/payables/Payables_class.php';
require_once '../../hos/patienttreatments/Patienttreatments_class.php';


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="In - Patients";
//connect to db
$db=new DB();
include"../../../head.php";

$delid=$_GET['delid'];
$st=$_GET['st'];

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


?>

<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Patient Name</th>
			<th>Admission Date</th>
			<th>Treatment No</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php		
		$patienttreatments = new Patienttreatments();
		$i=0;
		$fields="concat(hos_patients.surname,' ', hos_patients.othernames) patientid, hos_patienttreatments.id treatmentno, hos_admissions.status";
		$join=" left join hos_patients on hos_patients.id=hos_patienttreatments.patientid left join hos_admissions on hos_admissions.treatmentid=hos_patienttreatments.id";
		$having="";
		$groupby="";
		$orderby=" ";
		$where=" where hos_patienttreatments.admission='Yes' and hos_admissions.status=1";
		$patienttreatments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$patienttreatments->result;
		$where="";
		while($row=mysql_fetch_object($res)){
		  
		
		$i++;
		 //$obj->st=0;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo initialCap($row->patientid); ?></td>
			<td>&nbsp;</td>
			<td><?php echo $row->treatmentno; ?></td>
			<td><a target="_blank" href="../../hos/patienttreatments/addpatienttreatments_proc.php?treatmentid=<?php echo $row->treatmentno; ?>&action3=Prescribe">Prescribe</a></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
