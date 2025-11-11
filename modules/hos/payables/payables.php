<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Payables_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Payables";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8436";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$obj = (object)$_POST;

$delid=$_GET['delid'];
$payables=new Payables();
if(!empty($delid)){
	$payables->id=$delid;
	$payables->delete($payables);
	redirect("payables.php");
}

if(empty($obj->action)){
  $obj->invoicedon=date("Y-m-d");
}
//Authorization.
$auth->roleid="8435";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addpayables_proc.php',600,430);" value="Add Payables " type="button"/></div>
<?php }?>

<form action="payables.php" method="post">
<div align="center">Date: <input type='text' name='invoicedon' size='10' readonly class='date_input' value='<?php echo $obj->invoicedon; ?>'/>&nbsp;
<input type='submit' name='action' value='Filter'/></div>
</form>

<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Patient </th>
			<th>Appointment No </th>
			<th>Treatmentno No </th>
			<th>Pay Status </th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		/*$fields=" distinct(hos_payables.treatmentno) treatmentno, concat(hos_patients.surname,' ', hos_patients.othernames) as patientid, hos_patients.id patient ";
		$join=" left join hos_patients on hos_payables.patientid=hos_patients.id ";
		$having="";
		$groupby=" group by treatmentno ";
		$orderby=" order by treatmentno desc";
		$where=" where hos_payables.transactionid!=9 and invoicedon='$obj->invoicedon'";
		$payables->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$payables->result;*/
		$query="select distinct(hos_payables.treatmentno) treatmentno, hos_patienttreatments.id as treatmentnos, hos_payables.departmentid,hos_payables.consult, concat(hos_patients.surname,' ', hos_patients.othernames) as patientid, hos_patients.id patient
		from hos_payables left join hos_patients on hos_payables.patientid=hos_patients.id left join hos_patienttreatments on hos_patienttreatments.patientappointmentid=hos_payables.treatmentno where hos_payables.transactionid!=9 and 
		invoicedon='$obj->invoicedon' and hos_payables.consult=1 group by treatmentno 
		union 
		select distinct(hos_payables.treatmentno) treatmentno,hos_patienttreatments.id as treatmentnos,hos_payables.departmentid,hos_payables.consult, concat(hos_patients.surname,' ', hos_patients.othernames) as patientid, hos_patients.id patient
		from hos_payables left join hos_patients on hos_payables.patientid=hos_patients.id left join hos_patienttreatments on hos_patienttreatments.patientappointmentid=hos_payables.treatmentno where hos_payables.transactionid!=9 and 
		invoicedon='$obj->invoicedon' and hos_payables.consult=0 group by treatmentno
		union
		select distinct(hos_payables.treatmentno) treatmentno, hos_patienttreatments.id as treatmentnos, hos_payables.departmentid, hos_payables.consult, concat(hos_patients.surname,' ', hos_patients.othernames) as patientid,
		hos_patients.id patient from hos_payables left join hos_patients on hos_payables.patientid=hos_patients.id left join hos_patienttreatments on hos_patienttreatments.patientappointmentid=hos_payables.treatmentno where hos_payables.transactionid=9 
		and treatmentno not in(select patientappointmentid from hos_patienttreatments where invoicedon='$obj->invoicedon' ) and invoicedon='$obj->invoicedon' and consult=1 
		group by treatmentno";
		$res=mysql_query($query);
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo initialCap($row->patientid); ?></td>
			<td><?php echo $row->treatmentno; ?></td>
			<td><?php echo $row->treatmentnos; ?></td>
			<td><?php echo $row->paid; ?></td>
			<td><a target="_blank" href="../../hos/patienttreatments/addpatienttreatments_proc.php?treatmentid=<?php echo $row->treatmentnos; ?>&action3=Prescribe">Prescription</a></td>
			<td><a href="#" onclick="showPopWin('addpayables_proc.php?treatmentno=<?php echo $row->treatmentno; ?>&patientid=<?php echo $row->patient; ?>&consult=<?php echo $row->consult; ?>&departmentid=<?php echo $row->departmentid; ?>',600,430);">Bill</a>
			<td><a href="../../hos/payments/addpayments_proc.php?treatmentid=<?php echo $row->treatmentno; ?>&consult=<?php echo $row->consult; ?>&patientid=<?php echo $row->patient; ?>&action3=Retrieve&departmentid=<?php echo $row->departmentid; ?>">Pay</a></td>
			<td><a href="../../hos/payments/addpayments_proc.php?treatmentid=<?php echo $row->treatmentno; ?>&consult=<?php echo $row->consult; ?>&patientid=<?php echo $row->patient; ?>&action3=Retrieve&status=creditnote&departmentid=<?php echo $row->departmentid; ?>"></a></td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
