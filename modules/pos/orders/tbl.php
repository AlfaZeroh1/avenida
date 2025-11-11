<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Orders_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crm/customers/Customers_class.php");
require_once("../orderdetails/Orderdetails_class.php");
require_once("../../pos/orders/Orders_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../../pos/sizes/Sizes_class.php");
require_once("../../crm/customerconsignees/Customerconsignees_class.php");
require_once("../../inv/categorys/Categorys_class.php");
require_once("../../sys/branches/Branches_class.php");
require_once("../../../Mobile_Detect.php");
$detect = new Mobile_Detect;

//connect to db
$db=new DB();
$obj=(object)$_GET;

$pop=2;
// include "../../../head.php";

?>

<style type="text/css">
.btns {
    -moz-user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
    cursor: pointer;
    display: inline-block;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857;
    margin-bottom: 0;
    padding: 6px 12px;
    text-align: center;
    vertical-align: middle;
    white-space: nowrap;
    background-color: #f0ad4e;
    font-weight:bold;
    font-size:100%;
    min-width:98%;
    max-width:98%;
    transition-duration: 0.4s;
}
.btns:after {
    -moz-user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
    cursor: pointer;
    display: inline-block;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857;
    margin-bottom: 0;
    padding: 6px 12px;
    text-align: center;
    vertical-align: middle;
    white-space: nowrap;
    background-color: green;
    font-weight:bold;
    font-size:100%;
    min-width:98%;
    max-width:98%;
    transition: all 0.8s
}
.btns:active:after {
    -moz-user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
    cursor: pointer;
    display: inline-block;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857;
    margin-bottom: 0;
    padding: 6px 12px;
    text-align: center;
    vertical-align: middle;
    white-space: nowrap;
    background-color: #f0ad4e;
    font-weight:bold;
    font-size:100%;
    min-width:98%;
    max-width:98%;
}

.table {
    margin-bottom: 0;
    max-width: 100%;
}

.tag a 
{ 
  display: inline-block;      
/*   background-color:#899898; */
/*   height:125px; */
  width:80%;
/*   color:#000; */
  font-family:Arial;
  font-size:20px;
}
a{
  color:black;
}
</style>

<table class="table" style="overflow:scroll;">
<?php
if($obj->type==1){
  $items = new Items();
  $where=" where status='Active' ";
}else{
  $items = new Categorys();
  $where=" where 1=1 ";
}
$fields=" * ";
$join="";
$groupby="";
$having="";

if($obj->type==1){
  $where.=" and categoryid='$obj->categoryid' " ;
}else{
  $where.=" and id in(select categoryid from sys_branchcategorys where brancheid='$obj->brancheid') ";
}

if($obj->type==1){
  $orderby=" order by name ";
}else{
  $orderby=" order by name ";
}
$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);

$num=6-($items->affectedRows%4);

$i=0;
while($rw=mysql_fetch_object($items->result)){

$size="26px";

if(strlen($rw->name)>20)
  $size="25";

if(strlen($rw->name)>22)
  $size="22";
  
if(strlen($rw->name)>24)
  $size="20";
  
  $tbls=2;
  if($detect->isMobile())$tbls=1;
?>
  <?php if($i%$tbls==0){ ?>
  <tr>
  <?php } ?>
  <td style="text-transform:uppercase;font-weight:bold;">
  <?php if($obj->type==1){ ?>
  <div class="tag">
    <a href="javascript:;" class="btns waves-effect" <?php if(empty($rw->warmth)){?> onClick="saveForm('<?php echo $rw->id; ?>','1','');" <?php }else{ ?> onclick="loadWarmthModal('<?php echo $rw->id; ?>','1','<?php echo $rw->warmth; ?>');" <?php } ?>>
    
      <?php 
      
      if(empty($rw->image)){
	$rw->image='<img class="icon icons8-Protein" src="data:image/png;base64,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" width="50" height="50">';
      }
      
      echo $rw->image; ?><br/>
      <span style="font-size:<?php echo $size; ?>;"><?php echo $rw->name; ?></span>
    </a>
    </div>
  
  <?php }else{ ?>
  <div class="tag">
    <a href="javascript:;" class="btns waves-effect" onClick="setCategory('<?php echo $rw->id; ?>');">
    
      <img class="icon icons8-Dossier" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAA+ElEQVRoge3ZMQ6CMBQGYBPvwcwBYLUYTCRuDVeC2bjriIkbg9WNjcF4C+QI7s8JY9RgJbS0+v/J29+XvP4hYTRCEASxIpP4uGBc1IwLUjx1wEXUO4BxcdGwfDOVCoCu5YlxQQAAAIACgBdm5LgJOW5CfpjZAciL8pwXJT3OanMgx02tAZyeAcv1K6BrtJ6Qfz+hlLzZ1j5A2zQZ765SA0AXQFsLGXtCsi1kMuCrFjL6hGRayGiAzCM27oR+CoBvoYEAUi1kLKDJpxayAqBzAHgHQAsNBEALGQOw/hEDAMCfA+z+wRFwETEuKh3LT+P9vHcAgiCIktwAoRPhY6ELy7kAAAAASUVORK5CYII=" width="48" height="48"><br/>
      <span style="font-size:<?php echo $size; ?>;"><?php echo $rw->name; ?></span>
    </a>
   </div>
  <?php } ?>
  </td>
  
<?
  $i++;
}

$x = 0;
while($x<$num){
  ?>
  <td style="width:16.67%;">&nbsp;</td>
  <?
  $x++;
}
?>

</table>