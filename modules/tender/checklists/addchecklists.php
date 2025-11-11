<title>WiseDigits: Checklists </title>
<?php 
include "../../../head.php";

?>
 <script type="text/javascript" charset="utf-8">
 $(document).ready(function() {
 	$('#tbl').dataTable( {
 		"sScrollY": 180,
 		"bJQueryUI": true,
 		"bSort":false,
 		"sPaginationType": "full_numbers"
 	} );
 } );
 </script>

<div class='main'>
<form  id="theform" action="addchecklists_proc.php" name="checklists" method="POST" enctype="multipart/form-data">
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
		<td align="right">Responsibility : </td>
		<td><textarea name="name"><?php echo $obj->name; ?></textarea><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Category : </td>
			<td><select name="checklistcategoryid">
<option value="">Select...</option>
<?php
	$checklistcategorys=new Checklistcategorys();
	$where="  ";
	$fields="tender_checklistcategorys.id, tender_checklistcategorys.name, tender_checklistcategorys.remarks, tender_checklistcategorys.ipaddress, tender_checklistcategorys.createdby, tender_checklistcategorys.createdon, tender_checklistcategorys.lasteditedby, tender_checklistcategorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$checklistcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($checklistcategorys->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->checklistcategoryid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Tender : </td>
			<td><select name="tenderid">
<option value="">Select...</option>
<?php
	$tenders=new Tenders();
	$where="  ";
	$fields="tender_tenders.id, tender_tenders.proposalno, tender_tenders.name, tender_tenders.tendertypeid, tender_tenders.datereceived, tender_tenders.actionplandate, tender_tenders.dateofreview, tender_tenders.dateofsubmission, tender_tenders.employeeid, tender_tenders.Statusid, tender_tenders.remarks, tender_tenders.ipaddress, tender_tenders.createdby, tender_tenders.createdon, tender_tenders.lasteditedby, tender_tenders.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tenders->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($tenders->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->tenderid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Description : </td>
		<td><textarea name="description"><?php echo $obj->description; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Deadline : </td>
		<td><input type="text" name="deadline" id="deadline" class="date_input" size="12" readonly  value="<?php echo $obj->deadline; ?>"></td>
	</tr>
	<tr>
		<td align="right">Status : </td>
		<td><select name='status'>
			<option value='Pending' <?php if($obj->status=='Pending'){echo"selected";}?>>Pending</option>
			<option value='Partially Done' <?php if($obj->status=='Partially Done'){echo"selected";}?>>Partially Done</option>
			<option value='Done' <?php if($obj->status=='Done'){echo"selected";}?>>Done</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Date Done : </td>
		<td><input type="text" name="doneon" id="doneon" class="date_input" size="12" readonly  value="<?php echo $obj->doneon; ?>"></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="completedon" id="completedon" class="date_input" size="12" readonly  value="<?php echo $obj->completedon; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
<?php if(!empty($obj->id)){?>
<?php }?>
	<?php if(!empty($obj->id)){?> 
	<tr>
		<th colspan='2'>Checklistdocuments </th>
	</tr>
	<tr>
		<td colspan="2" align="center">
		<table align='left'>
			<tr>
				<td>&nbsp;</td>
				<td valign="bottom">Title : <input type="text" name="checklistdocumentstitle" size="20" ></td>
				<td valign="bottom">Document Type : <select name='checklistdocumentsdocumenttypeid'>
				<option value="">Select...</option>
				<?php
				$documenttypes=new Documenttypes();
				$fields="dms_documenttypes.id, dms_documenttypes.name, dms_documenttypes.moduleid, dms_documenttypes.remarks, dms_documenttypes.ipaddress, dms_documenttypes.createdby, dms_documenttypes.createdon, dms_documenttypes.lasteditedby, dms_documenttypes.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where dms_documenttypes.moduleid not in(2) ";
				$documenttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($documenttypes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->documenttypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td>
				<td valign="bottom">Upload Document : <input type="file" name="checklistdocumentsfile" size="0" ></td>
				<td valign="bottom">Remarks : <textarea name="checklistdocumentsremarks"><?php echo $obj->checklistdocumentsremarks; ?></textarea></td>
				<td valign="bottom"><input type="submit" value="Add Checklistdocument" name="action"></td>
			</tr>
<?php

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
		$where=" where tender_checklists.id='$obj->id' ";
		$tenders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$tenders=$tenders->fetchObject;	      
		      
		$checklistdocuments=new Checklistdocuments();
		$i=0;
		$fields="tender_checklistdocuments.id, tender_checklistdocuments.title, tender_checklists.name as checklistid, dms_documenttypes.id as documenttype, dms_documenttypes.name as documenttypeid, tender_checklistdocuments.file, tender_checklistdocuments.remarks, tender_checklistdocuments.ipaddress, tender_checklistdocuments.createdby, tender_checklistdocuments.createdon, tender_checklistdocuments.lasteditedby, tender_checklistdocuments.lasteditedon";
		$join=" left join tender_checklists on tender_checklistdocuments.checklistid=tender_checklists.id  left join dms_documenttypes on tender_checklistdocuments.documenttypeid=dms_documenttypes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where tender_checklistdocuments.checklistid='$obj->id'";
		$checklistdocuments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$checklistdocuments->affectedRows;
		$res=$checklistdocuments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
		
		$documenttypes=new Documenttypes();
		$fields="dms_documenttypes.id, dms_documenttypes.name, dms_documenttypes.moduleid, dms_documenttypes.remarks, dms_documenttypes.ipaddress, dms_documenttypes.createdby, dms_documenttypes.createdon, dms_documenttypes.lasteditedby, dms_documenttypes.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where dms_documenttypes.id ='$row->documenttype' ";
		$documenttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$documenttypes = $documenttypes->fetchObject;
		
		$dir = $config->value."".$module->name."/".$tenders->name."/".$tenders->proposalno."/".$documenttypes->name;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->title; ?></td>
				<td><?php echo $row->documenttypeid; ?></td>
				<td><a href="<?php echo $dir; ?>/<?php echo $row->file; ?>"><?php echo $row->file; ?></a></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addchecklists_proc.php?id=<?php echo $obj->id; ?>&checklistdocuments=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
		</table>
		</td>
	</tr>
	<tr>
	<td colspan='<?php echo ($num+2); ?>'><hr/></td>
	</tr>
<?php }?>
</table>
</form>
<?php 
if(!empty($error)){
	showError($error);
}
?>