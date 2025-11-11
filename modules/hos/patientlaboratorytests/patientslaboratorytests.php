<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patientlaboratorytests_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../hos/payables/Payables_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$auth->roleid="1283";
$auth->levelid=$_SESSION['level'];

auth($auth);

$obj = (object)$_POST;
if(empty($obj->action)){
	$obj->testedon=date("Y-m-d");
	$obj->totestedon=date("Y-m-d");
}
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
?>

<style type="text/css">

.green{
  background-image: -webkit-gradient(linear, left 0%, left 100%, from(#ffffff), to(#33CC33));
  background-image: -webkit-linear-gradient(top, #ffffff, 0%, #33CC33, 100%);
  background-image: -moz-linear-gradient(top, #ffffff 0%, #33CC33 100%);
  background-image: linear-gradient(to bottom, #ffffff 0%, #33CC33 100%);
}

.table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
  background-color:;
}
</style>

<form action='patientslaboratorytests.php' method='post'>
<div align="center">From Tested On: <input type='text' name='testedon' size='12' class='date_input' value='<?php echo $obj->testedon; ?>'/>&nbsp;To Tested On: <input type='text' name='totestedon' size='12' class='date_input' value='<?php echo $obj->totestedon; ?>'/>
<input type='submit' name='action' value='Filter'/></div>
<table style="clear:both;"  id="example" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Test/Treatment No </th>
			<th>Patient</th>
			<th>Scheduled On</th>
			<th>Testedon</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="hos_patientlaboratorytests.id, count(*) cnt, hos_patientlaboratorytests.patienttreatmentid, hos_patientlaboratorytests.testno, concat(hos_patients.surname,' ', hos_patients.othernames) as patientid, hos_patients.patientclasseid, hos_patientlaboratorytests.patienttreatmentid, hos_laboratorytests.name as laboratorytestid, hos_patientlaboratorytests.labresults, hos_patientlaboratorytests.testedon, hos_patientlaboratorytests.consult, hos_patientlaboratorytests.createdby, hos_patientlaboratorytests.createdon, hos_patientlaboratorytests.lasteditedby, hos_patientlaboratorytests.lasteditedon";
		$join=" left join hos_patients on hos_patientlaboratorytests.patientid=hos_patients.id  left join hos_laboratorytests on hos_patientlaboratorytests.laboratorytestid=hos_laboratorytests.id ";
		$having="";
		$groupby=" group by hos_patientlaboratorytests.testno ";
		$orderby=" order by hos_patientlaboratorytests.testno desc ";
		$where=" where hos_patientlaboratorytests.testedon>='$obj->testedon' and hos_patientlaboratorytests.testedon<='$obj->totestedon'";
		$patientlaboratorytests->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $patientlaboratorytests->sql;
		$res=$patientlaboratorytests->result;
		$where="";
		while($row=mysql_fetch_object($res)){
		
                $payables = new Payables();
                $fields="count(*) cnt";
                $where=" where treatmentno in(select patientappointmentid from hos_patienttreatments where id='$row->patienttreatmentid') and paid in('No','Partial')";
                $join="";
                $having="";
                $groupby="";
                $orderby="";
                $payables->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $payables->sql;
                $ress = $payables->fetchObject;
                
               if(($row->patientclasseid==1 and $ress->cnt==0) or $row->patientclasseid!=1){
                
		
		$i++;
		
		//check if results are provided
		if(!empty($row->labresults))
		  $class="green";
	?>
		<tr>
			<td class="<?php echo $class; ?>"><?php echo $i; ?></td>
			<td class="<?php echo $class; ?>"><?php if(empty($row->consult)){echo $row->testno;}else{echo $row->patienttreatmentid; } ?></td>
			<td class="<?php echo $class; ?>"><?php echo initialCap($row->patientid); ?><?php if($row->consult==1){echo "<i>(from doctor)</i>";}?> (<font color="red"><?php echo $row->cnt; ?> tests</font>)</td>
			<td class="<?php echo $class; ?>"><?php echo formatDate($row->createdon); ?></td>
			<td class="<?php echo $class; ?>"><?php echo formatDate($row->testedon); ?></td>
			<td class="<?php echo $class; ?>"><a href='patientlaboratorytests.php?testno=<?php echo $row->testno; ?>' >View</a></td>
		</tr>
	<?php 
	}
	}
	?>
	</tbody>
</table>
</form>
<?php
include"../../../foot.php";
?>
