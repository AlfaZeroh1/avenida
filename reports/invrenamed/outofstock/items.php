<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/inv/items/Items_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/inv/departments/Departments_class.php");
require_once("../../../modules/inv/departmentcategorys/Departmentcategorys_class.php");
require_once("../../../modules/inv/categorys/Categorys_class.php");
require_once("../../../modules/sys/vatclasses/Vatclasses_class.php");
require_once("../../../modules/fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../../modules/fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Items";
//connect to db
$db=new DB();

$obj=(object)$_POST;

include "../../../head.php";

$rptwhere='';
$rptjoin='';
$track=0;
$fds='';
$fd='';
$aColumns=array('1');
$sColumns=array('1');
//processing columns to show
	if(!empty($obj->shcode) ){
		array_push($sColumns, 'code');
		array_push($aColumns, "inv_items.code");
	}

	if(!empty($obj->shname)  or empty($obj->action)){
		array_push($sColumns, 'name');
		array_push($aColumns, "inv_items.name");
	}

	if(!empty($obj->shdepartmentid)  or empty($obj->action)){
		array_push($sColumns, 'departmentid');
		array_push($aColumns, "inv_departments.name as departmentid");
		$rptjoin.=" left join inv_departments on inv_departments.id=inv_items.departmentid ";
	}

	if(!empty($obj->shdepartmentcategoryid) ){
		array_push($sColumns, 'departmentcategoryid');
		array_push($aColumns, "inv_departmentcategorys.name as departmentcategoryid");
		$rptjoin.=" left join inv_departmentcategorys on inv_departmentcategorys.id=inv_items.departmentcategoryid ";
	}

	if(!empty($obj->shcategoryid) ){
		array_push($sColumns, 'categoryid');
		array_push($aColumns, "inv_categorys.name as categoryid");
		$rptjoin.=" left join inv_categorys on inv_categorys.id=inv_items.categoryid ";
	}

	if(!empty($obj->shmanufacturer) ){
		array_push($sColumns, 'manufacturer');
		array_push($aColumns, "inv_items.manufacturer");
	}

	if(!empty($obj->shstrength) ){
		array_push($sColumns, 'strength');
		array_push($aColumns, "inv_items.strength");
	}

	if(!empty($obj->shcostprice)  or empty($obj->action)){
		array_push($sColumns, 'costprice');
		array_push($aColumns, "inv_items.costprice");
	}

	if(!empty($obj->shtradeprice)  or empty($obj->action)){
		array_push($sColumns, 'tradeprice');
		array_push($aColumns, "inv_items.tradeprice");
	}

	if(!empty($obj->shretailprice)  or empty($obj->action)){
		array_push($sColumns, 'retailprice');
		array_push($aColumns, "inv_items.retailprice");
	}

	if(!empty($obj->shsize) ){
		array_push($sColumns, 'size');
		array_push($aColumns, "inv_items.size");
	}

	if(!empty($obj->shunitofmeasureid) ){
		array_push($sColumns, 'unitofmeasureid');
		array_push($aColumns, "inv_items.unitofmeasureid");
	}

	if(!empty($obj->shvatclasseid)  or empty($obj->action)){
		array_push($sColumns, 'vatclasseid');
		array_push($aColumns, "sys_vatclasses.name as vatclasseid");
		$rptjoin.=" left join sys_vatclasses on sys_vatclasses.id=inv_items.vatclasseid ";
	}

	if(!empty($obj->shgeneraljournalaccountid) ){
		array_push($sColumns, 'generaljournalaccountid');
		array_push($aColumns, "inv_items.generaljournalaccountid");
		//$rptjoin.=" left join fn_generaljournalaccounts on fn_generaljournalaccounts.id=inv_items.generaljournalaccountid ";
	}

	if(!empty($obj->shgeneraljournalaccountid2) ){
		array_push($sColumns, 'generaljournalaccountid2');
		array_push($aColumns, "inv_items.generaljournalaccountid2");
		//$rptjoin.=" left join fn_generaljournalaccounts on fn_generaljournalaccounts.id=inv_items.generaljournalaccountid2 ";
	}

	if(!empty($obj->shdiscount) ){
		array_push($sColumns, 'discount');
		array_push($aColumns, "inv_items.discount");
	}

	if(!empty($obj->shreorderlevel) ){
		array_push($sColumns, 'reorderlevel');
		array_push($aColumns, "inv_items.reorderlevel");
	}

	if(!empty($obj->shreorderquantity) ){
		array_push($sColumns, 'reorderquantity');
		array_push($aColumns, "inv_items.reorderquantity");
	}

	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		array_push($aColumns, "inv_items.quantity");
	}

	if(!empty($obj->shreducing) ){
		array_push($sColumns, 'reducing');
		array_push($aColumns, "inv_items.reducing");
	}

	if(!empty($obj->shstatus) ){
		array_push($sColumns, 'status');
		array_push($aColumns, "inv_items.status");
	}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username createdby");
		$rptjoin.="left join auth_users on auth_users.id=inv_items.createdby";
	}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "inv_items.createdon");
	}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "inv_items.ipaddress");
	}



