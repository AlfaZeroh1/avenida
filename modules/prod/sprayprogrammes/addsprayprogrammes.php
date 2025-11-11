<title>WiseDigits ERP: Sprayprogrammes </title>
<?php 
$pop=1;
include "../../../head.php";
// // // // $obj = (object)$_POST;
?>
 <script type="text/javascript" charset="utf-8">
 $(document).ready(function() {
 
 	$('#tbl').dataTable( {
 		"sScrollY": 180,
 		"bJQueryUI": true,
 		"bSort":false,
 		"sPaginationType": "full_numbers"
 	} );
 	})
 	</script>
 <script>
 $(document).ready(function() {
  $("#blockid").on('change',function(){ 
    var str=$(this).val();
   
    //var st = str.split("-");
      
      $.get("../harvests/getSections.php",{id:parseInt(str)},function(data){
	$("#sectionid").html(data);      
      });     
      
    
  });

    $("#sectionid").on("change",function(){
    var str=$(this).val();
    
    //var st = str.split("-");
    
      
      $.get("../harvests/getGreenHouses.php",{id:parseInt(str)},function(data){
	$("#greenhouseid").html(data);      
      });
    
  });
  $("#greenhouseid").on("change",function(){
    var str=$(this).val();
      
      $.get("../harvests/getVarietys.php",{id:parseInt(str)},function(data){
	$("#varietyid").html(data);      
      });     
      
    
  });
  $("#varietyid").on("change",function(){
    var str=$(this).val();
      
      $.get("../harvests/getVariety.php",{id:parseInt(str)},function(data){
	$("#quantity").val(data);      
      });     
      
    
  });
})
</script>
 </script>

<div class='main'>
<form  id="theform" action="addsprayprogrammes_proc.php" name="sprayprogrammes" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input class="btn btn-info" type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
	  <td align="right">
      Blocks:</td><td><select id="blockid" name="blockid" class="selectbox block" onchange>
<option value="">Select...</option>
<?php
	$blocks=new Blocks();
	$where="  ";
	$fields="prod_blocks.id, prod_blocks.name, prod_blocks.length, prod_blocks.width, prod_blocks.remarks, prod_blocks.ipaddress, prod_blocks.createdby, prod_blocks.createdon, prod_blocks.lasteditedby, prod_blocks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$blocks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($blocks->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($_POST['blockid']==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>&nbsp;
</td>
</tr>
<tr>
<td align="right">Section:</td><td>
<?php
$sections=new Sections();
$where="  ";
$fields="prod_sections.id, prod_sections.name, prod_blocks.name blockid";
$join=" left join prod_blocks on prod_blocks.id=prod_sections.blockid ";
$having="";
$groupby="";
$orderby="";
$sections->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
?>
<select name="sectionid" id="sectionid" class="selectbox section">
<option value="">Select...</option>
<?php
	while($rw=mysql_fetch_object($sections->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($_POST['sectionid']==$rw->id){echo "selected";}?>><?php echo initialCap($rw->blockid." ".$rw->name);?></option>
	<?php
	}
	?>
</select>&nbsp;
</td>
</tr>
<tr>
<td align="right">Green House:</td><td>
<?php
$greenhouses=new Greenhouses();
$where="  ";
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$greenhouses->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
?>
<select name="greenhouseid" id="greenhouseid" class="selectbox greenhouse">
<option value="">Select...</option>
<?php
	while($rw=mysql_fetch_object($greenhouses->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($_POST['greenhouseid']==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>&nbsp;
</td>
</tr>
<tr>

<td align="right">Variety: </td><td><select name="varietyid" id="varietyid" class="selectbox">
<option value="">Select...</option>
<?php
	$varietys=new Varietys();
	$where="  ";
	$fields="prod_varietys.id, prod_varietys.name, prod_varietys.typeid, prod_varietys.colourid, prod_varietys.duration, prod_varietys.remarks, prod_varietys.ipaddress, prod_varietys.createdby, prod_varietys.createdon, prod_varietys.lasteditedby, prod_varietys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby=" order by name";
	$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($varietys->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($_POST['varietyid']==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
</td>

</tr>
	<tr>
		<td align="right">Chemical : </td>
			<td><select name="chemicalid" class="selectbox">
<option value="">Select...</option>
<?php
	$chemicals=new Chemicals();
	$where="  ";
	$fields="prod_chemicals.id, prod_chemicals.name, prod_chemicals.remarks, prod_chemicals.ipaddress, prod_chemicals.createdby, prod_chemicals.createdon, prod_chemicals.lasteditedby, prod_chemicals.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$chemicals->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($chemicals->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->chemicalid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Ingredients : </td>
		<td><input type="text" name="ingredients" id="ingredients" value="<?php echo $obj->ingredients; ?>"></td>
	</tr>
	<tr>
		<td align="right">Chemical Quantity : </td>
		<td><input type="text" name="quantity" id="quantity" size="8"  value="<?php echo $obj->quantity; ?>"></td>
	</tr>
	<tr>
		<td align="right">Volume Of Water Used : </td>
		<td><input type="text" name="watervol" id="watervol" size="8"  value="<?php echo $obj->watervol; ?>"></td>
	</tr>

	<tr>
		<td align="right">Nozzle Used : </td>
			<td><select name="nozzleid" class="selectbox">
<option value="">Select...</option>
<?php
	$nozzles=new Nozzles();
	$where="  ";
	$fields="prod_nozzles.id, prod_nozzles.name, prod_nozzles.remarks, prod_nozzles.ipaddress, prod_nozzles.createdby, prod_nozzles.createdon, prod_nozzles.lasteditedby, prod_nozzles.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$nozzles->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($nozzles->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->nozzleid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Target Pests & Diseases : </td>
		<td><textarea name="target"><?php echo $obj->target; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Spray Method : </td>
			<td><select name="spraymethodid" class="selectbox">
<option value="">Select...</option>
<?php
	$spraymethods=new Spraymethods();
	$where="  ";
	$fields="prod_spraymethods.id, prod_spraymethods.name, prod_spraymethods.remarks, prod_spraymethods.ipaddress, prod_spraymethods.createdby, prod_spraymethods.createdon, prod_spraymethods.lasteditedby, prod_spraymethods.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$spraymethods->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($spraymethods->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->spraymethodid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Spray Date : </td>
		<td><input type="text" name="spraydate" id="spraydate" class="date_input" size="12" readonly  value="<?php echo $obj->spraydate; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Spray Time : </td>
		<td><select name='time' class="selectbox">
			<option value='Morning' <?php if($obj->time=='Morning'){echo"selected";}?>>Morning</option>
			<option value='Afternoon' <?php if($obj->time=='Afternoon'){echo"selected";}?>>Afternoon</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input class="btn btn-primary" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input class="btn btn-danger" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
<?php if(!empty($obj->id)){?>
<?php }?>
	<?php if(!empty($obj->id)){?> 
<?php }?>
</table>
</form>
<?php 
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>