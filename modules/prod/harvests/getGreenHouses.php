<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../prod/greenhouses/Greenhouses_class.php");

$ob = (object)$_GET;

$greenhouses = new Greenhouses();
$where=" where sectionid='$ob->id' ";
$fields="*";
$join=" ";
$having="";
$groupby="";
$orderby="";
$greenhouses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
?>
<option value="">Select...</option>
<?php
while($row=mysql_fetch_object($greenhouses->result)){
  ?>
    <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
  <?php
}
?>