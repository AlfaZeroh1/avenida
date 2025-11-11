<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/proc/suppliers/Suppliers_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/proc/suppliercategorys/Suppliercategorys_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Suppliers";
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
	if(!empty($obj->shcode)  or empty($obj->action)){
		array_push($sColumns, 'code');
		array_push($aColumns, "proc_suppliers.code");
	}

	if(!empty($obj->shname)  or empty($obj->action)){
		array_push($sColumns, 'name');
		array_push($aColumns, "proc_suppliers.name");
	}

	if(!empty($obj->shcontact) ){
		array_push($sColumns, 'contact');
		array_push($aColumns, "proc_suppliers.contact");
	}

	if(!empty($obj->shtel) ){
		array_push($sColumns, 'tel');
		array_push($aColumns, "proc_suppliers.tel");
	}

	if(!empty($obj->shemail) ){
		array_push($sColumns, 'email');
		array_push($aColumns, "proc_suppliers.email");
	}

	if(!empty($obj->shcellphone) ){
		array_push($sColumns, 'cellphone');
		array_push($aColumns, "proc_suppliers.cellphone");
	}

	if(!empty($obj->shstatus) ){
		array_push($sColumns, 'status');
		array_push($aColumns, "proc_suppliers.status");
	}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username createdby");
		$rptjoin.=" left join auth_users on auth_users.id=proc_suppliers.createdby ";
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "proc_suppliers.createdon");
	}

	if(!empty($obj->shsuppliercategoryid)  or empty($obj->action)){
		array_push($sColumns, 'suppliercategoryid');
		array_push($aColumns, "proc_suppliercategorys.name as suppliercategoryid");
		$rptjoin.=" left join proc_suppliercategorys on proc_suppliercategorys.id=proc_suppliers.suppliercategoryid ";
	}

if($obj->action=='Filter'){
//processing filters
if(!empty($obj->code)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_suppliers.code='$obj->code'";
	$track++;
}

if(!empty($obj->name	)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_suppliers.name	='$obj->name	'";
	$track++;
}

if(!empty($obj->status)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_suppliers.status='$obj->status'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_suppliers.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_suppliers.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_suppliers.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->suppliercategoryid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_suppliers.suppliercategoryid='$obj->suppliercategoryid'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
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

if(!empty($obj->grsuppliercategoryid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" suppliercategoryid ";
	$obj->shsuppliercategoryid=1;
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
 <?php $_SESSION['sTable']="proc_suppliers";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=proc_suppliers",
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
<form  action="suppliers.php" method="post" name="suppliers" class=''>
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
				<td><input type='text' id='name	' size='20' name='name	' value='<?php echo $obj->name	;?>'></td>
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
			<tr>
				<td>Supplier Category</td>
				<td>
				<select name='suppliercategoryid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$suppliercategorys=new Suppliercategorys();
				$where="  ";
				$fields="proc_suppliercategorys.id, proc_suppliercategorys.name, proc_suppliercategorys.remarks, proc_suppliercategorys.createdby, proc_suppliercategorys.createdon, proc_suppliercategorys.lasteditedby, proc_suppliercategorys.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$suppliercategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($suppliercategorys->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->suppliercategoryid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
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
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='grsuppliercategoryid' value='1' <?php if(isset($_POST['grsuppliercategoryid']) ){echo"checked";}?>>&nbsp;Supplier Category</td>
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
				<td><input type='checkbox' name='shcode' value='1' <?php if(isset($_POST['shcode'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Code</td>
				<td><input type='checkbox' name='shname	' value='1' <?php if(isset($_POST['shname	'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Name</td>
			<tr>
				<td><input type='checkbox' name='shcontact' value='1' <?php if(isset($_POST['shcontact']) ){echo"checked";}?>>&nbsp;Contact</td>
				<td><input type='checkbox' name='shtel' value='1' <?php if(isset($_POST['shtel']) ){echo"checked";}?>>&nbsp;Tel</td>
			<tr>
				<td><input type='checkbox' name='shemail' value='1' <?php if(isset($_POST['shemail']) ){echo"checked";}?>>&nbsp;Email</td>
				<td><input type='checkbox' name='shcellphone' value='1' <?php if(isset($_POST['shcellphone']) ){echo"checked";}?>>&nbsp;Cellphone</td>
			<tr>
				<td><input type='checkbox' name='shstatus' value='1' <?php if(isset($_POST['shstatus']) ){echo"checked";}?>>&nbsp;Status</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='shsuppliercategoryid' value='1' <?php if(isset($_POST['shsuppliercategoryid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Supplier Category</td>
			<tr>
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
			<?php if($obj->shcode==1  or empty($obj->action)){ ?>
				<th>Code </th>
			<?php } ?>
			<?php if($obj->shname	==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shcontact==1 ){ ?>
				<th>Contact </th>
			<?php } ?>
			<?php if($obj->shtel==1 ){ ?>
				<th>Phone No. </th>
			<?php } ?>
			<?php if($obj->shemail==1 ){ ?>
				<th>E-mail </th>
			<?php } ?>
			<?php if($obj->shcellphone==1 ){ ?>
				<th>Cell-Phone </th>
			<?php } ?>
			<?php if($obj->shstatus==1 ){ ?>
				<th>Status </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>CreatedBy </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>CreatedOn </th>
			<?php } ?>
			<?php if($obj->shsuppliercategoryid==1  or empty($obj->action)){ ?>
				<th>Supplier Category </th>
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
