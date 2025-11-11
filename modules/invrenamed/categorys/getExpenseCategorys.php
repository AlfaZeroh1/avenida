<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../fn/expenses/Expenses_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../fn/expensecategorys/Expensecategorys_class.php");

$db = new DB();

$obj = (object)$_GET;

$expensecategorys= new Expensecategorys();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where expensetypeid in(select id from fn_expensetypes where acctypeid='$obj->id') ";
$expensecategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
?>
<option value="">Select...</option>
<?php
while($row=mysql_fetch_object($expensecategorys->result)){
  ?>
  <option value="<?php echo $row->id; ?>" <?php if($row->id==$obj->expensecategoryid){echo "selected";}?>><?php echo initialCap($row->name);?></option>
  <?php
}
?>