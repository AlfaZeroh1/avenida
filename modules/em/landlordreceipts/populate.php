<?php
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once '../plots/Plots_class.php';

//connect to db
$db=new DB();

$id = $_GET['id'];

$plots=new plots();
$where=" where em_plots.landlordid='$id'  ";
$fields="*";
$join="  ";
$having=" ";
$groupby="";
$orderby="";
$plots->retrieve($fields,$join,$where,$having,$groupby,$orderby);

while($rw=mysql_fetch_object($plots->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->plotid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->code);?>=><?php echo initialCap($rw->name); ?></option>
	<?php
	}
	
?>