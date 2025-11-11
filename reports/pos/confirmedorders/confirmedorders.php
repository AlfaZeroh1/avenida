<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/pos/confirmedorders/Confirmedorders_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/crm/customers/Customers_class.php");
require_once("../../../modules/pos/items/Items_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/pos/sizes/Sizes_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Confirmedorders";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8731";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";

if(empty($obj->action)){
	$obj->fromorderedon=date('Y-m-d');
	$obj->toorderedon=date('Y-m-d');
}

$rptwhere='';
$rptjoin='';
$track=0;
$k=0;
$fds='';
$fd='';
$aColumns=array('1');
$sColumns=array('1');
//Processing Groupings
$rptgroup='';
$track=0;
if(!empty($obj->grorderno) or !empty($obj->grcustomerid) or !empty($obj->grorderedon) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) or !empty($obj->gritemid) ){
	$obj->shorderno='';
	$obj->shcustomerid='';
	$obj->shorderedon='';
	$obj->shremarks='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
	$obj->shitemid='';
	$obj->shquantity='';
}


	$obj->sh=1;


if(!empty($obj->grorderno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" orderno ";
	$obj->shorderno=1;
	$track++;
}

if(!empty($obj->grcustomerid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" customerid ";
	$obj->shcustomerid=1;
	$track++;
}

if(!empty($obj->grorderedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" orderedon ";
	$obj->shorderedon=1;
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

if(!empty($obj->gritemid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" itemid ";
	$obj->shitemid=1;
	$obj->shsizeid=1;
	$track++;
}

if(!empty($rptgroup)){
  $obj->shquantity=1;
}

//processing columns to show
	if(!empty($obj->shorderno)  or empty($obj->action)){
		array_push($sColumns, 'orderno');
		array_push($aColumns, "pos_confirmedorders.orderno");
		$k++;
		}

	if(!empty($obj->shcustomerid)  or empty($obj->action)){
		array_push($sColumns, 'customerid');
		array_push($aColumns, "crm_customers.name as customerid");
		$rptjoin.=" left join crm_customers on crm_customers.id=pos_confirmedorders.customerid ";
		$k++;
		}

	if(!empty($obj->shorderedon)  or empty($obj->action)){
		array_push($sColumns, 'orderedon');
		array_push($aColumns, "pos_confirmedorders.orderedon");
		$k++;
		}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "pos_confirmedorders.remarks");
		$k++;
		}
if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username as createdby");
		$rptjoin.=" left join auth_users on auth_users.id=pos_confirmedorders.createdby";
		$k++;
	}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "pos_confirmedorders.createdon");
		$k++;
		}

	if(!empty($obj->shitemid)  or empty($obj->action)){
		array_push($sColumns, 'itemid');
		array_push($aColumns, "pos_items.name itemid");
		$k++;
		$join=" left join pos_confirmedorderdetails on pos_confirmedorders.id=pos_confirmedorderdetails.confirmedorderid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join pos_items on pos_items.id=pos_confirmedorderdetails.itemid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

	if(!empty($obj->shsizeid)  or empty($obj->action)){
		$sizes=new Sizes();
		$where="  ";
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

		
		$cols="";
		while($rw=mysql_fetch_object($sizes->result)){
		
		    array_push($sColumns, $rw->name);
		    if(!empty($rptgroup))
		      array_push($aColumns, "pos_confirmedorderdetails.quantity");
		    else
		      array_push($aColumns, "sum(pos_confirmedorderdetails.quantity) '$rw->name'");
		    $k++;		    
		    
		    array_push($sColumns, 'precoolstocks'.$rw->name);
		    array_push($aColumns, "(select sum(quantity) from prod_varietystocks where varietyid in (select varietyid from pos_itemvarietys where itemid=pos_confirmedorderdetails.itemid )  and sizeid='$rw->id') 'precoolstocks$rw->name'");
		    $k++;
		    
		    array_push($sColumns, 'poststocks'.$rw->name);
		    array_push($aColumns, "(select sum(quantity) from pos_itemstocks where itemid=pos_confirmedorderdetails.itemid and sizeid='$rw->id') 'poststocks$rw->name'");
		    $k++;
		    
		    array_push($sColumns, 'variance'.$rw->name);
		    array_push($aColumns, "sum(pos_confirmedorderdetails.quantity) - ((select sum(quantity) from pos_itemstocks where itemid=pos_confirmedorderdetails.itemid and sizeid='$rw->id')+(select sum(quantity) from prod_varietystocks where varietyid in (select varietyid from pos_itemvarietys where itemid=pos_confirmedorderdetails.itemid) and sizeid='$rw->id')) 'variance$rw->name'");
		    $k++;
		 }
		 
		 $join=" left join pos_confirmedorderdetails on pos_confirmedorders.id=pos_confirmedorderdetails.confirmedorderid ";
		    if(!strpos($rptjoin,trim($join))){
			    $rptjoin.=$join;
		    }
	}
	
	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		if(!empty($rptgroup))
		   array_push($aColumns, "case when sum(pos_confirmedorderdetails.quantity)>0 then sum(pos_confirmedorderdetails.quantity) else 0 end quantity");
		else
		 array_push($aColumns, "case when pos_confirmedorderdetails.quantity>0 then pos_confirmedorderdetails.quantity else 0 end quantity");
		$k++;
		
		array_push($sColumns, 'precoolstocks');
		array_push($aColumns, "(select sum(quantity) from prod_varietystocks where varietyid in (select varietyid from pos_itemvarietys where itemid=pos_confirmedorderdetails.itemid )) precoolstocks");
		$k++;
		
		array_push($sColumns, 'poststocks');
		array_push($aColumns, "(select sum(quantity) from pos_itemstocks where itemid=pos_confirmedorderdetails.itemid) poststocks");
		$k++;
		
		array_push($sColumns, 'variance');
		array_push($aColumns, "sum(pos_confirmedorderdetails.quantity) - ((select sum(quantity) from pos_itemstocks where itemid=pos_confirmedorderdetails.itemid)+(select sum(quantity) from prod_varietystocks where varietyid in (select varietyid from pos_itemvarietys where itemid=pos_confirmedorderdetails.itemid ))) variance");
		$k++;
		
		$join=" left join pos_confirmedorderdetails on pos_confirmedorders.id=pos_confirmedorderdetails.confirmedorderid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}



$track=0;

//processing filters
if(!empty($obj->orderno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_confirmedorders.orderno='$obj->orderno'";
	$track++;
}

if(!empty($obj->customerid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_confirmedorders.customerid='$obj->customerid'";
		
	$track++;
}

if(!empty($obj->fromorderedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_confirmedorders.orderedon>='$obj->fromorderedon'";
	$track++;
}

if(!empty($obj->toorderedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_confirmedorders.orderedon<='$obj->toorderedon'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_confirmedorders.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_confirmedorders.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_confirmedorders.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->itemid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" pos_items.id='$obj->itemid' ";
	$join=" left join pos_confirmedorderdetails on pos_confirmedorders.id=pos_confirmedorderdetails.confirmedorderid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join pos_items on pos_items.id=pos_confirmedorderdetails.itemid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
}

//Processing Joins
;$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
  $("#customername").autocomplete({
	source:"../../../modules/server/server/search.php?main=crm&module=customers&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#customerid").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="pos_confirmedorders";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']="$rptgroup";?>
 
 $(document).ready(function() {
	
 	$('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
 		"sPaginationType": "full_numbers",
 		"sScrollY": 400,
 		"iDisplayLength":50,
		"bJQueryUI": true,
		"bRetrieve":true,
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=pos_confirmedorders",
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
<form  action="confirmedorders.php" method="post" name="confirmedorders" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Order No</td>
				<td><input type='text' id='orderno' size='20' name='orderno' value='<?php echo $obj->orderno;?>'></td>
			</tr>
			<tr>
				<td>Customer</td>
				<td><input type='text' size='20' name='customername' id='customername' value='<?php echo $obj->customername; ?>'>
					<input type="hidden" name='customerid' id='customerid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Ordered On</td>
				<td><strong>From:</strong><input type='text' id='fromorderedon' size='12' name='fromorderedon' readonly class="date_input" value='<?php echo $obj->fromorderedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='toorderedon' size='12' name='toorderedon' readonly class="date_input" value='<?php echo $obj->toorderedon;?>'/></td>
			</tr>
			<tr>
				<td>Created By</td>
			<td>
			<select name='createdby' class='selectbox'>
				<option value=''>Select...</option>
				<?php
				$users = new Users();
				$fields="auth_users.id, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeeid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeename";
				$where=" where auth_users.id in(select createdby from pos_confirmedorders) ";
				$join=" left join hrm_employees on hrm_employees.id=auth_users.employeeid ";
				$having="";
				$groupby="";
				$orderby=" order by employeename ";
				$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);
				while($rw=mysql_fetch_object($users->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->createdby==$rw->id){echo "selected";}?>><?php echo $rw->employeeid;?></option>
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
			<tr>
				<td>item</td>
				<td>
				<select name='itemid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$items=new Items();
				$where="  ";
				$fields="pos_items.id, pos_items.code, pos_items.name, pos_items.departmentid, pos_items.categoryid, pos_items.sizeid, pos_items.price, pos_items.tax, pos_items.stock, pos_items.itemstatusid, pos_items.remarks, pos_items.createdby, pos_items.createdon, pos_items.lasteditedby, pos_items.lasteditedon, pos_items.ipaddress";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($items->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->itemid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grorderno' value='1' <?php if(isset($_POST['grorderno']) ){echo"checked";}?>>&nbsp;Order No</td>
				<td><input type='checkbox' name='grcustomerid' value='1' <?php if(isset($_POST['grcustomerid']) ){echo"checked";}?>>&nbsp;Customer</td>
			<tr>
				<td><input type='checkbox' name='grorderedon' value='1' <?php if(isset($_POST['grorderedon']) ){echo"checked";}?>>&nbsp;Ordered On</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='gritemid' value='1' <?php if(isset($_POST['gritemid']) ){echo"checked";}?>>&nbsp;item</td>
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
				<td><input type='checkbox' name='shorderno' value='1' <?php if(isset($_POST['shorderno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Order No</td>
				<td><input type='checkbox' name='shcustomerid' value='1' <?php if(isset($_POST['shcustomerid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Customer</td>
			<tr>
				<td><input type='checkbox' name='shorderedon' value='1' <?php if(isset($_POST['shorderedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Ordered On</td>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='shitemid' value='1' <?php if(isset($_POST['shitemid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Product</td>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
		</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" align='center'><input type="submit" class="btn" name="action" id="action" value="Filter" /></td>
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
			<?php if($obj->shorderno==1  or empty($obj->action)){ ?>
				<th>Order No </th>
			<?php } ?>
			<?php if($obj->shcustomerid==1  or empty($obj->action)){ ?>
				<th>Customer </th>
			<?php } ?>
			<?php if($obj->shorderedon==1  or empty($obj->action)){ ?>
				<th>Date Ordered </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1 or empty($obj->action)){ ?>
				<th>Created By</th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>Created On</th>
			<?php } ?>
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>Product</th>
			<?php } ?>
			<?php
			if($obj->shsizeid==1  or empty($obj->action)){
			$sizes=new Sizes();
			$where="  ";
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

			while($rw=mysql_fetch_object($sizes->result)){
			      
			?>
				<th><?php echo $rw->name; ?></th>
				<th><?php echo $rw->name; ?>(PC)</th>
				<th><?php echo $rw->name; ?>(CS)</th>
				<th>Variance</th>
			<?php }} ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Quantity</th>
				<th>Pre Cool Stocks</th>
				<th>Cold Store Stocks</th>
				<th>Variance</th>
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
