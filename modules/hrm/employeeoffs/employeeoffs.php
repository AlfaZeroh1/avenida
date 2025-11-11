<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeeoffs_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/employees/Employees_class.php");

$page_title="Employeeoffs";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="12042";//Add
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeeoffs=new Employeeoffs();
if(!empty($delid)){
	$employeeoffs->id=$delid;
	$employeeoffs->delete($employeeoffs);
	redirect("employeeoffs.php");
}
?>
<script type="text/javascript">
	function addMatrix(str,xaxis,yaxis,field,value,arr)
	{
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
	 }
	}
	<?php $employeeoffs= new Employeeoffs(); ?>
	var url="../../server/server/matrix.php?checked="+checked+"&arr="+arr+"&xaxis="+xaxis+"&yaxis="+yaxis+"&field="+field+"&value="+value+"&module=hrm_employeeoffs";
	xmlhttp.open("GET",url,true);
	xmlhttp.send();

	tr.style.visibility="hidden";
	tr.style.display="none";
	}
	</script>

<table style="clear:both;"  class="table" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<th>#</th>
		<th>&nbsp;</th>
	<?php
	$i=0;
	while($i<7){
	?>
		<th><?php echo date('l', strtotime("Sunday + $i Days")); ?></th>
	<?php
	  $i++;
	}
	?>
	</thead>
	<tbody>
	<?php
	$i=0;
	$employees=new Employees();
	$fields=" concat(hrm_employees.firstname, ' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) name, hrm_employees.id " ;
	$where="";
	if(!empty($ob->levelid)){
	  $where.=" where hrm_assignments.levelid='$ob->levelid' ";
	}
	$join=" left join hrm_assignments on hrm_assignments.id=hrm_employees.assignmentid ";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	while($rw=mysql_fetch_object($employees->result)){
	$i++;
	?>
	<tr>
		<td><?php echo initialCap($i); ?></td>
		<td><?php echo initialCap($rw->name); ?></td>
	<?php
		$i=0;
		while($i<7){
			$employeeoffs= new Employeeoffs();
			$fields=" * ";
			$where = " where employeeid=$rw->id and day=($i+1) "; 
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$employeeoffs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$arr=array("employeeid"=>$rw->id, "day"=>($i+1));

			$sarr=rawurlencode(serialize($arr));

			?>
			<td><input type='checkbox' name="<?php echo $rw->id; ?><?php echo ($i+1); ?>" <?php if($employeeoffs->affectedRows>0){echo "checked";}?> onchange="addMatrix(this,<?php echo ($i+1); ?>,<?php echo $rw->id; ?>,'field',this.value,'<?php echo $sarr; ?>');" ></td>
			<?php
			$i++;
		}
		?>
	</tr>
		<?php
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
