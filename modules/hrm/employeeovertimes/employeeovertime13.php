<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeeovertimes_class.php");
require_once("../employees/Employees_class.php");
require_once("../overtimes/Overtimes_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../departments/Departments_class.php");
require_once("../levels/Levels_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeeovertimes";

//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1120";//View
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;
$obj = (object)$_POST;
$ids = $_GET['ids'];

if(!empty($ids)){
  $obj->ids=$ids;
}

if(empty($obj->action)){
  $obj->month=date('m');
  $obj->year=date('Y');
  $obj->fromdate=date("Y-m-d");
  $obj->todate=date("Y-m-d");
}

if(!empty($ob->overtimeid)){

  $obj->overtimeid=$ob->overtimeid;
}

if(!empty($ob->ids)){
  $obj=$ob;
}


auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeeovertimes=new Employeeovertimes();
if(!empty($delid)){
	$employeeovertimes->id=$delid;
	$employeeovertimes->delete($employeeovertimes);
	redirect("employeeovertimes.php");
}
//Authorization.
$auth->roleid="1119";//View
$auth->levelid=$_SESSION['level'];

$overtimes = new Overtimes();
$fields="*";
$where=" where id in ($obj->ids)";
$join="";
$orderby="";
$groupby="";
$having="";
$overtimes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$overtimes = $overtimes->fetchObject;

if(existsRule($auth)){
?>
<div class="container">
<hr>

<!-- <a class="btn btn-info" onclick="showPopWin('addemployeeovertimes_proc.php',600,430);">Add Employeeovertimes</a> -->
<?php }?>
<script type="text/javascript">
	function addMatrix(str,xaxis,yaxis,field,value,arr,vl,hrs,basic)
	{
	    var amntname="amount"+xaxis+yaxis;
	//alert(" str "+str+" xaxis = "+xaxis+" yaxis "+yaxis+" field "+field+" value "+value+" arr "+arr);
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
// 	   var ans =  Math.round(((basic*12*vl*value)/(365*8))*Math.pow(10,2))/Math.pow(10,2)
	    var ans =  Math.round(((basic/((hrs*52)/12))*(value*vl)*Math.pow(10,2))/Math.pow(10,2))

	    document.getElementById(amntname).innerHTML=ans;
	 //document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
	 }
	}
	var url="../../server/server/matrix.php?checked="+checked+"&arr="+arr+"&xaxis="+xaxis+"&yaxis="+yaxis+"&field="+field+"&value="+value+"&module=hrm_employeeovertimes";
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
	}
</script>
<h3><?php echo $overtimes->name; ?></h3>
<hr>
<form action="employeeovertime.php" method="post">
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
<td>Level<input type="hidden" name="ids" value="<?php echo $obj->ids; ?>"/>
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
<td>Month:<input type="hidden" name="overtimeid" value="<?php echo $obj->overtimeid; ?>"/> 
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
      &nbsp;
      Year: <select name="year" id="year" class="selectbox">
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
        </select>&nbsp;
        From Date:<input type="text" name="fromdate" class="date_input" size="12" readonly value="<?php echo $obj->fromdate; ?>"/>&nbsp;
        To Date:<input type="text" name="todate" class="date_input" size="12" readonly value="<?php echo $obj->todate; ?>"/>
        <input type="submit" name="action" value="Filter"/>

</td>
</tr>
<table>
</form>

<table style="clear:both;"  class="table table-bordered table-condensed table-hover table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
	
		<tr>
			<th>#</th>
			<th>Employee </th>
			<th>Basic</th>
			<?php
			$overtime = new Overtimes();
			$fields="*";
			$join="  ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where id in ($obj->ids)";
			$overtime->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			while($rw=mysql_fetch_object($overtime->result)){
			  ?>
			  <th><?php echo $rw->name; ?> (Hrs)</th>
			  <th><?php echo $rw->name; ?> (Amnt)</th>
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
		$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.basic, concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) names";
		$join=" left join hrm_assignments on hrm_assignments.id = hrm_employees.assignmentid ";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		if(!empty($obj->departmentid))
		$where=" where hrm_assignments.departmentid = $obj->departmentid";
		if (!empty($obj->levelid))
		$where=" where hrm_assignments.levelid = $obj->levelid";
		$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employees->result;
		while($row=mysql_fetch_object($res)){
		  
		  $fromc=getDates($obj->fromyear, $obj->frommonth, 01);
		  $toc=getDates($obj->toyear, $obj->tomonth, 01);
		  
		  $overtime=0;
		  
		  
		  
		  ?>
		  
		  <tr>
			      <td><?php echo $i; ?></td>
			      <td><?php echo $row->pfnum; ?>&nbsp;<?php echo $row->names; ?></td>
			      <td><?php echo formatNumber($row->basic); ?>
		  
		  <?
			$overtimes = new Overtimes();
			$fields="*";
			$join="  ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where id in ($obj->ids)";
			$overtimes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			while($rw=mysql_fetch_object($overtimes->result)){
		  $employeeovertimes=new Employeeovertimes();
		  $fields="*, sum(hours) hours";
		  $join=" ";
		  $where=" where hrm_employeeovertimes.employeeid=$row->id and hrm_employeeovertimes.overtimeid=$rw->id and hrm_employeeovertimes.month='$obj->month' and hrm_employeeovertimes.year='$obj->year' and hrm_employeeovertimes.fromdate>='$obj->fromdate' and hrm_employeeovertimes.todate<='$obj->todate' ";
		  $having="";
		  $groupby=" group by employeeid";
		  $orderby=" order by hrm_employeeovertimes.id desc";
		  $employeeovertimes->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employeeovertimes->sql;
		  $employeeovertimes = $employeeovertimes->fetchObject;
		  
		  $overtime=$employeeovertimes->hours;
		  
		   $amount = (($row->basic/((52*$rw->hrs)/12))*($rw->value*$employeeovertimes->hours));

// 		  $amount = $row->basic*12*$employeeovertimes->hours*$rw->value/(365*8);
		  
		  $arr=array('employeeid'=>$row->id, 'overtimeid'=>$rw->id,'overtimetypeid'=>$rw->overtimetypeid, 'month'=>$obj->month, 'year'=>$obj->year,'fromdate'=>"$obj->fromdate", 'todate'=>"$obj->todate");

		  $sarr=rawurlencode(serialize($arr));
			
		$i++;
	?>
	<td>
	<input type="text" name="" size='6' onchange="addMatrix(this,<?php echo $row->id; ?>,<?php echo $rw->id; ?>,'hours',this.value,'<?php echo $sarr; ?>','<?php echo $rw->value; ?>','<?php echo $rw->hrs; ?>','<?php echo $row->basic; ?>');" value='<?php echo $overtime; ?>'></td>
	<td><div id="amount<?php echo $row->id; ?><?php echo $rw->id; ?>"><?php echo formatNumber($amount); ?></div></td>
		
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
