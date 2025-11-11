<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Customerprices_class.php");
require_once("../../pos/sizes/Sizes_class.php");
require_once("../../pos/seasons/Seasons_class.php");
require_once("../../pos/categorys/Categorys_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../crm/customers/Customers_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Customerprices";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8680";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$customerid=$_GET['customerid'];

$customers = new Customers();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$customers = $customers->fetchObject;

$customerprices=new Customerprices();
if(!empty($delid)){
	$customerprices->id=$delid;
	$customerprices->delete($customerprices);
	redirect("customerprices.php");
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
	var url="../../server/server/matrix.php?checked="+checked+"&arr="+arr+"&xaxis="+xaxis+"&yaxis="+yaxis+"&field="+field+"&value="+value+"&module=crm_customerprices";
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
	}
	</script>
<?php
//Authorization.
$auth->roleid="8679";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!--<div style="float:left;" class="buttons"> <input onclick="showPopWin('addcustomerprices_proc.php',600,430);" value="Add Customerprices " type="button"/></div>-->
<?php }?>
<form action="customerprices.php" method="post">
<h2><?php echo strtoupper($customers->name); ?></h2>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		
		
		<tr>
			<th>#</th>
			<th>Season </th>
			<th>Category </th>
			<?php
			$sizes = new Sizes();
			$fields="pos_sizes.id, pos_sizes.name, pos_sizes.remarks, pos_sizes.ipaddress, pos_sizes.createdby, pos_sizes.createdon, pos_sizes.lasteditedby, pos_sizes.lasteditedon";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$res=$sizes->result;
			while($row=mysql_fetch_object($res)){
			  ?>
			  <th><?php echo $row->name; ?></th>
			  <?php
			}
			?>

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
		
		$categorys = new Categorys();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$rs=$categorys->result;
		while($r = mysql_fetch_object($rs)){$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo initialCap($row->name); ?></td>
			<td><?php echo $r->name; ?></td>
			<?php
			$sizes = new Sizes();
			$fields="pos_sizes.id, pos_sizes.name, pos_sizes.remarks, pos_sizes.ipaddress, pos_sizes.createdby, pos_sizes.createdon, pos_sizes.lasteditedby, pos_sizes.lasteditedon";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where="";
			$sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$ress=$sizes->result;
			while($rw=mysql_fetch_object($ress)){
			$customerprices = new Customerprices();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where customerid='$customerid' and categoryid='$r->id' and seasonid='$row->id' and sizeid='$rw->id' ";
			$customerprices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$customerprices = $customerprices->fetchObject;
			
			$arr=array('customerid'=>$customerid, 'categoryid'=>$r->id,'seasonid'=>$row->id, 'sizeid'=>$rw->id);

			$sarr=rawurlencode(serialize($arr));
			  ?>
			  <td><input type='text' size='4' onchange="addMatrix(this,<?php echo $customerid; ?>,<?php echo $row->id; ?>,'price',this.value,'<?php echo $sarr; ?>');" name='<?php ?>' value='<?php echo $customerprices->price; ?>'/></td>
			  <?php
			}
			?>

		</tr>
	<?php 
	}
	}
	?>
	</tbody>
</table>
</form>
<?php
include"../../../foot.php";
?>
