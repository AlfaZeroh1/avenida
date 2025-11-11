<?php
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once '../houses/Houses_class.php';
//require_once '../plots/Plots_class.php';

//connect to db
$db=new DB();

$id = $_GET['id'];
$tenantid=$_GET['tenantid'];
$houseid=$_GET['houseid'];

if(!empty($houseid))
	$obj->houseid=$houseid;

$houses=new Houses();
if(!empty($id) and empty($tenantid))
	$where=" where em_houses.plotid='$id'  ";
if(empty($id) and !empty($tenantid))
	$where=" where em_housetenants.tenantid='$tenantid'";

$fields="em_houses.id, em_houses.hseno, em_houses.hsecode, concat(em_plots.code,' ',em_plots.name) plotid, em_houses.amount, em_houses.size, em_houses.bedrms, em_houses.floor, em_houses.elecaccno, em_houses.wateraccno, em_houses.hsedescriptionid, em_houses.deposit, em_houses.vatable, em_houses.housestatusid, em_houses.rentalstatusid, em_houses.remarks";

if(!empty($id) and empty($tenantid))
	$join=" left join em_plots on em_houses.plotid=em_plots.id ";
if(empty($id) and !empty($tenantid))
	$join=" left join em_plots on em_houses.plotid=em_plots.id left join em_housetenants on em_housetenants.houseid=em_houses.id ";

$having=" ";
$groupby="";
$orderby=" order by em_houses.hseno ";
$houses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

while($rw=mysql_fetch_object($houses->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->houseid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->plotid);?>=><?php echo initialCap($rw->hseno); ?></option>
	<?php
	}
	
?>