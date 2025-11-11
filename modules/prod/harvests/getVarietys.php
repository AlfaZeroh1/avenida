<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../prod/varietys/Varietys_class.php");

$ob = (object)$_GET;

$varietys = new Varietys();
$where=" where id in(select varietyid from prod_greenhousevarietys where greenhouseid='$ob->id') ";
$fields="*";
$join=" ";
$having="";
$groupby="";
$orderby="";
$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
?>
<option value="">Select...</option>
<?php
while($row=mysql_fetch_object($varietys->result)){
  ?>
    <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
  <?php
}
?>