$rptwhere=" inv_items.quantity<=0 ";
$track++;
if($obj->action=='Filter'){
//processing filters
if(!empty($obj->code)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_items.code='$obj->code'";
	$track++;
}

if(!empty($obj->name)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_items.name='$obj->name'";
	$track++;
}

if(!empty($obj->departmentid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_items.departmentid='$obj->departmentid'";
	$track++;
}

if(!empty($obj->departmentcategoryid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_items.departmentcategoryid='$obj->departmentcategoryid'";
	$track++;
}

if(!empty($obj->categoryid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_items.categoryid='$obj->categoryid'";
	$track++;
}

if(!empty($obj->manufacturer)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_items.manufacturer='$obj->manufacturer'";
	$track++;
}

if(!empty($obj->vatclasseid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_items.vatclasseid='$obj->vatclasseid'";
	$track++;
}

if(!empty($obj->generaljournalaccountid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_items.generaljournalaccountid='$obj->generaljournalaccountid'";
	$track++;
}

if(!empty($obj->generaljournalaccountid2)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_items.generaljournalaccountid2='$obj->generaljournalaccountid2'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_items.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_items.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_items.createdon<='$obj->tocreatedon'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
if(!empty($obj->grname)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" name ";
	$obj->shname=1;
	$track++;
}

if(!empty($obj->grdepartmentid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" departmentid ";
	$obj->shdepartmentid=1;
	$track++;
}

if(!empty($obj->grdepartmentcategoryid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" departmentcategoryid ";
	$obj->shdepartmentcategoryid=1;
	$track++;
}

if(!empty($obj->grcategoryid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" categoryid ";
	$obj->shcategoryid=1;
	$track++;
}

if(!empty($obj->grgeneraljournalaccountid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" generaljournalaccountid ";
	$obj->shgeneraljournalaccountid=1;
	$track++;
}

if(!empty($obj->grgeneraljournalaccountid2)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" generaljournalaccountid2 ";
	$obj->shgeneraljournalaccountid2=1;
	$track++;
}

if(!empty($obj->grcreatedby)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" createdby ";
	$obj->shcreatedby=1;
	$track++;
}

if(!empty($obj->grcreatedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" createdon ";
	$obj->shcreatedon=1;
	$track++;
}

//Processing Joins
;$rptgroup='';
$track=0;
}
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="inv_items";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']="$rptgroup";?>
 
 $(document).ready(function() {
	
 	$('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
 		"bJQueryUI": true,
 		"bSort":true,
 		"sPaginationType": "full_numbers",
 		"sScrollY": 400,
 		"iDisplayLength":50,
		"bJQueryUI": true,
		"bRetrieve":true,
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=inv_items",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			var num = aaData.length;
			for(var i=1; i<num; i++){
				$('td:eq('+i+')', nRow).html(aaData[i]);
			}
			return nRow;
		},
 	} );
 } );
 </script>

<div id="main">
<div id="main-inner">
<div id="content">
<div id="content-inner">
<div id="content-header">
	<div class="page-title"><?php echo $page_title; ?></div>
	<div class="clearb"></div>
</div>
<div id="content-flex">
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Filter</button>&nbsp;<?php if(!empty($rptgroup)){?><a class="btn btn-warning" target="_blank" href="../../graphs/graphs/bars.php">Bar Graph</a><?php } ?>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Filter</h4>
      </div>
      <div class="modal-body">
<form  action="items.php" method="post" name="items" class=''>
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Code</td>
				<td><input type='text' id='code' size='20' name='code' value='<?php echo $obj->code;?>'></td>
			</tr>
			<tr>
				<td>Name</td>
				<td><input type='text' id='name' size='20' name='name' value='<?php echo $obj->name;?>'></td>
			</tr>
			<tr>
				<td>Department</td>
				<td>
				<select name='departmentid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$departments=new Departments();
				$where="  ";
				$fields="inv_departments.id, inv_departments.name, inv_departments.code, inv_departments.remarks, inv_departments.createdby, inv_departments.createdon, inv_departments.lasteditedby, inv_departments.lasteditedon, inv_departments.ipaddress";
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
			</tr>
			<tr>
				<td>Dept Category</td>
				<td>
				<select name='departmentcategoryid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$departmentcategorys=new Departmentcategorys();
				$where="  ";
				$fields="inv_departmentcategorys.id, inv_departmentcategorys.departmentid, inv_departmentcategorys.name, inv_departmentcategorys.remarks, inv_departmentcategorys.createdby, inv_departmentcategorys.createdon, inv_departmentcategorys.lasteditedby, inv_departmentcategorys.lasteditedon, inv_departmentcategorys.ipaddress";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$departmentcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($departmentcategorys->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->departmentcategoryid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Category</td>
				<td>
				<select name='categoryid' class='selectbox'>
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
			</tr>
			<tr>
				<td>Manufacturer</td>
				<td><input type='text' id='manufacturer' size='20' name='manufacturer' value='<?php echo $obj->manufacturer;?>'></td>
			</tr>
			<tr>
				<td>VAT Class</td>
				<td>
				<select name='vatclasseid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$vatclasses=new Vatclasses();
				$where="  ";
				$fields="sys_vatclasses.id, sys_vatclasses.name, sys_vatclasses.perc";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$vatclasses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($vatclasses->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->vatclasseid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Journal Acc on Sale</td>
				<td>
				<select name='generaljournalaccountid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$generaljournalaccounts=new Generaljournalaccounts();
				$where="  ";
				$fields="fn_generaljournalaccounts.id, fn_generaljournalaccounts.refid, fn_generaljournalaccounts.name, fn_generaljournalaccounts.acctypeid, fn_generaljournalaccounts.categoryid, fn_generaljournalaccounts.debit, fn_generaljournalaccounts.credit, fn_generaljournalaccounts.createdby, fn_generaljournalaccounts.createdon, fn_generaljournalaccounts.lasteditedby, fn_generaljournalaccounts.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$generaljournalaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($generaljournalaccounts->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->generaljournalaccountid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Cost of Sale Journal Acc	</td>
				<td>
				<select name='generaljournalaccountid2' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$generaljournalaccounts=new Generaljournalaccounts();
				$where="  ";
				$fields="fn_generaljournalaccounts.id, fn_generaljournalaccounts.refid, fn_generaljournalaccounts.name, fn_generaljournalaccounts.acctypeid, fn_generaljournalaccounts.categoryid, fn_generaljournalaccounts.debit, fn_generaljournalaccounts.credit, fn_generaljournalaccounts.createdby, fn_generaljournalaccounts.createdon, fn_generaljournalaccounts.lasteditedby, fn_generaljournalaccounts.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$generaljournalaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($generaljournalaccounts->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->generaljournalaccountid2==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Created By</td>
			<td>
			<select name='createdby' class='selectbox'>
				<option value=''>Select...</option>
				<?php
				$users = new Users();
				$fields="*";
				$where="";
				$join=" left join  ";
				$having="";
				$groupby="";
				$orderby="";
				$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($users->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->createdby==$rw->id){echo "selected";}?>><?php echo $rw->username;?></option>
				<?php
				}
				?>
			</td>
			</tr>
			<tr>
				<td>Created On</td>
				<td><strong>From:</strong><input type='text' id='fromcreatedon' size='12' name='fromcreatedon' readonly class="date_input" value='<?php echo $obj->fromcreatedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='tocreatedon' size='12' name='tocreatedon' readonly class="date_input" value='<?php echo $obj->tocreatedon;?>'/></td>
			</tr>
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grname' value='1' <?php if(isset($_POST['grname']) ){echo"checked";}?>>&nbsp;Name</td>
				<td><input type='checkbox' name='grdepartmentid' value='1' <?php if(isset($_POST['grdepartmentid']) ){echo"checked";}?>>&nbsp;Department</td>
			<tr>
				<td><input type='checkbox' name='grdepartmentcategoryid' value='1' <?php if(isset($_POST['grdepartmentcategoryid']) ){echo"checked";}?>>&nbsp;Dept Category</td>
				<td><input type='checkbox' name='grcategoryid' value='1' <?php if(isset($_POST['grcategoryid']) ){echo"checked";}?>>&nbsp;Category</td>
			<tr>
				<td><input type='checkbox' name='grgeneraljournalaccountid' value='1' <?php if(isset($_POST['grgeneraljournalaccountid']) ){echo"checked";}?>>&nbsp;ournal Acc on Sale</td>
				<td><input type='checkbox' name='grgeneraljournalaccountid2' value='1' <?php if(isset($_POST['grgeneraljournalaccountid2']) ){echo"checked";}?>>&nbsp;Cost of Sale Journal Acc	</td>
			<tr>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
		</table>
		</td>
		</tr>
		<tr>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
				<th colspan="3"><div align="left"><strong>Fields to Show (For Detailed Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='shcode' value='1' <?php if(isset($_POST['shcode']) ){echo"checked";}?>>&nbsp;Code</td>
				<td><input type='checkbox' name='shname' value='1' <?php if(isset($_POST['shname'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Name</td>
			<tr>
				<td><input type='checkbox' name='shdepartmentid' value='1' <?php if(isset($_POST['shdepartmentid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Department</td>
				<td><input type='checkbox' name='shdepartmentcategoryid' value='1' <?php if(isset($_POST['shdepartmentcategoryid']) ){echo"checked";}?>>&nbsp;Dept Category</td>
			<tr>
				<td><input type='checkbox' name='shcategoryid' value='1' <?php if(isset($_POST['shcategoryid']) ){echo"checked";}?>>&nbsp;Category</td>
				<td><input type='checkbox' name='shmanufacturer' value='1' <?php if(isset($_POST['shmanufacturer']) ){echo"checked";}?>>&nbsp;Manufacturer</td>
			<tr>
				<td><input type='checkbox' name='shstrength' value='1' <?php if(isset($_POST['shstrength']) ){echo"checked";}?>>&nbsp;Strenth</td>
				<td><input type='checkbox' name='shcostprice' value='1' <?php if(isset($_POST['shcostprice'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Cost Price</td>
			<tr>
				<td><input type='checkbox' name='shtradeprice' value='1' <?php if(isset($_POST['shtradeprice'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Trade Price</td>
				<td><input type='checkbox' name='shretailprice' value='1' <?php if(isset($_POST['shretailprice'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Retail Price</td>
			<tr>
				<td><input type='checkbox' name='shsize' value='1' <?php if(isset($_POST['shsize']) ){echo"checked";}?>>&nbsp;Size</td>
				<td><input type='checkbox' name='shunitofmeasureid' value='1' <?php if(isset($_POST['shunitofmeasureid']) ){echo"checked";}?>>&nbsp;Units of Measure</td>
			<tr>
				<td><input type='checkbox' name='shvatclasseid' value='1' <?php if(isset($_POST['shvatclasseid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;VAT Class</td>
				<td><input type='checkbox' name='shgeneraljournalaccountid' value='1' <?php if(isset($_POST['shgeneraljournalaccountid']) ){echo"checked";}?>>&nbsp;Journal Acc on Sale</td>
			<tr>
				<td><input type='checkbox' name='shgeneraljournalaccountid2' value='1' <?php if(isset($_POST['shgeneraljournalaccountid2']) ){echo"checked";}?>>&nbsp;Cost of Sale Journal Acc	</td>
				<td><input type='checkbox' name='shdiscount' value='1' <?php if(isset($_POST['shdiscount']) ){echo"checked";}?>>&nbsp;Discount</td>
			<tr>
				<td><input type='checkbox' name='shreorderlevel' value='1' <?php if(isset($_POST['shreorderlevel']) ){echo"checked";}?>>&nbsp;Reorder Level</td>
				<td><input type='checkbox' name='shreorderquantity' value='1' <?php if(isset($_POST['shreorderquantity']) ){echo"checked";}?>>&nbsp;Reorder Quantity</td>
			<tr>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
				<td><input type='checkbox' name='shreducing' value='1' <?php if(isset($_POST['shreducing']) ){echo"checked";}?>>&nbsp;Reducing Stock</td>
			<tr>
				<td><input type='checkbox' name='shstatus' value='1' <?php if(isset($_POST['shstatus']) ){echo"checked";}?>>&nbsp;Status</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;IP Address</td>
		</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" align='center'><input type="submit" name="action" id="action" value="Filter" /></td>
	</tr>
</table>
</form>
</div>
</div>
</div>
</div>
<table style="clear:both;"  class="table" id="tbl" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<?php if($obj->shcode==1 ){ ?>
				<th>Code </th>
			<?php } ?>
			<?php if($obj->shname==1  or empty($obj->action)){ ?>
				<th>Name </th>
			<?php } ?>
			<?php if($obj->shdepartmentid==1  or empty($obj->action)){ ?>
				<th>Department </th>
			<?php } ?>
			<?php if($obj->shdepartmentcategoryid==1 ){ ?>
				<th>Dept Category </th>
			<?php } ?>
			<?php if($obj->shcategoryid==1 ){ ?>
				<th>Categoryid </th>
			<?php } ?>
			<?php if($obj->shmanufacturer==1 ){ ?>
				<th>Manufacturer </th>
			<?php } ?>
			<?php if($obj->shstrength==1 ){ ?>
				<th>Strength </th>
			<?php } ?>
			<?php if($obj->shcostprice==1  or empty($obj->action)){ ?>
				<th>Cost Price </th>
			<?php } ?>
			<?php if($obj->shtradeprice==1  or empty($obj->action)){ ?>
				<th>Trade Price </th>
			<?php } ?>
			<?php if($obj->shretailprice==1  or empty($obj->action)){ ?>
				<th>Retail Price </th>
			<?php } ?>
			<?php if($obj->shsize==1 ){ ?>
				<th>Size </th>
			<?php } ?>
			<?php if($obj->shunitofmeasureid==1 ){ ?>
				<th>Unit Of Measure </th>
			<?php } ?>
			<?php if($obj->shvatclasseid==1  or empty($obj->action)){ ?>
				<th>VAT Class </th>
			<?php } ?>
			<?php if($obj->shgeneraljournalaccountid==1){ ?>
				<th>Journal Acc On Sale </th>
			<?php } ?>
			<?php if($obj->shgeneraljournalaccountid2==1){ ?>
				<th>Cost Of Sale Journal Acc </th>
			<?php } ?>
			<?php if($obj->shdiscount==1 ){ ?>
				<th>Discount </th>
			<?php } ?>
			<?php if($obj->shreorderlevel==1 ){ ?>
				<th>Reorder Level </th>
			<?php } ?>
			<?php if($obj->shreorderquantity==1 ){ ?>
				<th>Reorder Quantity </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Quantity </th>
			<?php } ?>
			<?php if($obj->shreducing==1 ){ ?>
				<th>Reducing Stock </th>
			<?php } ?>
			<?php if($obj->shstatus==1 ){ ?>
				<th>Status </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>Created By </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>Created On </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>Ip Address </th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
	</tbody>
</div>
</div>
</div>
</div>
</div>
