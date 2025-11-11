<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Observations_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Observations";
//connect to db
$db=new DB();
include"../../../head.php";

$delid=$_GET['delid'];
$observations=new Observations();
if(!empty($delid)){
	$observations->id=$delid;
	$observations->delete($observations);
	redirect("observations.php");
}
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addobservations_proc.php', 600, 430);" value="Add Observations" type="button"/></div>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Hos_patients</th>
			<th>Hos_patienttreatments</th>
			<th>Observation</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="hos_observations.id, hos_patients.name as patientid, hos_patienttreatments.name as patienttreatmentid, hos_observations.observation, hos_observations.createdby, hos_observations.createdon, hos_observations.lasteditedby, hos_observations.lasteditedon";
		$join=" left join hos_patients on hos_observations.patientid=hos_patients.id  left join hos_patienttreatments on hos_observations.patienttreatmentid=hos_patienttreatments.id ";
		$having="";
		$groupby="";
		$orderby="";
		$observations->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$observations->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->patientid; ?></td>
			<td><?php echo $row->patienttreatmentid; ?></td>
			<td><?php echo $row->observation; ?></td>
			<td><a href="javascript:;" onclick="showPopWin('addobservations_proc.php?id=<?php echo $row->id; ?>', 600, 430);">Edit</a></td>
			<td><a href='observations.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
