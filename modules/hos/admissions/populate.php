<?php
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once '../wards/Wards_class.php';

//connect to db
$db=new DB();

// $id = $_GET['id'];
$deptid=$_GET['departmentid'];

	$wards=new Wards();
	$where=" hos_wards.departmentid = $deptid";
	$fields="hos_wards.id, hos_wards.name, hos_wards.departmentid, hos_wards.remarks, hos_wards.firstroom, hos_wards.lastroom, hos_wards.roomprefix, hos_wards.status, hos_wards.createdby, hos_wards.createdon, hos_wards.lasteditedby, hos_wards.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$wards->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($wards->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->wardid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	
?>