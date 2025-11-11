<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/post/harvestrejects/Harvestrejects_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/prod/rejecttypes/Rejecttypes_class.php");
require_once("../../../modules/prod/sizes/Sizes_class.php");
require_once("../../../modules/pos/items/Items_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Harvestrejects";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="9055";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";

if(empty($obj->action)){
	$obj->fromgradedon=date('Y-m-d');
	$obj->togradedon=date('Y-m-d');
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
if(!empty($obj->grrejecttypeid) or !empty($obj->grsizeid) or !empty($obj->gritemid) or !empty($obj->grgradedon) or !empty($obj->grreportedon) or !empty($obj->gremployeeid) or !empty($obj->grstatus) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) ){
	$obj->shrejecttypeid='';
	$obj->shsizeid='';
	$obj->shitemid='';
	$obj->shquantity='';
	$obj->shgradedon='';
	$obj->shreportedon='';
	$obj->shemployeeid='';
	$obj->shremarks='';
	$obj->shstatus='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
	$obj->shipaddress='';
}


	$obj->sh=1;


if(!empty($obj->grrejecttypeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" rejecttypeid ";
	$obj->shrejecttypeid=1;
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

if(!empty($obj->gritemid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" itemid ";
	$obj->shitemid=1;
	$track++;
}

if(!empty($obj->grgradedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" gradedon ";
	$obj->shgradedon=1;
	$track++;
}

if(!empty($obj->grreportedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" reportedon ";
	$obj->shreportedon=1;
	$track++;
}

if(!empty($obj->gremployeeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" employeeid ";
	$obj->shemployeeid=1;
	$track++;
}

if(!empty($obj->grstatus)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" status ";
	$obj->shstatus=1;
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

//processing columns to show
	if(!empty($obj->shrejecttypeid)  or empty($obj->action)){
		array_push($sColumns, 'rejecttypeid');
		array_push($aColumns, "prod_rejecttypes.name as rejecttypeid");
		$rptjoin.=" left join prod_rejecttypes on prod_rejecttypes.id=post_harvestrejects.rejecttypeid ";
		$k++;
		}

	if(!empty($obj->shsizeid)  or empty($obj->action)){
		array_push($sColumns, 'sizeid');
		array_push($aColumns, "prod_sizes.name as sizeid");
		$rptjoin.=" left join prod_sizes on prod_sizes.id=post_harvestrejects.sizeid ";
		$k++;
		}

	if(!empty($obj->shitemid)  or empty($obj->action)){
		array_push($sColumns, 'itemid');
		array_push($aColumns, "pos_items.name as itemid");
		$rptjoin.=" left join pos_items on pos_items.id=post_harvestrejects.itemid ";
		$k++;
		}

	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		array_push($aColumns, "post_harvestrejects.quantity");
		$k++;
		}

	if(!empty($obj->shgradedon)  or empty($obj->action)){
		array_push($sColumns, 'gradedon');
		array_push($aColumns, "post_harvestrejects.gradedon");
		$k++;
		}

	if(!empty($obj->shreportedon)  or empty($obj->action)){
		array_push($sColumns, 'reportedon');
		array_push($aColumns, "post_harvestrejects.reportedon");
		$k++;
		}

	if(!empty($obj->shemployeeid) ){
		array_push($sColumns, 'employeeid');
		array_push($aColumns, "concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid");
		$rptjoin.=" left join hrm_employees on hrm_employees.id=post_harvestrejects.employeeid ";
		$k++;
		}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "post_harvestrejects.remarks");
		$k++;
		}

	if(!empty($obj->shstatus) ){
		array_push($sColumns, 'status');
		array_push($aColumns, "post_harvestrejects.status");
		$k++;
		}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "post_harvestrejects.createdby");
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "post_harvestrejects.createdon");
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "post_harvestrejects.ipaddress");
		$k++;
		}



$track=0;

//processing filters
if(!empty($obj->rejecttypeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" post_harvestrejects.rejecttypeid='$obj->rejecttypeid'";
		
	$track++;
}

if(!empty($obj->reduce)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" post_harvestrejects.reduce='$obj->reduce'";
		
	$track++;
}

if(!empty($obj->sizeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" post_harvestrejects.sizeid='$obj->sizeid'";
		
	$track++;
}

if(!empty($obj->itemid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" post_harvestrejects.itemid='$obj->itemid'";
		$join=" left join pos_items on post_harvestrejects.id=pos_items.harvestrejectid ";
		
	$track++;
}

if(!empty($obj->fromgradedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" post_harvestrejects.gradedon>='$obj->fromgradedon'";
	$track++;
}

if(!empty($obj->togradedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" post_harvestrejects.gradedon<='$obj->togradedon'";
	$track++;
}

if(!empty($obj->fromreportedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" post_harvestrejects.reportedon>='$obj->fromreportedon'";
	$track++;
}

if(!empty($obj->toreportedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" post_harvestrejects.reportedon<='$obj->toreportedon'";
	$track++;
}

if(!empty($obj->employeeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" post_harvestrejects.employeeid='$obj->employeeid'";
		$join=" left join hrm_employees on post_harvestrejects.id=hrm_employees.harvestrejectid ";
		
	$track++;
}

if(!empty($obj->status)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" post_harvestrejects.status='$obj->status'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" post_harvestrejects.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" post_harvestrejects.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" post_harvestrejects.createdon<='$obj->tocreatedon'";
	$track++;
}

//Processing Joins
;$track=0;
//Default shows
if(!empty($obj->shemployeeid)){
	$fd.=" ,concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) ";
}
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

  $("#employeename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#employeeid").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="post_harvestrejects";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=post_harvestrejects",
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
<form  action="harvestrejects.php" method="post" name="harvestrejects" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Reject Type</td>
				<td>
				<select name='rejecttypeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$rejecttypes=new Rejecttypes();
				$where="  ";
				$fields="prod_rejecttypes.id, prod_rejecttypes.name, prod_rejecttypes.remarks, prod_rejecttypes.ipaddress, prod_rejecttypes.createdby, prod_rejecttypes.createdon, prod_rejecttypes.lasteditedby, prod_rejecttypes.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$rejecttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($rejecttypes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->rejecttypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Size </td>
				<td>
				<select name='sizeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$sizes=new Sizes();
				$where="  ";
				$fields="prod_sizes.id, prod_sizes.name, prod_sizes.remarks, prod_sizes.ipaddress, prod_sizes.createdby, prod_sizes.createdon, prod_sizes.lasteditedby, prod_sizes.lasteditedon";
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
				<td>Item</td>
				<td><input type='text' size='20' name='itemname' id='itemname' value='<?php echo $obj->itemname; ?>'>
					<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Graded on</td>
				<td><strong>From:</strong><input type='text' id='fromgradedon' size='12' name='fromgradedon' readonly class="date_input" value='<?php echo $obj->fromgradedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='togradedon' size='12' name='togradedon' readonly class="date_input" value='<?php echo $obj->togradedon;?>'/></td>
			</tr>
			<tr>
				<td>Reported on</td>
				<td><strong>From:</strong><input type='text' id='fromreportedon' size='12' name='fromreportedon' readonly class="date_input" value='<?php echo $obj->fromreportedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='toreportedon' size='12' name='toreportedon' readonly class="date_input" value='<?php echo $obj->toreportedon;?>'/></td>
			</tr>
			<tr>
				<td>Employee</td>
				<td><input type='text' size='20' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
					<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Status</td>
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
				$join="   ";
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
			
			<tr>
			  <td>Reject Position</td>
			  <td>
			  <select name="reduce" class="selectbox">
			    <option value="" <?php if($obj->reduce==""){echo"selected";}?>>Packing Hall</option>
			    <option value="reduce" <?php if($obj->reduce=="reduce"){echo"selected";}?>>Cold Store</option>
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
				<td><input type='checkbox' name='grrejecttypeid' value='1' <?php if(isset($_POST['grrejecttypeid']) ){echo"checked";}?>>&nbsp;Reject Type</td>
				<td><input type='checkbox' name='grsizeid' value='1' <?php if(isset($_POST['grsizeid']) ){echo"checked";}?>>&nbsp;Size </td>
			<tr>
				<td><input type='checkbox' name='gritemid' value='1' <?php if(isset($_POST['gritemid']) ){echo"checked";}?>>&nbsp;Item</td>
				<td><input type='checkbox' name='grgradedon' value='1' <?php if(isset($_POST['grgradedon']) ){echo"checked";}?>>&nbsp;Graded on</td>
			<tr>
				<td><input type='checkbox' name='grreportedon' value='1' <?php if(isset($_POST['grreportedon']) ){echo"checked";}?>>&nbsp;Reported on</td>
				<td><input type='checkbox' name='gremployeeid' value='1' <?php if(isset($_POST['gremployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
			<tr>
				<td><input type='checkbox' name='grstatus' value='1' <?php if(isset($_POST['grstatus']) ){echo"checked";}?>>&nbsp;Status</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
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
				<td><input type='checkbox' name='shrejecttypeid' value='1' <?php if(isset($_POST['shrejecttypeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Reject Type</td>
				<td><input type='checkbox' name='shsizeid' value='1' <?php if(isset($_POST['shsizeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Size </td>
			<tr>
				<td><input type='checkbox' name='shitemid' value='1' <?php if(isset($_POST['shitemid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Item</td>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
			<tr>
				<td><input type='checkbox' name='shgradedon' value='1' <?php if(isset($_POST['shgradedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Graded on</td>
				<td><input type='checkbox' name='shreportedon' value='1' <?php if(isset($_POST['shreportedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Reported on</td>
			<tr>
				<td><input type='checkbox' name='shemployeeid' value='1' <?php if(isset($_POST['shemployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
			<tr>
				<td><input type='checkbox' name='shstatus' value='1' <?php if(isset($_POST['shstatus']) ){echo"checked";}?>>&nbsp;Status</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ipaddress</td>
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
			<?php if($obj->shrejecttypeid==1  or empty($obj->action)){ ?>
				<th>Reject Type </th>
			<?php } ?>
			<?php if($obj->shsizeid==1  or empty($obj->action)){ ?>
				<th>Size </th>
			<?php } ?>
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>Product </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Quantity </th>
			<?php } ?>
			<?php if($obj->shgradedon==1  or empty($obj->action)){ ?>
				<th>Date Graded </th>
			<?php } ?>
			<?php if($obj->shreportedon==1  or empty($obj->action)){ ?>
				<th>Date Reported </th>
			<?php } ?>
			<?php if($obj->shemployeeid==1 ){ ?>
				<th>Employee </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shstatus==1 ){ ?>
				<th>Status </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>IP Address </th>
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
