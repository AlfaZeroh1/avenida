<title>WiseDigits: Tenders </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
$(function() {

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

<script type="text/javascript">
/*$().ready(function() {
  $("#billofquantitiesbqitemname").autocomplete({
	source:"../../../modules/server/server/search.php?main=tender&module=bqitems&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#billofquantitiesbqitemid").val(ui.item.id);
	}
  });

});*/
</script>

 <script type="text/javascript" charset="utf-8">
 /*$(document).ready(function() {
 	$('#tbl').dataTable( {
 		"sScrollY": 180,
 		"bJQueryUI": true,
 		"bSort":false,
 		"sPaginationType": "full_numbers"
 	} );
 } );*/
 </script>
<div class="container" style="margin-top:;">
<div class="tabbable">
  <ul class="nav nav-tabs">
    <li><a href="#pane1" data-toggle="tab">TENDER DETAILS</a></li>
    <li><a href="#pane2" data-toggle="tab">DOCUMENTS</a></li>
    <li><a href="#pane3" data-toggle="tab">CHECKLIST</a></li>
    <li><a href="#pane4" data-toggle="tab">BILL OF QUANTITIES</a></li>
  </ul>

<div class="tab-content">
    <div id="pane1" class="tab-pane active">
      <h4>...</h4>
<form  id="theform" action="addtenders_proc.php" name="tenders" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Proposal No : </td>
		<td><input type="text" name="proposalno" id="proposalno" value="<?php echo $obj->proposalno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Tender Description : </td>
		<td><textarea name="name" cols="40"><?php echo $obj->name; ?></textarea><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Tender Type : </td>
			<td><select name="tendertypeid">
<option value="">Select...</option>
<?php
	$tendertypes=new Tendertypes();
	$where="  ";
	$fields="tender_tendertypes.id, tender_tendertypes.name, tender_tendertypes.description, tender_tendertypes.remarks, tender_tendertypes.ipaddress, tender_tendertypes.createdby, tender_tendertypes.createdon, tender_tendertypes.lasteditedby, tender_tendertypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tendertypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($tendertypes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->tendertypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Date Received : </td>
		<td><input type="text" name="datereceived" id="datereceived" class="date_input" size="12" readonly  value="<?php echo $obj->datereceived; ?>"></td>
	</tr>
	<tr>
		<td align="right">Action Plan Date : </td>
		<td><input type="text" name="actionplandate" id="actionplandate" class="date_input" size="12" readonly  value="<?php echo $obj->actionplandate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Date Of Review : </td>
		<td><input type="text" name="dateofreview" id="dateofreview" class="date_input" size="12" readonly  value="<?php echo $obj->dateofreview; ?>"></td>
	</tr>
	<tr>
		<td align="right">Date Of Submission : </td>
		<td><input type="text" name="dateofsubmission" id="dateofsubmission" class="date_input" size="12" readonly  value="<?php echo $obj->dateofsubmission; ?>"></td>
	</tr>
	<tr>
		<td align="right">Reviewed By : </td>
			<td><input type='text' size='20' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
			<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'>
		</td>
	</tr>
	<tr>
		<td align="right">Status : </td>
			<td>			
		<input type="hidden" name="statusid" id="statusid" value="<?php echo $obj->statusid; ?>"/>
			
<?php
	$statuss=new Statuss();
	$where=" where id='$obj->statusid' ";
	$fields="tender_statuss.id, tender_statuss.name, tender_statuss.remarks, tender_statuss.ipaddress, tender_statuss.createdby, tender_statuss.createdon, tender_statuss.lasteditedby, tender_statuss.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$statuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	$statuss=$statuss->fetchObject;	
	?>
		<span><?php echo $statuss->name; ?></span>
		</td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td>
		<textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center">
		<?php if(!empty($obj->id) and $obj->statusid==2){?>
		<input type="submit" name="action2" id="action2" class="btn btn-success" value="Awarded"/>
		<?php }?>
		
		<?php if(!empty($obj->id) and $obj->statusid==1){?>
		<input type="submit" name="action2" id="action2" class="btn btn-info" value="Completed"/>
		<?php }?>
		
		<input type="submit" name="action" id="action" class="btn btn-primary" value="<?php echo $obj->action; ?>"/>&nbsp;<input type="submit" name="action" id="action" class="btn btn-danger" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	</table>
	</div>
    <div id="pane2" class="tab-pane">
      <h4>...</h4>
<form  id="theform" action="addtenders_proc.php" name="tenders" method="POST" enctype="multipart/form-data">
<?php if(!empty($obj->id)){?>
<?php }?>
	<?php if(!empty($obj->id)){?> 
	<table align="center">
	<tr>
		<th colspan='2'>Documents </th>
	</tr>
	<tr>
				<td>Document Type :</td><td> <select name='documentsdocumenttypeid'>
				<option value="">Select...</option>
				<?php
				$documenttypes=new Documenttypes();
				$fields="dms_documenttypes.id, dms_documenttypes.name, dms_documenttypes.moduleid, dms_documenttypes.remarks, dms_documenttypes.ipaddress, dms_documenttypes.createdby, dms_documenttypes.createdon, dms_documenttypes.lasteditedby, dms_documenttypes.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where moduleid not in(2)";
				$documenttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($documenttypes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->documenttypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td>
				</tr>
				<tr>
				<td>Title :</td><td> <input type="text" name="documentstitle" size="32" ></td>
				</tr>
				<tr>
				<td>Upload File :</td><td> <input type="file" name="documentsfile" size="0" ></td>
				</tr>
				<tr>
				<td>Remarks :</td><td> <textarea name="documentsremarks"><?php echo $obj->documentsremarks; ?></textarea></td>
				</tr>
				<tr>
				<td colspan="2" align="center"><input type="submit" class="btn btn-primary" value="Add Document" name="action"></td>
			</tr>
	<tr>
		</table>
		<table style="" width="80%" class="table table-striped responsive-table" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
		<tr>
		  <th>#</th>
		  <th>Document Type</th>
		  <th>Title</th>
		  <th>File</th>
		  <th>Remarks</th>
		  <th>&nbsp;</th>
		</tr>
			
<?php
		$documents=new Documents();
		$i=0;
		$fields="tender_documents.id, tender_tenders.name as tenderid, dms_documenttypes.id document, dms_documenttypes.name as documenttypeid, tender_documents.title, tender_documents.file, tender_documents.remarks, tender_documents.ipaddress, tender_documents.createdby, tender_documents.createdon, tender_documents.lasteditedby, tender_documents.lasteditedon";
		$join=" left join tender_tenders on tender_documents.tenderid=tender_tenders.id  left join dms_documenttypes on tender_documents.documenttypeid=dms_documenttypes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where tender_documents.tenderid='$obj->id'";
		$documents->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$documents->affectedRows;
		$res=$documents->result;
		while($row=mysql_fetch_object($res)){
		
		
		//create a resource folder
		$config = new Config();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where name='DMS_RESOURCE'";
		$config->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$config=$config->fetchObject;
		
		//get module name
		$module = new Modules();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where id=24 ";
		$module->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$module=$module->fetchObject;
		
		$tenders = new Tenders();
		$fields=" tender_tendertypes.name, tender_tenders.proposalno ";
		$join=" left join tender_tendertypes on tender_tendertypes.id=tender_tenders.tendertypeid left join tender_checklists on tender_checklists.tenderid=tender_tenders.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where tender_tenders.id='$obj->id' ";
		$tenders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$tenders=$tenders->fetchObject;
		
		$documenttypes=new Documenttypes();
		$fields="dms_documenttypes.id, dms_documenttypes.name, dms_documenttypes.moduleid, dms_documenttypes.remarks, dms_documenttypes.ipaddress, dms_documenttypes.createdby, dms_documenttypes.createdon, dms_documenttypes.lasteditedby, dms_documenttypes.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where dms_documenttypes.id ='$row->document' ";
		$documenttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$documenttypes=$documenttypes->fetchObject;
		
		$ext = explode(".",$filename);
		
		$nm=count($ext);
		
		$ob->document=$ob->title.".".$ext[$nm-1];
		
		$ob->file=$file;
		
		$ob->link=$module->name."/documents/".$tenders->name."/".$tenders->proposalno."/".$documenttypes->name;
		
		      
		
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->documenttypeid; ?></td>
				<td><?php echo $row->title; ?></td>
				<td><a href="<?php echo $config->value; ?>/<?php echo $ob->link; ?>/<?php echo $row->file; ?>"><?php echo $row->file; ?></a></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addtenders_proc.php?id=<?php echo $obj->id; ?>&documents=<?php echo $row->id; ?>'><img src="../../../img/trash.png" alt="delete" title="delete" /></a></td>
			</tr>
		<?php
		}
?>
		</table>
		
	</div>
    <div id="pane3" class="tab-pane">
      <h4>...</h4>
<form  id="theform" action="addtenders_proc.php" name="tenders" method="POST" enctype="multipart/form-data">
<table align="center">
<tr>
	<td>Category :</td><td> <select name='checklistschecklistcategoryid'>
	<option value="">Select...</option>
	<?php
	$checklistcategorys=new Checklistcategorys();
	$fields="tender_checklistcategorys.id, tender_checklistcategorys.name, tender_checklistcategorys.remarks, tender_checklistcategorys.ipaddress, tender_checklistcategorys.createdby, tender_checklistcategorys.createdon, tender_checklistcategorys.lasteditedby, tender_checklistcategorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where="";
	$checklistcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($checklistcategorys->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->checklistcategoryid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
	</select></td>
	</tr>
	<tr>
	<td>Responsibility :</td><td> <input type="text" name="checklistsname" size="20" ></td>
	</tr>
	<tr>
	<td>Description :</td><td> <textarea name="checklistsdescription"><?php echo $obj->checklistsdescription; ?></textarea></td>
	</tr>
	<tr>
	<td>Deadline :</td><td> <input type="text" name="checklistsdeadline" size="16" class="date_input"></td>
	</tr>
	<tr>
	<td>Status :</td><td><select name='status'>
		<option value='Pending' <?php if($obj->status=='Pending'){echo"selected";}?>>Pending</option>
		<option value='Partially Done' <?php if($obj->status=='Partially Done'){echo"selected";}?>>Partially Done</option>
		<option value='Done' <?php if($obj->status=='Done'){echo"selected";}?>>Done</option>
		</select></td>
	
	</tr>
	<tr>
	<td colspan='2' align="center"><input type="submit" class="btn-primary" value="Add Checklist" name="action"></td>
</tr>
</table>
<table style="" width="60%" class="table table-striped responsive-table" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	
			
			<tr>
			  <th>#</th>
			  <th>Category</th>
			  <th>Responsibility</th>
			  <th>Description</th>
			  <th>Deadline</th>
			  <th>Status</th>
			</tr>
<?php
		$checklists=new Checklists();
		$i=0;
		$fields="tender_checklists.id, tender_checklists.name, tender_checklistcategorys.name as checklistcategoryid, tender_tenders.name as tenderid, tender_checklists.description, tender_checklists.deadline, tender_checklists.status, tender_checklists.doneon, tender_checklists.completedon, tender_checklists.remarks, tender_checklists.ipaddress, tender_checklists.createdby, tender_checklists.createdon, tender_checklists.lasteditedby, tender_checklists.lasteditedon";
		$join=" left join tender_checklistcategorys on tender_checklists.checklistcategoryid=tender_checklistcategorys.id  left join tender_tenders on tender_checklists.tenderid=tender_tenders.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where tender_checklists.tenderid='$obj->id'";
		$checklists->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$checklists->affectedRows;
		$res=$checklists->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<th><?php echo $i; ?></th>
				<th><?php echo $row->checklistcategoryid; ?></th>
				<th><?php echo $row->name; ?>&nbsp;</th>
				<th><?php echo $row->description; ?>&nbsp;</th>
				<th><?php echo $row->deadline; ?></th>
				<th><?php echo $row->status; ?></th>
			</tr>
			<tr>
				<td colspan='6'>
				<?php 
				$checklistemployees = new Checklistemployees();
				$fields="concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeeid, tender_checklistemployees.remarks";
				$where=" where tender_checklistemployees.checklistid='$row->id' ";
				$join=" left join hrm_employees on hrm_employees.id=tender_checklistemployees.employeeid";
				$having="";
				$groupby="";
				$orderby="";
				$checklistemployees->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $checklistemployees->sql;
				while($check=mysql_fetch_object($checklistemployees->result)){
				?>
				&nbsp;&nbsp;<?php echo initialCap($check->employeeid); ?> <?php if(!empty($check->remarks)){?>(<?php echo $check->remarks; ?>)<?php }?>|&nbsp;
				<?php 
				}
				?>
				<a href="javascript:;" onclick="showPopWin('../checklistemployees/addchecklistemployees_proc.php?tenderid=<?php echo $obj->id; ?>&checklistid=<?php echo $row->id; ?>',600,430);">Add Employee</a></td>
			</tr>
		<?php
		
		//give list of all uploaded documents
		?>
		
			<?php 
			$checklistdocuments=new Checklistdocuments();
			$j=0;
			$fields="tender_checklistdocuments.id, tender_checklistdocuments.title, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeeid, tender_checklists.name as checklistid, dms_documenttypes.name as documenttypeid, tender_checklistdocuments.file, tender_checklistdocuments.remarks, tender_checklistdocuments.ipaddress, tender_checklistdocuments.createdby, tender_checklistdocuments.createdon, tender_checklistdocuments.lasteditedby, tender_checklistdocuments.lasteditedon";
			$join=" left join tender_checklists on tender_checklistdocuments.checklistid=tender_checklists.id  left join dms_documenttypes on tender_checklistdocuments.documenttypeid=dms_documenttypes.id  left join auth_users on auth_users.id=tender_checklistdocuments.createdby left join hrm_employees on hrm_employees.id=auth_users.employeeid ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where tender_checklistdocuments.checklistid='$row->id'";
			$checklistdocuments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			if($checklistdocuments->affectedRows>0){
			?>
			<tr>
			<td colspan="7">
			<table width="70%" style="margin-left: 30px;" class="table table-striped responsive-table">
			<tr>
				<th>#</th>
				<th>Title</th>
				<th>Document Type</th>
				<th>File</th>
				<th>Remarks</th>
				<th>Uploaded By</th>
				<th>Uploaded On</th>
			</tr>
			<?php
		
		$rs=$checklistdocuments->result;
		while($rw=mysql_fetch_object($rs)){
		$j++;
	?>
			<tr>
				<td><?php echo $j; ?></td>
				<td><?php echo $rw->title; ?></td>
				<td><?php echo $rw->documenttypeid; ?></td>
				<td><a href="files/<?php echo $rw->file; ?>"><?php echo $rw->file; ?></a></td>
				<td><?php echo $rw->remarks; ?></td>
				<td><?php echo $rw->employeeid; ?></td>
				<td><?php echo $rw->createdon; ?></td>
			</tr>
		<?php
		}
?>
		</table>
			</td>
		</tr>
		<?php 
		}
		}
?>
		
	</table>
	</div>
    <div id="pane4" class="tab-pane">
      <h4>...</h4>
<form  id="theform" action="addtenders_proc.php" name="tenders" method="POST" enctype="multipart/form-data">
<table align="center">
	<tr>
		<th colspan='2'>Billofquantities </th>
	</tr>
	
	
	<tr>
				<td>BQ Item :</td><td><textarea name='billofquantitiesbqitem' id='billofquantitiesbqitem'></textarea></td>
				</tr>
				<tr>
				<td>Quantity :</td><td> <input type="text" name="billofquantitiesquantity" size="8" ></td>
				</tr>
				<tr>
				<td>Unit Of Measure :</td><td> <select name="billofquantitiesunitofmeasureid" class="selectbox">
				  <option value="">Select...</option>
				  <?php
					  $unitofmeasures=new Unitofmeasures();
					  $where="  ";
					  $fields="tender_unitofmeasures.id, tender_unitofmeasures.name, tender_unitofmeasures.remarks, tender_unitofmeasures.ipaddress, tender_unitofmeasures.createdby, tender_unitofmeasures.createdon, tender_unitofmeasures.lasteditedby, tender_unitofmeasures.lasteditedon";
					  $join="";
					  $having="";
					  $groupby="";
					  $orderby="";
					  $unitofmeasures->retrieve($fields,$join,$where,$having,$groupby,$orderby);

					  while($rw=mysql_fetch_object($unitofmeasures->result)){
					  ?>
						  <option value="<?php echo $rw->id; ?>" <?php if($obj->billofquantitiesunitofmeasureid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
					  <?php
					  }
					  ?>
				  </select><font color='red'>*</font>
						  </td>
						  </tr>
				<tr>
				<td>BQ Rate :</td><td> <input type="text" name="billofquantitiesbqrate" size="8" ></td>
				</tr>
				<tr>
				<td>Remarks :</td><td> <textarea name="billofquantitiesremarks"><?php echo $obj->billofquantitiesremarks; ?></textarea></td>
				</tr>
				<tr>
				<td align="center" colspan="2"><input type="submit" value="Add Billofquantitie" class="btn btn-primary" name="action"></td>
			</tr>
			<tr>
			  <td>Upload BoQ: </td>
			  <td><input type="file" name="bog"/>&nbsp;<input type="submit" value="Upload BoQ" class="btn btn-primary" name="action"></td>
			</tr>
			
	</table>
		<table style="" width="60%" class="table table-striped responsive-table" border="0" cellpadding="2" cellspacing="0" id="tblSample">
			<tr>
				<th>#</th>
				<th>BQ Item </th>
				<th>Quantity</th>
				<th>BQ Rate</th>
				<th>Remarks</th>
				<th>&nbsp;</th>
			</tr>
<?php
		$billofquantities=new Billofquantities();
		$i=0;
		$fields="tender_billofquantities.id, tender_tenders.name as tenderid, tender_unitofmeasures.name unitofmeasureid, tender_billofquantities.bqitem as bqitem, tender_billofquantities.quantity, tender_billofquantities.bqrate, tender_billofquantities.remarks, tender_billofquantities.ipaddress, tender_billofquantities.createdby, tender_billofquantities.createdon, tender_billofquantities.lasteditedby, tender_billofquantities.lasteditedon";
		$join=" left join tender_tenders on tender_billofquantities.tenderid=tender_tenders.id left join tender_unitofmeasures on tender_unitofmeasures.id=tender_billofquantities.unitofmeasureid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where tender_billofquantities.tenderid='$obj->id'";
		$billofquantities->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$billofquantities->affectedRows;
		$res=$billofquantities->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->bqitem; ?></td>
				<td><?php echo $row->quantity; ?>&nbsp;<?php echo $row->unitofmeasureid; ?></td>
				<td><?php echo $row->bqrate; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addtenders_proc.php?id=<?php echo $obj->id; ?>&billofquantities=<?php echo $row->id; ?>'><img src="../../../img/trash.png" alt="delete" title="delete" /></a></td>
			</tr>
		<?php
		}
?>
		</table>
		
<?php }?>
</div>
<?php 
if(!empty($error)){
	showError($error);
}
?>