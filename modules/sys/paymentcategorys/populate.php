<?php
session_start();
require_once("../../../lib.php");
require_once("../../../DB.php");
require_once("../../sys/paymentcategorys/Paymentcategorys_class.php");
require_once("../../sys/paymentmodes/Paymentmodes_class.php");

$ob = (object)$_GET;

$paymentcategorys = new Paymentcategorys();
$fields="*";
$where=" where paymentmodeid='$ob->paymentmodeid' ";
if(!empty($ob->id)){
  $where.=" and id='$ob->id'";
}
$join="";
$having="";
$groupby="";
$orderby="";
$paymentcategorys->retrieve($fields, $join, $where, $having, $groupby, $orderby);
?>
<option value="">Select...</option>
<?php
while($row=mysql_fetch_object($paymentcategorys->result)){
  ?>
  <option value="<?php echo $row->id; ?>" <?php if($row->id==$id){echo"selected";}?>><?php echo initialCap($row->name); ?></option>
  <?php
}

?>

