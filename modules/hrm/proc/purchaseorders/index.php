<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("../../auth/rules/Rules_class.php");

$submodules = new Submodules();
$fields=" * ";
$join="";
$groupby="";
$orderby=" order by priority ";
$having="";
$where=" where name='proc_purchaseorders'";
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;


include"../../../head.php";
?>
<ul id="cmd-buttons">
<?php
$submodules = new Submodules();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" where indx='proc_purchaseorders' and status=1";
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
while($row=mysql_fetch_object($submodules->result)){
?>
		<li><a class="button icon chat" href="<?php echo trim($row->url); ?>"><?php echo trim(initialCap($row->description)); ?></a></li>
<?php
}


//Authorization.
$auth->roleid="8139";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
  ?>
  <li><a class="button icon chat" href="../../proc/purchaseorders/addpurchaseorders_proc.php?type=cash&retrieve=1">Retrieve LPO's (Cash)</a></li>
  <?
}
?>
</ul>
<?php
include "../../../foot.php";
?>