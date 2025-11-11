<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Items_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../inv/categorys/Categorys_class.php");
require_once("../../inv/departments/Departments_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Items";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="704";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$obj = (object)$_POST;

if(empty($obj->action))
  $obj->status="Active";
  


$delid=$_GET['delid'];
$items=new Items();
if(!empty($delid)){

	$items=new Items();
	$where=" where id=$delid ";	
	$fields="inv_items.id, inv_items.code, inv_items.name, inv_items.departmentid, inv_items.departmentcategoryid, inv_items.categoryid, inv_items.manufacturer, inv_items.strength, inv_items.costprice, inv_items.tradeprice, inv_items.retailprice, inv_items.size, inv_items.unitofmeasureid, inv_items.vatclasseid, inv_items.generaljournalaccountid, inv_items.generaljournalaccountid2, inv_items.package, inv_items.reorderlevel, inv_items.reorderquantity, inv_items.quantity, inv_items.reducing, inv_items.status, inv_items.createdby, inv_items.createdon, inv_items.lasteditedby, inv_items.lasteditedon, inv_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo $items->sql;
	$items=$items->fetchObject;
	
	if($_GET['status']=="active")
	  $items->status="Not Active";
	else
	  $items->status="Active";
	
	$it = new Items();
	$it = $it->setObject($items);
	$it->edit($it);
	redirect("items.php");
}
//Authorization.
$auth->roleid="703";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('additems_proc.php?departmentid=<?php echo $_GET['departmentid'];?>',600,430);" value="Add Items " type="button"/></div>
<?php }?>
<form action="items.php" method="post">
<table class="table">
  <tr>
    <td>Status:</td>
    <td><select name='status'>
		<option value='Active' <?php if($obj->status=='Active'){echo"selected";}?>>Active</option>
		<option value='Not Active' <?php if($obj->status=='Not Active'){echo"selected";}?>>Not Active</option>
	</select></td>
    <td>Category:</td> 
    <td><select name="categoryid" class="selectbox">
	<option value="">Select...</option>
	<?php
		$categorys=new Categorys();
		$where="  ";
		$fields="inv_categorys.id, inv_categorys.name, inv_categorys.remarks, inv_categorys.createdby, inv_categorys.createdon, inv_categorys.lasteditedby, inv_categorys.lasteditedon, inv_categorys.ipaddress";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

		while($rw=mysql_fetch_object($categorys->result)){
		?>
			<option value="<?php echo $rw->id; ?>" <?php if($obj->categoryid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
		<?php
		}
		?>
	</select>
    </td>
    
    
    <td>Department:</td> 
    <td><select name="departmentid" class="selectbox">
	<option value="">Select...</option>
	<?php
		$departments=new Departments();
		$where="  ";
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

		while($rw=mysql_fetch_object($departments->result)){
		?>
			<option value="<?php echo $rw->id; ?>" <?php if($obj->departmentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
		<?php
		}
		?>
	</select>
    </td>
    <td>Stock between <input type="text" size="4" name="fromquantity" value="<?php echo $obj->fromquantity; ?>"/></td>
    <td>and 
	<input type="text" size="4" name="toquantity" value="<?php echo $obj->toquantity; ?>"/></td>
    <td><input type="submit" class="btn btn-primary" name="action" value="Filter"/></td>
  </tr>
</table>
</form>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=array('inv_items.id','inv_items.code','inv_items.name', 'inv_departments.name departmentid', 'inv_items.retailprice','inv_items.costprice','inv_items.size','inv_unitofmeasures.name unitofmeasureid','inv_items.quantity','inv_items.package','inv_items.status','inv_items.reducing','sys_currencys.name currencyid','1','inv_items.value','(inv_items.value*inv_items.quantity) as stock','inv_items2.name as itemname');?>
 <?php $_SESSION['sColumns']=array('id','code','name','departmentid','categoryid','costprice','size','unitofmeasureid','quantity','package','status','reducing','retailprice','1','value','stock','itemname');?>
 <?php $_SESSION['join']=" left join inv_unitofmeasures on inv_unitofmeasures.id=inv_items.unitofmeasureid left join sys_vatclasses on sys_vatclasses.id=inv_items.vatclasseid left join inv_departments on inv_departments.id=inv_items.departmentid left join inv_categorys on inv_categorys.id=inv_items.categoryid left join sys_currencys on sys_currencys.id=inv_items.currencyid left join inv_items inv_items2 on inv_items2.id=inv_items.itemid ";?>
 <?php $_SESSION['sTable']="inv_items";?>
 <?php $_SESSION['sOrder']=" ";?>
 <?php 
 $_SESSION['sWhere']="";
 
 if(!empty($obj->categoryid)){
    $where.=" and inv_items.categoryid='$obj->categoryid' ";
  }
   if(!empty($obj->departmentid)){
    $where.=" and inv_items.departmentid='$obj->departmentid' ";
  }
  if(!empty($obj->fromquantity)){
    $where.=" and inv_items.quantity>='$obj->fromquantity' ";
  }
  if(!empty($obj->toquantity)){
    $where.=" and inv_items.quantity<='$obj->toquantity' ";
  }
      
 $_SESSION['sWhere']=" inv_items.status='$obj->status' ".$where;
 
 if(!empty($_GET['departmentid']))
 	$_SESSION['sWhere'].=" and inv_items.departmentid='".$_GET['departmentid']."'";
 	
 ?>
 <?php $_SESSION['sGroup']="";?>
 $(document).ready(function() {

				
 	$('#tbl').dataTable( {
		"scrollX": true,
		dom: 'lBfrtip',
		"buttons": [
		 'copy', 'csv', 'excel', 'print',{
		    extend: 'pdfHtml5',
		    orientation: 'landscape',
		    pageSize: 'LEGAL'
		}],
		"aLengthMenu": [[10, 25, 50, 100, 250, 500, 1000, 5000, 10000, 50000, 100000], [10, 25, 50, 100, 250, 500, 1000, 5000, 10000, 50000, 100000]],
 		"bJQueryUI": true,
 		"bSort":true,
 		"iDisplay":15,
 		//"sPaginationType": "full_numbers",
 		"sScrollY": 450,
		"bJQueryUI": true,
		"bRetrieve":true,
		"sAjaxSource": "../../server/server/processing.php?sTable=inv_items",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			$('td:eq(1)', nRow).html(aaData[1]);
			$('td:eq(2)', nRow).html(aaData[2]);
			$('td:eq(3)', nRow).html(aaData[16]);
			$('td:eq(4)', nRow).html(aaData[3]);
			$('td:eq(5)', nRow).html(aaData[4]);
			$('td:eq(6)', nRow).html(aaData[5]);
			$('td:eq(7)', nRow).html(aaData[12]);
			$('td:eq(8)', nRow).html(aaData[6]);
			$('td:eq(9)', nRow).html(aaData[7]);
			$('td:eq(10)', nRow).html(aaData[8]);
			$('td:eq(11)', nRow).html(aaData[9]);
			$('td:eq(12)', nRow).html(aaData[14]);
			$('td:eq(13)', nRow).html(aaData[15]);
			if(aaData[10]=="Active")
			  $('td:eq(14)', nRow).html("<a href='items.php?delid="+aaData[0]+"&status=active'>Active</a>");
			else
			  $('td:eq(14)', nRow).html("<a href='items.php?delid="+aaData[0]+"&status=inactive'>In Active</a>");
			if(aaData[10]=="Active")
			  $('td:eq(16)', nRow).html("<a href='javascript:;' onclick='showPopWin(&quot;additems_proc.php?id="+aaData[0]+"&quot;, 600, 600);'><img src='../view.png' alt='view' title='view' /></a>&nbsp;<a href='javascript:;' onclick='showPopWin(&quot;additems_proc.php?id="+aaData[0]+"&merge=1&quot;, 600, 600);'>MERGE</a>");
			else
			  $('td:eq(16)', nRow).html("");
			if(aaData[11]=="Yes")
			  $('td:eq(15)', nRow).html("<a href='javascript:;' onclick='showPopWin(&quot;../stocktrack/stocktrack.php?itemid="+aaData[0]+"&quot;, 900, 600);'>Stock Card</a>");
			else
			  $('td:eq(15)', nRow).html("");
			return nRow;
		}
 	} );
 } );
 </script>
 
<table style="clear:both;"  class="table" id="tbl" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Code </th>
			<th>Name </th>
			<th>Parent</th>
			<th>Department </th>
			<th>Category </th>
			<th>Cost Price </th>
			<th>Retail Price</th>
			<th>Size </th>
			<th>Unit Of Measure </th>
			<th>Quantity </th>
			<th>Package </th>
			<th>Cost Price(Ksh) </th>
			<th>Stock Value</th>
			<th>Status </th>
			
			
<?php
//Authorization.
$auth->roleid="705";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="706";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
	
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
