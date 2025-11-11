<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patientlaboratorytests_class.php");
require_once("../../auth/rules/Rules_class.php");

$testno = $_GET['testno'];


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$auth->roleid="1283";
$auth->levelid=$_SESSION['level'];

auth($auth);

$page_title="Patientlaboratorytests";
//connect to db
$db=new DB();
include"../../../head.php";

$delid=$_GET['delid'];
$patientlaboratorytests=new Patientlaboratorytests();
if(!empty($delid)){
	$patientlaboratorytests->id=$delid;
	$patientlaboratorytests->delete($patientlaboratorytests);
	redirect("patientlaboratorytests.php");
}

$fields="concat(hos_patients.surname,' ', hos_patients.othernames) as patientid, hos_patients.patientno";
$join=" left join hos_patients on hos_patientlaboratorytests.patientid=hos_patients.id  left join hos_laboratorytests on hos_patientlaboratorytests.laboratorytestid=hos_laboratorytests.id ";
$having="";
$groupby="";
$orderby="";
$where=" where hos_patientlaboratorytests.testno='$testno'";
$patientlaboratorytests->retrieve($fields,$join,$where,$having,$groupby,$orderby);
?>
<script language="javascript" type="text/javascript">
function Clickheretoprint()
{ 
	poptastic("print-lab.php?testno=<?php echo $testno; ?>",450,940);
}
</script>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addpatientlaboratorytests_proc.php?testno=<?php echo $testno; ?>', 600, 430);" value="Add Patientlaboratorytests" type="button" class="btn"/></div>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
	<tr>
		<th colspan="8" align="center">Test No: <?php echo $testno; ?> <h3><?php echo $patientlaboratorytests->fetchObject->patientid; ?></h3>Patient No: <?php echo $patientlaboratorytests->fetchObject->patientno; ?></th>
	</tr>
		<tr>
			<th>#</th>
			<th>Hos_laboratorytests</th>
			<th>Results</th>
			<th>Labresults</th>
			<th>Testedon</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="hos_patientlaboratorytests.id, hos_patientlaboratorytests.testno, hos_patientlaboratorytests.results, concat(hos_patients.surname,' ', hos_patients.othernames) as patientid, hos_patientlaboratorytests.patienttreatmentid, hos_laboratorytests.name as laboratorytestid, hos_patientlaboratorytests.labresults, hos_patientlaboratorytests.testedon, hos_patientlaboratorytests.consult, hos_patientlaboratorytests.createdby, hos_patientlaboratorytests.createdon, hos_patientlaboratorytests.lasteditedby, hos_patientlaboratorytests.lasteditedon";
		$join=" left join hos_patients on hos_patientlaboratorytests.patientid=hos_patients.id  left join hos_laboratorytests on hos_patientlaboratorytests.laboratorytestid=hos_laboratorytests.id ";
		$having="";
		$groupby="";
		$orderby=" ";
		$where=" where hos_patientlaboratorytests.testno='$testno'";
		$patientlaboratorytests->retrieve($fields,$join,$where,$having,$groupby,$orderby); //echo $patientlaboratorytests->sql;
		$res=$patientlaboratorytests->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->laboratorytestid; ?></td>
			<td><?php echo $row->results; ?></td>
			<td><?php echo $row->labresults; ?></td>
			<td><?php echo formatDate($row->testedon); ?></td>
			<td><a href="javascript:;" onclick="showPopWin('addpatientlaboratorytests_proc.php?id=<?php echo $row->id; ?>', 600, 730);">Results</a></td>
			<td><a href='patientlaboratorytests.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Cancel</a></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<div align="center"><input type="button" value="Print" onclick="Clickheretoprint();"></div>
<?php
include"../../../foot.php";
?>
