<?php 
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../prod/greenhouses/Greenhouses_class.php");

$varietyid=$_GET['varietyid'];
//connect to db
$db=new DB();

$greenhouses=new Greenhouses();
$where=" where id in(select greenhouseid from  prod_greenhousevarietys where varietyid='$varietyid') ";
$fields="prod_greenhouses.id, prod_greenhouses.name, prod_greenhouses.sectionid, prod_greenhouses.remarks, prod_greenhouses.ipaddress, prod_greenhouses.createdby, prod_greenhouses.createdon, prod_greenhouses.lasteditedby, prod_greenhouses.lasteditedon";
$join="";
$having="";
$groupby="";
$orderby="";
$greenhouses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
?>
<option value="">select.......</option>
<?php
while($rw=mysql_fetch_object($greenhouses->result)){
      ?>
    <option value="<?php echo $rw->id; ?>" <?php if($obj->greenhouseid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
      <?php
}
?>