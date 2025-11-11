<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeedeductions_class.php");
require_once("../employees/Employees_class.php");
require_once("../deductions/Deductions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeedeductions";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1132";//View
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;
$obj = (object)$_POST;

$ids = $_GET['ids'];
if(!empty($ob->deductionid)){
  $obj->deductionid=$ob->deductionid;
  $ids=$obj->deductionid;
}

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeedeductions=new Employeedeductions();
if(!empty($delid)){
	$employeedeductions->id=$delid;
	$employeedeductions->delete($employeedeductions);
	redirect("employeedeductions.php");
}
//Authorization.
$auth->roleid="1131";//View
$auth->levelid=$_SESSION['level'];

$deductions = new Deductions();
$fields="*";
$where=" where id in($ids)";
$join="";
$orderby="";
$groupby="";
$having="";
$deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$deductions = $deductions->fetchObject;

if(empty($obj->action)){
 
 $obj->frommonth=date("m");
  $obj->tomonth=date("m");
  $obj->fromyear=date("Y");
  $obj->toyear=date("Y");

}

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addemployeedeductions_proc.php',600,430);">Add Employeedeductions</a>
<?php }?>

<script type="text/javascript">
	function addMatrix(str,xaxis,yaxis,field,value,arr)
	{//alert(" str "+str+" xaxis = "+xaxis+" yaxis "+yaxis+" field "+field+" value "+value+" arr "+arr);
		if(str.checked)
	{
		var checked=1;
	}
	else
	{
		var checked=0;
	}
	if (str=="")
	{
	document.getElementById("txtHint").innerHTML="";
	return;
	 }
	if (window.XMLHttpRequest)
	{
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	 }
	xmlhttp.onreadystatechange=function()
	{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	 {
	 document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
	 }
	}
	var url="../../server/server/matrix.php?checked="+checked+"&arr="+arr+"&xaxis="+xaxis+"&yaxis="+yaxis+"&field="+field+"&value="+value+"&module=hrm_employeedeductions";alert(url);
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
	}
</script>
	
<hr>
<form action="employeededuction.php" method="post">
<table align='center'>
<tr>
<td colspan='2'><h2><?php echo $deductions->name; ?></h2></td>
</tr>
<tr>
<td>From:<input type="hidden" name="deductionid" value="<?php echo $obj->deductionid; ?>"/> 
    <select name="frommonth" id="frommonth" class="selectbox">
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
      &nbsp;
      <select name="fromyear" id="fromyear" class="selectbox">
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
</td>
<td>To:

  <select name="tomonth" id="tomonth" class="selectbox">
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
      &nbsp;
      <select name="toyear" id="toyear" class="selectbox">
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
        </select>&nbsp;<input type="submit" name="action" value="Filter"/>

</td>
</tr>
<table>
</form>
<table style="clear:both;" class="table table-bordered table-condensed table-hover table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Employee </th>
			<?php
			$deductions = new Deductions();
			$fields="*";
			$join="  ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where id in ($ids)";
			$deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			while($rw=mysql_fetch_object($deductions->result)){
			  ?>
			  <th><?php echo $rw->name; ?></th>
			  <?
			}
			?>
			<th>Remarks </th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$employees = new Employees();
		$fields="hrm_employees.id, hrm_employees.pfnum, concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) names";
		$join=" ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" ";
		$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$res=$employees->result;
		while($row=mysql_fetch_object($res)){
		  
		  $fromc=getDates($obj->fromyear, $obj->frommonth, 01);
		  $toc=getDates($obj->toyear, $obj->tomonth, 01);
		  
		  $deduction=0;
		  ?>
		  <tr>
			      <td><?php echo $i; ?></td>
			      <td><?php echo $row->pfnum; ?>&nbsp;<?php echo $row->names; ?></td>
		  <?php
		  $deductions = new Deductions();
		  $fields="*";
		  $join="  ";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $where=" where id in ($ids)";
		  $deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  while($rw=mysql_fetch_object($deductions->result)){
			$employeedeductions=new Employeedeductions();
			$fields="*";
			$join=" ";
			$where=" where hrm_employeedeductions.employeeid=$row->id and hrm_employeedeductions.deductionid=$rw->id ";
			$having="";
			$groupby="";
			$orderby=" order by hrm_employeedeductions.id desc";
			$employeedeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employeedeductions->sql;
			$employeedeductions = $employeedeductions->fetchObject;
			
			$from=getDates($employeedeductions->fromyear, $employeedeductions->frommonth, 01);
			$to=getDates($employeedeductions->toyear, $employeedeductions->tomonth, 01);//echo "$fromc>=$from and $toc<=$to";
			if($fromc>=$from and $toc<=$to){
				$deduction=$employeedeductions->amount;
			}
			
			$arr=array('employeeid'=>$row->id, 'deductionid'=>$rw->id,'deductiontypeid'=>$rw->deductiontypeid, 'frommonth'=>$obj->frommonth, 'fromyear'=>$obj->fromyear, 'tomonth'=>$obj->tomonth, 'toyear'=>$obj->toyear);

			$sarr=rawurlencode(serialize($arr));
			      
		      $i++;
	      ?>
		      
			      <td><input type="text" name="" size='6' onchange="addMatrix(this,<?php echo $row->id; ?>,<?php echo $rw->id; ?>,'amount',this.value,'<?php echo $sarr; ?>');" value='<?php echo $deduction; ?>'></td>
			      
	      <?php 
		}
		?>
		  <td><?php echo $row->remarks; ?></td>
		</tr>
		<?php
		}
	      ?>
	</tbody>
</table>
<hr>
</div>
<?php
include"../../../foot.php";
?>
