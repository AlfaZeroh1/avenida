<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/fn/expenses/Expenses_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/fn/expenses/Expenses_class.php");
require_once("../../../modules/fn/expensetypes/Expensetypes_class.php");
require_once("../../../modules/fn/expensecategorys/Expensecategorys_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Expenses";
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
	if(!empty($obj->shname)  or empty($obj->action)){
		array_push($sColumns, 'name');
		array_push($aColumns, "fn_expenses.name");
	}

	if(!empty($obj->shcode)  or empty($obj->action)){
		array_push($sColumns, 'code');
		array_push($aColumns, "fn_expenses.code");
	}

	if(!empty($obj->shexpensetypeid)  or empty($obj->action)){
		array_push($sColumns, 'expensetypeid');
		array_push($aColumns, "fn_expensetypes.name as expensetypeid");
		$rptjoin.=" left join fn_expensetypes on fn_expensetypes.id=fn_expenses.expensetypeid ";
	}

	if(!empty($obj->shexpensecategoryid)  or empty($obj->action)){
		array_push($sColumns, 'expensecategoryid');
		array_push($aColumns, "fn_expensecategorys.name as expensecategoryid");
		$rptjoin.=" left join fn_expensecategorys on fn_expensecategorys.id=fn_expenses.expensecategoryid ";
	}

	if(!empty($obj->shdescription)  or empty($obj->action)){
		array_push($sColumns, 'description');
		array_push($aColumns, "fn_expenses.description");
	}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "fn_expenses.createdon");
	}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "fn_expenses.createdby");
	}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "fn_expenses.ipaddress");
	}



if($obj->action=='Filter'){
//processing filters
if(!empty($obj->name)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_expenses.name='$obj->name'";
	$track++;
}

if(!empty($obj->code)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_expenses.code='$obj->code'";
	$track++;
}

if(!empty($obj->expensetypeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_expenses.expensetypeid='$obj->expensetypeid'";
	$track++;
}

if(!empty($obj->expensecategoryid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_expenses.expensecategoryid='$obj->expensecategoryid'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_expenses.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_expenses.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_expenses.createdby='$obj->createdby'";
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

if(!empty($obj->grexpensetypeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" expensetypeid ";
	$obj->shexpensetypeid=1;
	$track++;
}

if(!empty($obj->grexpensecategoryid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" expensecategoryid ";
	$obj->shexpensecategoryid=1;
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

if(!empty($obj->grcreatedby)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" createdby ";
	$obj->shcreatedby=1;
	$track++;
}

//Processing Joins
;$rptgroup='';
$track=0;
}
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
  $("#naname").autocomplete({
	source:"../../../modules/server/server/search.php?main=fn&module=expenses&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#name").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="fn_expenses";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']="$rptgroup";?>
 
 $(document).ready(function() {
	 TableToolsInit.sSwfPath = "../../../media/swf/ZeroClipboard.swf";
 	$('#tbl').dataTable( {
 		"bJQueryUI": true,
 		"bSort":true,
 		"sPaginationType": "full_numbers",
 		"sScrollY": 400,
 		"iDisplayLength":50,
		"bJQueryUI": true,
		"bRetrieve":true,
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=fn_expenses",
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
<form  action="expenses.php" method="post" name="expenses" class='forms'>
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Name</td>
				<td><input type='text' size='20' name='naname' id='naname' value='<?php echo $obj->naname; ?>'>
					<input type="hidden" name='name' id='name' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Code</td>
				<td><input type='text' id='code' size='20' name='code' value='<?php echo $obj->code;?>'></td>
			</tr>
			<tr>
				<td>Expense Type	</td>
				<td>
				<select name='expensetypeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$expensetypes=new Expensetypes();
				$where="  ";
				$fields="fn_expensetypes.id, fn_expensetypes.name, fn_expensetypes.remarks";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$expensetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($expensetypes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->expensetypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Expense Category	</td>
				<td>
				<select name='expensecategoryid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$expensecategorys=new Expensecategorys();
				$where="  ";
				$fields="fn_expensecategorys.id, fn_expensecategorys.name, fn_expensecategorys.remarks";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$expensecategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($expensecategorys->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->expensecategoryid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Created On</td>
				<td><strong>From:</strong><input type='text' id='fromcreatedon' size='12' name='fromcreatedon' readonly class="date_input" value='<?php echo $obj->fromcreatedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='tocreatedon' size='12' name='tocreatedon' readonly class="date_input" value='<?php echo $obj->tocreatedon;?>'/></td>
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
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grname' value='1' <?php if(isset($_POST['grname']) ){echo"checked";}?>>&nbsp;Name</td>
				<td><input type='checkbox' name='grexpensetypeid' value='1' <?php if(isset($_POST['grexpensetypeid']) ){echo"checked";}?>>&nbsp;Expense Type	</td>
			<tr>
				<td><input type='checkbox' name='grexpensecategoryid' value='1' <?php if(isset($_POST['grexpensecategoryid']) ){echo"checked";}?>>&nbsp;Expense Category	</td>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
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
				<td><input type='checkbox' name='shname' value='1' <?php if(isset($_POST['shname'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Name</td>
				<td><input type='checkbox' name='shcode' value='1' <?php if(isset($_POST['shcode'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Code</td>
			<tr>
				<td><input type='checkbox' name='shexpensetypeid' value='1' <?php if(isset($_POST['shexpensetypeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Expense Type	</td>
				<td><input type='checkbox' name='shexpensecategoryid' value='1' <?php if(isset($_POST['shexpensecategoryid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Expense Category	</td>
			<tr>
				<td><input type='checkbox' name='shdescription' value='1' <?php if(isset($_POST['shdescription'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Description</td>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
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
			<?php if($obj->shname==1  or empty($obj->action)){ ?>
				<th>Name </th>
			<?php } ?>
			<?php if($obj->shcode==1  or empty($obj->action)){ ?>
				<th>Code </th>
			<?php } ?>
			<?php if($obj->shexpensetypeid==1  or empty($obj->action)){ ?>
				<th>Expense Type </th>
			<?php } ?>
			<?php if($obj->shexpensecategoryid==1  or empty($obj->action)){ ?>
				<th>Expense Category </th>
			<?php } ?>
			<?php if($obj->shdescription==1  or empty($obj->action)){ ?>
				<th>Description </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>CreatedOn </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>CreatedBy </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th> </th>
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
