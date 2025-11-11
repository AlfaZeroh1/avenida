<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/pos/itemstocks/Itemstocks_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/pos/items/Items_class.php");
require_once("../../../modules/pos/sizes/Sizes_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Itemstocks";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="9125";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";

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
$rpthaving="";
$track=0;

if(empty($obj->action) or (empty($obj->gritemid) and empty($obj->grsizeid))){
  $obj->gritemid=1;
  $obj->grdatecode=1;
}

if(!empty($obj->gritemid) or !empty($obj->grsizeid) ){
	$obj->shitemid='';
	$obj->shquantity='';
	$obj->shsizeid='';
}


	$obj->shquantity=1;
	$obj->shsizeid=1;

if(!empty($obj->outofstock) and $obj->outofstock==1){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" itemid ";
	$rpthaving=" having quantity<=0 ";
	$obj->shitemid=1;
	$track++;
}

if(!empty($obj->outofstock) and $obj->outofstock==2){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" itemid ";
	$rpthaving=" having quantity>0 ";
	$obj->shitemid=1;
	$track++;
}


if(!empty($obj->gritemid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" itemid ";
	$obj->shitemid=1;
	$track++;
}
if(!empty($obj->grdatecode)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" datecode ";
	$obj->shdatecode=1;
	$track++;
}

if(!empty($obj->grsizeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" sizeid ";
	$obj->shsizeid=1;
	$track++;
}

//processing columns to show
	if(!empty($obj->shitemid)  or empty($obj->action)){
		array_push($sColumns, 'itemid');
		array_push($aColumns, "pos_items.name as itemid");
		$rptjoin.=" left join pos_items on pos_items.id=pos_itemstocks.itemid ";
		$k++;
		
		$mnt = ($k+1);
		}
		
	if(!empty($obj->shdatecode)  or empty($obj->action)){
		array_push($sColumns, 'datecode');
		array_push($aColumns, "pos_itemstocks.datecode as datecode");
		$k++;
		
		$mnt = ($k+1);
		}
/*
	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		if(!empty($rptgroup)){
			array_push($aColumns, "sum(pos_itemstocks.quantity) quantity");
		}else{
		array_push($aColumns, "pos_itemstocks.quantity");
		}

		$k++;
		}*/
/*
	if(!empty($obj->shsizeid)  or empty($obj->action)){
		array_push($sColumns, 'sizeid');
		array_push($aColumns, "pos_itemstocks.sizeid");
		$k++;
		}
*/


$track=0;

//processing filters
if(!empty($obj->itemid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_itemstocks.itemid='$obj->itemid'";
		$join=" left join pos_items on pos_itemstocks.id=pos_items.itemstockid ";
		
	$track++;
}

if(!empty($obj->fromrecordedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_itemstocks.createdon>='$obj->fromrecordedon'";
	$track++;
}

if(!empty($obj->torecordedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_itemstocks.createdon<='$obj->torecordedon'";
	$track++;
}

if(!empty($obj->sizeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_itemstocks.sizeid='$obj->sizeid'";
		
	$track++;
}

//Processing Joins
;$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
  $("#itemname").autocomplete({
	source:"../../../modules/server/server/search.php?main=pos&module=items&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#itemid").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript" charset="utf-8">
<?php
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
    $cols=" case when sum(case when sizeid=$rw->id then case when pos_itemstocks.transaction='In' or pos_itemstocks.transaction='Returns' then pos_itemstocks.quantity else (pos_itemstocks.quantity) end end) is null then '' else sum(case when sizeid=$rw->id then case when pos_itemstocks.transaction='In' or pos_itemstocks.transaction='Returns' then pos_itemstocks.quantity else (pos_itemstocks.quantity) end end) end '$rw->name'";
    array_push($aColumns, $cols);
    array_push($sColumns, $rw->name);
    
    $k++;
  }
  
  if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		array_push($aColumns, "sum(case when pos_itemstocks.transaction='In' or pos_itemstocks.transaction='Returns' then pos_itemstocks.quantity else (pos_itemstocks.quantity) end) quantity");
		$k++;
		}
?>
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="pos_itemstocks";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']="$rptgroup $rpthaving";?>
 
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=pos_itemstocks",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			var num = aaData.length;
			for(var i=1; i<num; i++){
				$('td:eq('+i+')', nRow).html(aaData[i]);
			}
			return nRow;
		},
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
			$('th:eq(0)', nRow).html("");
			$('th:eq(1)', nRow).html("TOTAL");
			var total=[];
			//var k=0;
			for(var i=0; i<aaData.length; i++){
			  //var k = aaData[i].length;
			  
			  for(var j=<?php echo $mnt; ?>; j<aaData[i].length; j++){
			    if(aaData[i][j]=='' || aaData[1]==null)
			      aaData[i][j]=0;			      
			      
			      if(i==0)
				total[j]=0;
				
				total[j] = parseFloat(total[j])+parseFloat(aaData[i][j]);	//alert(parseFloat(aaData[i][j]));	
			  }
			  
			}
			
			for(var i=<?php echo $mnt; ?>; i<total.length;i++){
			  $('th:eq('+i+')', nRow).html(total[i]);
			}
		}
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
<form  action="itemstocks.php" method="post" name="itemstocks" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Product</td>
				<td><input type='text' size='20' name='itemname' id='itemname' value='<?php echo $obj->itemname; ?>'>
					<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Recorded on </td>
				<td><strong>From:</strong><input type='text' id='fromrecordedon' size='20' name='fromrecordedon' readonly class="form_datetime" value='<?php echo $obj->fromrecordedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='torecordedon' size='20' name='torecordedon' readonly class="form_datetime" value='<?php echo $obj->torecordedon;?>'/></td>
			</tr>
			<tr>
				<td>Size </td>
				<td>
				<select name='sizeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$sizes=new Sizes();
				$where="  ";
				$fields="pos_sizes.id, pos_sizes.name, pos_sizes.remarks, pos_sizes.ipaddress, pos_sizes.createdby, pos_sizes.createdon, pos_sizes.lasteditedby, pos_sizes.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($sizes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->sizeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
			<td>&nbsp;</td>
			<td><input type='radio' name='outofstock' value='1' <?php if(isset($_POST['outofstock']) and  $_POST['outofstock']==1){echo"checked";}?>>&nbsp;Out of Stock</td>
			</tr>
			<tr>
			<td>&nbsp;</td>
			<td><input type='radio' name='outofstock' value='2' <?php if(isset($_POST['outofstock']) and  $_POST['outofstock']==2){echo"checked";}?>>&nbsp;In Stock</td>
			</tr>
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='gritemid' value='1' <?php if(isset($_POST['gritemid']) ){echo"checked";}?>>&nbsp;Product</td>
				<td><input type='checkbox' name='grsizeid' value='1' <?php if(isset($_POST['grsizeid']) ){echo"checked";}?>>&nbsp;Size </td>
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
				<td><input type='checkbox' name='shitemid' value='1' <?php if(isset($_POST['shitemid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Product</td>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
			<tr>
				<td><input type='checkbox' name='shsizeid' value='1' <?php if(isset($_POST['shsizeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Size </td>
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

			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>Product </th>
			<?php } ?>
			<?php if($obj->shdatecode==1  or empty($obj->action)){ ?>
				<th>Datecode</th>
			<?php } ?>
			<?php if($obj->shsizeid==1){ 
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
			<?php }} ?>
			<?php if($obj->shquantity==1){ ?>
				<th>Total </th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
	<tfoot>
	<tr>
	<th>#</th>

			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shdatecode==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shsizeid==1){ 
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
			<?php }} ?>
			<?php if($obj->shquantity==1){ ?>
				<th>&nbsp;</th>
			<?php } ?>
	</tr>
	</tfoot>
	</tbody>
	<script type="text/javascript">
	    $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii:ss'});
	</script>
</div>
</div>
</div>
</div>
</div>
