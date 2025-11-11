<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeeallowances_class.php");
require_once("../employees/Employees_class.php");
require_once("../allowances/Allowances_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../departments/Departments_class.php");
require_once("../levels/Levels_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeeallowances";

//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1120";//View
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;
$obj = (object)$_POST;
$ids = $_GET['ids'];

if(!empty($ob->allowanceid)){
// echo "mavado";
  $obj->allowanceid=$ob->allowanceid;
}

if(!empty($ids)){
  $obj->ids=$ids;
}

if(empty($obj->action)){
  $obj->frommonth=date("m");
  $obj->fromyear=date("Y");
  
  $obj->tomonth=date("m");
  $obj->toyear=date("Y");
}

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeeallowances=new Employeeallowances();
if(!empty($delid)){
	$employeeallowances->id=$delid;
	$employeeallowances->delete($employeeallowances);
	redirect("employeeallowances.php");
}
//Authorization.
$auth->roleid="1119";//View
$auth->levelid=$_SESSION['level'];

$allowances = new Allowances();
$fields="*";
$where=" where id in ($ids)";
$join="";
$orderby="";
$groupby="";
$having="";
$allowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$allowances = $allowances->fetchObject;

if(existsRule($auth)){
?>
<div class="container">
<hr>

<!-- <a class="btn btn-info" onclick="showPopWin('addemployeeallowances_proc.php',600,430);">Add Employeeallowances</a> -->
<?php }?>
<script type="text/javascript">
	
	try{function addMatrix(str,xaxis,yaxis,field,value,arr)
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
	 //document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
	 }
	}
	var url="../../server/server/matrix.php?checked="+checked+"&arr="+arr+"&xaxis="+xaxis+"&yaxis="+yaxis+"&field="+field+"&value="+value+"&module=hrm_employeeallowances";
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
	}}catch(e){alert(e);}
</script>
<h3><?php echo $allowances->name; ?></h3>
<hr>
<form action="employeeallowance.php" method="post">
<table align='center'>
<tr>
<td>Dept
<select id="departmentid" name="departmentid">
<option value="">select</option>

<?
$departments = New Departments();
$where = "";
$fields ="*";
$join="";
$having="";
$groupby="";
$orderby="";
$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
while($rw=mysql_fetch_object($departments->result)){


?>
	<option value="<?php echo $rw->id; ?>" <?php if($obj->departmentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
<?
}
?>
</select>

</td>
<td>Level<input type="text" name="ids" value="<?php echo $obj->ids; ?>"/>
<select id="levelid" name="levelid">
<option value="">select</option>
<?
$levels = New Levels();
$where = "";
$fields ="*";
$join="";
$having="";
$groupby="";
$orderby="";
$levels->retrieve($fields,$join,$where,$having,$groupby,$orderby);
while($rw=mysql_fetch_object($levels->result)){


?>
	<option value="<?php echo $rw->id; ?>" <?php if($obj->levelid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
<?
}
?>
</select>

</td>
<td>From:<input type="hidden" name="allowanceid" value="<?php echo $obj->allowanceid; ?>"/> 
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

<table style="clear:both;"  class="table table-bordered table-condensed table-hover table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
	
		<tr>
			<th>#</th>
			<th>Employee </th>
			<?php
			$allowance = new Allowances();
			$fields="*";
			$join="  ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where id in ($obj->ids)";
			$allowance->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			while($rw=mysql_fetch_object($allowance->result)){
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
		$where = " where hrm_employees.statusid=1 ";
		$fields=" hrm_employees.id, hrm_employees.pfnum, concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) names";
		$join=" left join hrm_assignments on hrm_assignments.id = hrm_employees.assignmentid ";
		$having="";
		$groupby="";
		$orderby="";
		if(!empty($obj->departmentid))
		$where.=" and departmentid = $obj->departmentid";
		if (!empty($obj->levelid))
		$where.=" and levelid = $obj->levelid";
		$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();//echo $employees->sql;
		$res=$employees->result;
		while($row=mysql_fetch_object($res)){
		  $i++;
		  $fromc=getDates($obj->fromyear, $obj->frommonth, 01);
		  $toc=getDates($obj->toyear, $obj->tomonth, 01);
		  
		  $allowance=0;
		  
		  
		  
		  ?>
		  
		  <tr>
			      <td><?php echo $i; ?></td>
			      <td><?php echo $row->pfnum; ?>&nbsp;<?php echo $row->names; ?></td>
		  
		  <?
			$allowances = new Allowances();
			$fields="*";
			$join="  ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where id in ($obj->ids)";
			$allowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			while($rw=mysql_fetch_object($allowances->result)){
		  $employeeallowances=new Employeeallowances();
		  $fields="*";
		  $join=" ";
		  $where=" where hrm_employeeallowances.employeeid=$row->id and hrm_employeeallowances.allowanceid=$rw->id and CONCAT(fromyear,'-',LPAD(frommonth,2,'00'),'-',LPAD(1,2,'00'))<=CONCAT($obj->fromyear,'-',LPAD($obj->frommonth,2,'00'),'-',LPAD(1,2,'00')) and CONCAT(toyear,'-',LPAD(tomonth,2,'00'),'-',LPAD(1,2,'00'))>=CONCAT($obj->toyear,'-',LPAD($obj->tomonth,2,'00'),'-',LPAD(1,2,'00')) ";
		  $having="";
		  $groupby="";
		  $orderby=" order by hrm_employeeallowances.id desc";
		  $employeeallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);//if($row->id==1){echo $employeeallowances->sql;}
		  $employeeallowances = $employeeallowances->fetchObject;
		  
		  $allowance=0;
			
		  $allowance=$employeeallowances->amount;
		  
// 		  $from=getDates($employeeallowances->fromyear, $employeeallowances->frommonth, 01);
// 		  $to=getDates($employeeallowances->toyear, $employeeallowances->tomonth, 01);//echo "$fromc>=$from and $toc<=$to";
// 		  if($fromc>=$from and $toc<=$to){
// 			  $allowance=$employeeallowances->amount;
// 		  }
		  
		  $arr=array('employeeid'=>$row->id, 'allowanceid'=>$rw->id,'allowancetypeid'=>$rw->allowancetypeid, 'frommonth'=>$obj->frommonth, 'fromyear'=>$obj->fromyear, 'tomonth'=>$obj->tomonth, 'toyear'=>$obj->toyear);

		  $sarr=rawurlencode(serialize($arr));
			
		
	?>
	<td>
	<input type="text" name="" size='6' onchange="addMatrix(this,<?php echo $row->id; ?>,<?php echo $rw->id; ?>,'amount',this.value,'<?php echo $sarr; ?>');" value='<?php echo $allowance; ?>'></td>
		
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
