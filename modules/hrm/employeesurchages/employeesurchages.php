<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeesurchages_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeesurchages";
//connect to db
$db=new DB();


$obj = (object)$_POST;


if(empty($obj->action)){
	$obj->fromyear=date("Y");
	$obj->frommonth=date("m");
	$obj->toyear=date("Y");
	$obj->tomonth=date("m");
}

$wh=" where 1=1 ";
if(!empty($obj->frommonth)){
  $wh.=" and hrm_employeesurchages.frommonth='$obj->frommonth' ";
}
if(!empty($obj->tomonth)){
  $wh.=" and hrm_employeesurchages.tomonth='$obj->tomonth' ";
}
if(!empty($obj->fromyear)){
  $wh.=" and hrm_employeesurchages.fromyear='$obj->fromyear' ";
}
if(!empty($obj->toyear)){
  $wh.=" and hrm_employeesurchages.toyear='$obj->toyear' ";
}
//Authorization.
$auth->roleid="1170";//View
$auth->levelid=$_SESSION['level'];


auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeesurchages=new Employeesurchages();
if(!empty($delid)){
	$employeesurchages->id=$delid;
	$employeesurchages->delete($employeesurchages);
	redirect("employeesurchages.php");
}
//Authorization.
$auth->roleid="1169";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addemployeesurchages_proc.php',600,430);" value="Add Employeesurchages " type="button"/></div>
<?php }?>

<form action="employeesurchages.php" method="post">
<div style="float:center;">

<table align="center" id="tasktable">
  <tr>
    <td><div align="right"></div>
    
     &nbsp;&nbsp; <strong>From Month</strong>:
      <select name="frommonth">
        <option value="">Select...</option>
        <option value="1" <?php if($obj->frommonth==1){echo"selected";}?>>January</option>
        <option value="2" <?php if($obj->frommonth==2){echo"selected";}?>>February</option>
        <option value="3" <?php if($obj->frommonth==3){echo"selected";}?>>March</option>
        <option value="4" <?php if($obj->frommonth==4){echo"selected";}?>>April</option>
        <option value="5" <?php if($obj->frommonth==5){echo"selected";}?>>May</option>
        <option value="6" <?php if($obj->frommonth==6){echo"selected";}?>>June</option>
        <option value="7" <?php if($obj->frommonth==7){echo"selected";}?>>July</option>
        <option value="8" <?php if($obj->frommonth==8){echo"selected";}?>>August</option>
        <option value="9" <?php if($obj->frommonth==9){echo"selected";}?>>September</option>
        <option value="10" <?php if($obj->frommonth==10){echo"selected";}?>>October</option>
        <option value="11" <?php if($obj->frommonth==11){echo"selected";}?>>November</option>
        <option value="12" <?php if($obj->frommonth==12){echo"selected";}?>>December</option>
      </select>
      
    
        <strong>From Year:</strong>
        <select name="fromyear">
          <option value="">Select...</option>
          <?php
  $i=date("Y")-10;
  while($i<date("Y")+10)
  {
  	?>
          <option value="<?php echo $i; ?>" <?php if($obj->fromyear==$i){echo"selected";}?>><?php echo $i; ?></option>
          <?
    $i++;
  }
  ?>
        </select>
      &nbsp;&nbsp; <strong>To Month</strong>:
      <select name="tomonth">
        <option value="">Select...</option>
        <option value="1" <?php if($obj->tomonth==1){echo"selected";}?>>January</option>
        <option value="2" <?php if($obj->tomonth==2){echo"selected";}?>>February</option>
        <option value="3" <?php if($obj->tomonth==3){echo"selected";}?>>March</option>
        <option value="4" <?php if($obj->tomonth==4){echo"selected";}?>>April</option>
        <option value="5" <?php if($obj->tomonth==5){echo"selected";}?>>May</option>
        <option value="6" <?php if($obj->tomonth==6){echo"selected";}?>>June</option>
        <option value="7" <?php if($obj->tomonth==7){echo"selected";}?>>July</option>
        <option value="8" <?php if($obj->tomonth==8){echo"selected";}?>>August</option>
        <option value="9" <?php if($obj->tomonth==9){echo"selected";}?>>September</option>
        <option value="10" <?php if($obj->tomonth==10){echo"selected";}?>>October</option>
        <option value="11" <?php if($obj->tomonth==11){echo"selected";}?>>November</option>
        <option value="12" <?php if($obj->tomonth==12){echo"selected";}?>>December</option>
      </select>
     
      
      
       <strong>To Year:</strong>
        <select name="toyear">
          <option value="">Select...</option>
          <?php
  $i=date("Y")-10;
  while($i<date("Y")+10)
  {
  	?>
          <option value="<?php echo $i; ?>" <?php if($obj->toyear==$i){echo"selected";}?>><?php echo $i; ?></option>
          <?
    $i++;
  }
  ?>
  </select>
   <input type="submit" name="action" id="action" value="Load" />
      </td>
  </tr>
  
</table>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Surcharge </th>
			<th>Employee </th>
			<th>Surchage Type </th>
			<th>Amount </th>
			<th>Charged On </th>
			<th>From </th>
			<th>To </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="1171";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1172";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="hrm_employeesurchages.id, hrm_surchages.name as surchageid, concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) employeeid, hrm_surchagetypes.name as surchagetypeid, hrm_employeesurchages.amount, hrm_employeesurchages.chargedon, hrm_employeesurchages.frommonth, hrm_employeesurchages.fromyear, hrm_employeesurchages.tomonth, hrm_employeesurchages.toyear, hrm_employeesurchages.remarks, hrm_employeesurchages.createdby, hrm_employeesurchages.createdon, hrm_employeesurchages.lasteditedby, hrm_employeesurchages.lasteditedon";
		$join=" left join hrm_surchages on hrm_employeesurchages.surchageid=hrm_surchages.id  left join hrm_employees on hrm_employeesurchages.employeeid=hrm_employees.id  left join hrm_surchagetypes on hrm_employeesurchages.surchagetypeid=hrm_surchagetypes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where="".$wh;
		$employeesurchages->retrieve($fields,$join,$where,$having,$groupby,$orderby);  
		$res=$employeesurchages->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->surchageid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->surchagetypeid; ?></td>
			<td align="right"><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo formatDate($row->chargedon); ?></td>
			<td><?php echo getMonth($row->frommonth); ?>&nbsp;<?php echo $row->fromyear; ?></td>
			<td><?php echo getMonth($row->tomonth); ?>&nbsp;<?php echo $row->toyear; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="1171";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addemployeesurchages_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="1172";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='employeesurchages.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
