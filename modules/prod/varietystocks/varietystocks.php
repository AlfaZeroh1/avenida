<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Varietystocks_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Varietystocks";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8688";//Add
$auth->levelid=$_SESSION['level'];


$obj=(object)$_POST;
$ob = (object)$_GET;

if(!empty($ob->varietyid)){
  $obj->varietyid=$ob->varietyid;
}
$class = $_GET['class'];

auth($auth);
include"../../../rptheader.php";

$rptwhere=" where prod_varietystocks.varietyid='$obj->varietyid' ";

$track=1;

if(empty($obj->action)){
  $obj->fromrecorddate=date('Y-m-d',mktime(0,0,0,date("m")-1,date("d"),date("Y")));
  $obj->torecorddate=date('Y-m-d',mktime(0,0,0,date("m"),date("d"),date("Y")));
}
  
  if(!empty($obj->fromrecorddate)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" inv_stocktrack.recorddate>='$obj->fromrecorddate'";
	$track++;
}

if(!empty($obj->torecorddate)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" inv_stocktrack.recorddate<='$obj->torecorddate'";
	$track++;
}

$delid=$_GET['delid'];
$id=$_GET['id'];
$varietystocks=new Varietystocks();
if(!empty($delid)){
	$varietystocks->id=$delid;
	$varietystocks->delete($varietystocks);
	redirect("varietystocks.php");
}
//Authorization.
$auth->roleid="8687";//View
$auth->levelid=$_SESSION['level'];

?>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {

	//TableToolsInit.sSwfPath = "../../../media/swf/ZeroClipboard.swf";

 	$('#example').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
		"bJQueryUI": true,
		"iDisplayLength":20,
		"sPaginationType": "full_numbers"
	} );
} );
</script> 
<form action="varietystocks.php" method="post">
<table align='center'>
	<tr align="center">
		<td>
		<input type='hidden' name="varietyid" value="<?php echo $obj->varietyid; ?>"/>
                 <input type='hidden' name="class" value="<?php echo $obj->class; ?>"/>
		
		From: <input type="text" size="12" readonly="readonly" class="date_input" name="fromrecorddate" id="fromrecorddate" value="<?php echo $obj->fromrecorddate; ?>"/>
										&nbsp;To: <input type="text" size="12" readonly="readonly" class="date_input" name="torecorddate" id="torecorddate" value="<?php echo $obj->torecorddate; ?>"/>
										<input type="hidden" name="varietyid" value="<?php echo $obj->varietyid; ?>"/>
										<input class="btn btn-info" type="submit" class="btn" value="Filter" name="action" id="action"/>
	</tr>
</table>
</form>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Document No </th>
			<th>Variety </th>
			<th>Length </th>
			<th>Area </th>
			<th>Action </th>
			<th>Quantity </th>
			<th>Remain </th>
			<th>Date Recorded </th>
			<th>Date Of Action </th>
			<th>User</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="prod_varietystocks.id, prod_varietystocks.documentno, prod_varietys.name as varietyid, prod_sizes.name sizeid, prod_areas.name as areaid, prod_varietystocks.transaction, prod_varietystocks.quantity, prod_varietystocks.remain, prod_varietystocks.recordedon, prod_varietystocks.actedon, prod_varietystocks.ipaddress, auth_users.username createdby, prod_varietystocks.createdon, prod_varietystocks.lasteditedby, prod_varietystocks.lasteditedon";
		$join=" left join prod_varietys on prod_varietystocks.varietyid=prod_varietys.id  left join prod_areas on prod_varietystocks.areaid=prod_areas.id left join prod_sizes on prod_sizes.id=prod_varietystocks.sizeid left join auth_users on auth_users.id=prod_varietystocks.createdby ";
		$having="";
		$groupby="";
		$orderby="";
		if(!empty($id)){
		  $where=" where prod_varietys.id='$id' ";
		}
		$varietystocks->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$res=$varietystocks->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->varietyid; ?></td>
			<td><?php echo $row->sizeid; ?></td>
			<td><?php echo $row->areaid; ?></td>
			<td><?php echo $row->transaction; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->remain); ?></td>
			<td><?php echo formatDate($row->recordedon); ?></td>
			<td><?php echo formatDate($row->createdon); ?></td>
			<td><?php echo $row->createdby; ?></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
