<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeepaidarrears_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../arrears/Arrears_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeepaidarrears";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9377";//Add
$auth->levelid=$_SESSION['level'];

$obj = (object)$_POST;
$ob = (object)$_GET;

if(!empty($ob->arrearid)){
  $obj->arrearid=$ob->arrearid;
}

if(empty($obj->action)){
  $obj->month=date("m");
  $obj->year=date("Y");
}

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeepaidarrears=new Employeepaidarrears();
if(!empty($delid)){
	$employeepaidarrears->id=$delid;
	$employeepaidarrears->delete($employeepaidarrears);
	redirect("employeepaidarrears.php");
}
//Authorization.
$auth->roleid="9376";//View
$auth->levelid=$_SESSION['level'];

$arrears = new Arrears();
$fields="*";
$where=" where id='$obj->arrearid'";
$join="";
$orderby="";
$groupby="";
$having="";
$arrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$arrears = $arrears->fetchObject;


if(existsRule($auth)){
?>
<!-- <div style="float:left;" class="buttons"> <input onclick="showPopWin('addemployeepaidarrears_proc.php',600,430);" value="Add Employeepaidarrears " type="button"/></div> -->
<?php }?>

<form action="" method="post">
<table>
<tr>
<td><h2><?php echo $arrears->name; ?></h2></td>
</tr>
  <tr>
    <td>Month:<input type="hidden" name="deductionid" value="<?php echo $obj->deductionid; ?>"/> 
    <select name="month" id="month" class="selectbox">
        <option value="">Select...</option>
        <option value="1" <?php if($obj->month==1){echo"selected";}?>>January</option>
        <option value="2" <?php if($obj->month==2){echo"selected";}?>>February</option>
        <option value="3" <?php if($obj->month==3){echo"selected";}?>>March</option>
        <option value="4" <?php if($obj->month==4){echo"selected";}?>>April</option>
        <option value="5" <?php if($obj->month==5){echo"selected";}?>>May</option>
        <option value="6" <?php if($obj->month==6){echo"selected";}?>>June</option>
        <option value="7" <?php if($obj->month==7){echo"selected";}?>>July</option>
        <option value="8" <?php if($obj->month==8){echo"selected";}?>>August</option>
        <option value="9" <?php if($obj->month==9){echo"selected";}?>>September</option>
        <option value="10" <?php if($obj->month==10){echo"selected";}?>>October</option>
        <option value="11" <?php if($obj->month==11){echo"selected";}?>>November</option>
        <option value="12" <?php if($obj->month==12){echo"selected";}?>>December</option>
      </select>
    Year:
    <select name="year" id="year" class="selectbox">
          <option value="">Select...</option>
          <?php
	  $i=date("Y")-10;
	  while($i<date("Y")+10)
	  {
		?>
		  <option value="<?php echo $i; ?>" <?php if($obj->year==$i){echo"selected";}?>><?php echo $i; ?></option>
		  <?
	    $i++;
	  }
	  ?>
        </select>&nbsp;<input type="submit" name="action" value="Filter"/></td>   
  </tr>
</table>
</form>

<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Arrears </th>
			<th>Employee </th>
			<th>Month </th>
			<th>Year </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9378";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- 			<th>&nbsp;</th> -->
<?php
}
//Authorization.
$auth->roleid="9379";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- 			<th>&nbsp;</th> -->
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="hrm_employeepaidarrears.id, hrm_arrears.name as arrearid, hrm_employees.name as employeeid, hrm_employeepaidarrears.month, hrm_employeepaidarrears.year, hrm_employeepaidarrears.remarks, hrm_employeepaidarrears.ipaddress, hrm_employeepaidarrears.createdby, hrm_employeepaidarrears.createdon, hrm_employeepaidarrears.lasteditedby, hrm_employeepaidarrears.lasteditedon";
		$join=" left join hrm_arrears on hrm_employeepaidarrears.arrearid=hrm_arrears.id  left join hrm_employees on hrm_employeepaidarrears.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employeepaidarrears.arrearid='$obj->arrearid' and month='$obj->month' and year='$obj->year'";
		$employeepaidarrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employeepaidarrears->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->arrearid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->month; ?></td>
			<td><?php echo $row->year; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9378";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- 			<td><a href="javascript:;" onclick="showPopWin('addemployeepaidarrears_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td> -->
<?php
}
//Authorization.
$auth->roleid="9379";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- 			<td><a href='employeepaidarrears.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td> -->
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
