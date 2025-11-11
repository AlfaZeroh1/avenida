<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../prod/sections/Sections_class.php");

$ob = (object)$_GET;

$sections = new Sections();
$where=" where prod_sections.blockid='$ob->id' ";
$fields=" concat(prod_blocks.name,' ', prod_sections.name) name, prod_sections.id ";
$join=" left join prod_blocks on prod_sections.blockid=prod_blocks.id ";
$having="";
$groupby="";
$orderby="";
$sections->retrieve($fields,$join,$where,$having,$groupby,$orderby);
?>
<option value="">Select...</option>
<?php

while($row=mysql_fetch_object($sections->result)){
  ?>
    <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
  <?php
}
?>