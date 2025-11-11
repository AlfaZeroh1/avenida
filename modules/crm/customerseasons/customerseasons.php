
<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Customerseasons_class.php");
require_once("../../pos/seasons/Seasons_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Customerseasons";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8826";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$customerid=$_GET['customerid'];
$customerseasons=new Customerseasons();
if(!empty($delid)){
	$customerseasons->id=$delid;
	$customerseasons->delete($customerseasons);
	redirect("customerseasons.php");
}
?>
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
	var url="../../server/server/matrix.php?checked="+checked+"&arr="+arr+"&xaxis="+xaxis+"&yaxis="+yaxis+"&field="+field+"&value="+value+"&module=crm_customerseasons";
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
	}
	
	function checkDate(st,str){
	  if(str=="0000-00-00")
	    document.getElementById(st).value="";
	}
	</script>
	
<?php
//Authorization.
$auth->roleid="8825";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!--<div style="float:left;" class="buttons"> <input onclick="showPopWin('addcustomerseasons_proc.php',600,430);" value="Add Customerseasons " type="button"/></div>-->
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Season </th>
			<th>Date From</th>
			<th>Date To</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$seasons = new Seasons();
		$fields="pos_seasons.id, pos_seasons.name, pos_seasons.start, pos_seasons.end, pos_seasons.remarks, pos_seasons.ipaddress, pos_seasons.createdby, pos_seasons.createdon, pos_seasons.lasteditedby, pos_seasons.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$seasons->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$seasons->result;
		while($row=mysql_fetch_object($res)){
		$i++;
		$customerseasons = new Customerseasons();
		$fields="*";
		$join="";
		$orderby="";
		$groupby="";
		$having="";
		$where=" where seasonid='$row->id' and customerid='$customerid'";
		$customerseasons->retrieve($fields,$join,$where,$having,$orderby);
		$customerseasons = $customerseasons->fetchObject;
		
		if($customerseasons->startdate=="0000-00-00")
		  $customerseasons->startdate="";
		  
		if($customerseasons->enddate=="0000-00-00")
		  $customerseasons->enddate="";
		
		$arr=array('customerid'=>$customerid, 'seasonid'=>$row->id);

		$sarr=rawurlencode(serialize($arr));
	?>
		<tr>
			<td><?php echo $i; ?></td>			
			<td><?php echo initialCap($row->name); ?></td>
			<td><input type='text' placeholder="<?php echo date('Y-m-d');?>" name="startdate<?php echo $customerid; ?><?php echo $row->id; ?>" id="startdate<?php echo $customerid; ?><?php echo $row->id; ?>" size='12' onclick="checkDate('startdate<?php echo $customerid; ?><?php echo $row->id; ?>',this.value);" onchange="addMatrix(this,<?php echo $customerid; ?>,<?php echo $row->id; ?>,'startdate',this.value,'<?php echo $sarr; ?>');"  value="<?php echo $customerseasons->startdate; ?>"/></td>
			<td><input type='text' placeholder="<?php echo date('Y-m-d');?>" name="enddate<?php echo $customerid; ?><?php echo $row->id; ?>" id="enddate<?php echo $customerid; ?><?php echo $row->id; ?>" size='12' onclick="checkDate('enddate<?php echo $customerid; ?><?php echo $row->id; ?>',this.value);" onchange="addMatrix(this,<?php echo $customerid; ?>,<?php echo $row->id; ?>,'enddate',this.value,'<?php echo $sarr; ?>');"  value="<?php echo $customerseasons->enddate; ?>"/></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
