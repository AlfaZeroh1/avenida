<?php
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once '../beds/Beds_class.php';

//connect to db
$db=new DB();

$id = $_GET['id'];
$wardid=$_GET['wardid'];

$beds=new Beds();
		$where=" where hos_beds.id not in(select bedid from hos_admissions where status=1) and hos_beds.wardid = $wardid ";
		$fields=" hos_beds.id, hos_beds.name bedno, hos_wards.name wardid ";
		$join=" left join hos_wards on hos_beds.wardid=hos_wards.id ";
		$having="";
		$groupby="";
		$orderby="";
		$beds->retrieve($fields,$join,$where,$having,$groupby,$orderby);

while($rw=mysql_fetch_object($beds->result)){
?>
<option value="<?php echo $rw->id; ?>" <?php if($obj->bedid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->wardid);?>: <?php echo initialCap($rw->bedno);?></option>
<?php
}
	
?>