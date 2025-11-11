<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patientprescriptions_class.php");
require_once("../../hos/patients/Patients_class.php");
require_once '../../inv/items/Items_class.php';
require_once ("../../inv/stocktrack/Stocktrack_class.php");
require_once("../../hos/patienttreatments/Patienttreatments_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Patientprescriptions";
//connect to db
$db=new DB();
include"../../../head.php";

$delid=$_GET['delid'];
$patientprescriptions=new Patientprescriptions();
if(!empty($delid)){
	$patientprescriptions->id=$delid;
	$patientprescriptions->delete($patientprescriptions);
	//redirect("../patienttreatments/addpatientprescriptions.php");
}
$obj = (object)$_POST;
$ob = (object)$_GET;

$treatmentid=$_GET['treatmentid'];
$id=$_GET['id'];

if(!empty($treatmentid)){
	$obj->treatmentid=$treatmentid;
}
if(!empty($id)){
	
	//update item quantity
	$items = new Items();
	$fields="*";
	$where=" where id='$ob->itemid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$items=$items->fetchObject;
	$items->quantity=$ob->quantity;
	$items->transaction="Prescription";
	$items->itemid=$ob->itemid;
	$items->id='';
	
	$it = new Items();
	//$it->setObject($items);
	$it->reduceStock($items);
	//$it->edit($it);
	
	$patientprescription = new Patientprescriptions();
	$fields="*";
	$where=" where id='$ob->id'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patientprescription->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$patientprescription= $patientprescription->fetchObject;
	$patientprescription->issued=1;
	
	$pat = new Patientprescriptions();
	$pat->setObject($patientprescription);
	$pat->edit($pat);
	
}
$patients = new Patients();
$fields="hos_patients.id,hos_patients.patientno,concat(hos_patients.surname,' ',hos_patients.othernames) names";
$join=" left join hos_patienttreatments on hos_patients.id=hos_patienttreatments.patientid ";
$having="";
$groupby="";
$orderby="";
$where=" where hos_patienttreatments.id='$obj->treatmentid' ";
$patients->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$patients= $patients->fetchObject;

$patienttreatments = new Patienttreatments();
$fields="auth_users.username";
$join=" left join auth_users on auth_users.id=hos_patienttreatments.createdby ";
$having="";
$groupby="";
$orderby="";
$where=" where hos_patienttreatments.id='$obj->treatmentid'";
$patienttreatments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$patienttreatments = $patienttreatments->fetchObject;

?>

<form action="patientprescriptions.php" class="forms" method="post">
<table align="center" style="margin-left:35%;">
	<tr>
		<td colspan='2'>Treatment No:<input type="text" size="12" name="treatmentid" value="<?php echo $obj->treatmentid; ?>"/>
						<input class="btn" type="submit" name="action" value="Search"/>
						
<!-- 						<div style="float:left;" class="buttons"> <input onclick="showPopWin('addpatientprescriptions_proc.php?patienttreatmentid=<?php echo $obj->treatmentid; ?>',600,430);" value="Add Prescription " type="button"/></div> -->
						</td>
	</tr>
	<tr>
	  <td align="right">Patient:</td>
	  <td><?php echo $patients->patientno; ?>&nbsp;<?php echo initialCap($patients->names); ?></td>
	</tr>
	<tr>
	  <td align="right">Treated By:</td>
	  <td><?php echo $patienttreatments->username; ?></td>
	</tr>
</table>
</form>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Item</th>
			<th>Quantity</th>
			<th>Price</th>
			<th>Frequency</th>
			<th>Duration(days)</th>
			<th>Dosage</th>
<!-- 			<th>&nbsp;</th> -->
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="hos_patientprescriptions.id, inv_items.name itemname,hos_patientprescriptions.remarks ,  hos_patientprescriptions.itemid, hos_patienttreatments.id as patienttreatmentid, hos_patientprescriptions.quantity,hos_patientprescriptions.frequency,hos_patientprescriptions.duration, hos_patientprescriptions.price, hos_patientprescriptions.issued, hos_patientprescriptions.createdby, hos_patientprescriptions.createdon, hos_patientprescriptions.lasteditedby, hos_patientprescriptions.lasteditedon";
		$join=" left join inv_items on hos_patientprescriptions.itemid=inv_items.id  left join hos_patienttreatments on hos_patientprescriptions.patienttreatmentid=hos_patienttreatments.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hos_patienttreatments.id='$obj->treatmentid' ";
		$patientprescriptions->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$res=$patientprescriptions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->itemname; ?></td>
			<td><?php echo $row->quantity; ?></td>
			<td align="right"><?php echo formatNumber($row->price); ?></td>
			<td><?php echo $row->frequency; ?></td>
			<td><?php echo $row->duration; ?></td>
			<td><?php echo $row->remarks; ?></td>
<!-- 			<td><a href="javascript:;" onclick="showPopWin('addpatientprescriptions_proc.php?id=<?php echo $row->id; ?>',600,430);">Edit</a></td> -->
			<?php if($row->issued==0){?>
			<td><a href="patientprescriptions.php?treatmentid=<?php echo $obj->treatmentid; ?>&id=<?php echo $row->id; ?>&itemid=<?php echo $row->itemid; ?>&quantity=<?php echo $row->quantity; ?>">Issue</a></td>
			<?php }else{?>
			<td><b>ISSUED</b></td>
			<?php }?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
