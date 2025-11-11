<title><?php echo WISEDIGITS; ?>: <?php echo initialCap($page_title); ?></title>
<?php 
include "../../../head.php";

?>

<script type="text/javascript">
$().ready(function() {
  $("#employeename1").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(firstname,' ',lastname)",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#employeeid1").val(ui.item.id);
	}
  });

  $("#employeename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(firstname,' ',lastname)",
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

function GetXmlHttpObject()
	{
	  if (window.XMLHttpRequest)
	  {
	  // code for IE7+, Firefox, Chrome, Opera, Safari
	  return new XMLHttpRequest();
	  }
	  
	  if (window.ActiveXObject)
	  {
	  // code for IE6, IE5
	  return new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  return null;
	}
function Calculate(val){ 
		var xmlhttp;
		var startdate=document.getElementById("startdate").value;
		var e = document.getElementById("leavetypeid");
                var type = e.options[e.selectedIndex].value;
                if(type==""){
                   alert("Must provide Leave Type ");
                }else{
		var url="days.php?duration="+val+"&startdate="+startdate+"&type="+type;//alert(url);
		xmlhttp=GetXmlHttpObject();
		
		if (xmlhttp==null)
		{
		  alert ("Browser does not support HTTP Request");
		  return;
		}  
		
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4)
			{
			var data = xmlhttp.responseText;//alert(data);
			document.getElementById("enddate").value=data;				
			}
		};
			
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);   
		}
	}
<?php include'js.php'; ?>
</script>
</script>
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

<div id="tabs-1" style="min-height:700px;">
<form class="forms" id="theform" action="addemployeeleaveapplications_proc.php" name="employeeleaveapplications" method="POST" enctype="multipart/form-data">
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
		<td align="right">Employee : </td>
		<td>
		<?php
			$employees=new Employees();
			if(!empty($obj->employeeid))
			     $where=" where hrm_employees.id='$obj->employeeid'  ";
                        else
			     $where=" where hrm_employees.id='".$_SESSION['employeeid']."'  ";
			$fields="concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) name,hrm_employees.id  employeeid, hrm_assignments.name assignmentid ";
			$join=" left join hrm_assignments on hrm_assignments.id=hrm_employees.assignmentid ";
			$having="";
			$groupby="";
			$orderby="";
			$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$employees=$employees->fetchObject;
			$obj->employeeid=$employees->employeeid;
                        $obj->employeename=$employees->name;
			?>
		<input type="text" name="employeename" id="employeename" value="<?php echo $obj->employeename; ?>">
		<input type="hidden" name="employeeid" id="employeeid" value="<?php echo $obj->employeeid; ?>">
		
		</td>
	</tr>
	
	<tr>
		<td align="right">Job Position : </td>
		<td><?php echo $employees->assignmentid; ?> 
		<span style="color:red;"><?php if(empty($employees->assignmentid))echo "Please talk to Administrator! Cannot apply for leave if your Job Position is not set!";?></span>
		</td>
	        </tr>
		</td>
	</tr>
	
	<tr>
		<td align="right">Employee In Charge When On Leave : </td>
		<td>
		<input type="text" name="employeename1" id="employeename1" value="<?php echo $obj->employeename1; ?>">
		<input type="hidden" name="employeeid1" id="employeeid1" value="<?php echo $obj->employeeid1; ?>"></td>
	        </tr>
		</td>
	</tr>
	<tr>
		<td align="right">Leave Type : </td>
			<td><select name="leavetypeid" id="leavetypeid" class="selectbox">
<option value="">Select...</option>
<?php
	$leavetypes=new Leavetypes();
	$where="";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$leavetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($leavetypes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->leavetypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Start Date : </td>
		<td><input type="text" name="startdate" id="startdate" class="date_input" size="12" readonly  value="<?php echo $obj->startdate; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Duration (Working Days) : </td>
		<td><input type="text" name="duration" id="duration" onchange="Calculate(this.value);" value="<?php echo $obj->duration; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">End Date: </td>
		<td><input type="text" name="enddate" readonly id="enddate" value="<?php echo $obj->enddate; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Type : </td>
		<td>
			<input type="radio" name="type" id="type" checked value='Days' <?php if($obj->type=='Days'){echo"checked";}?>>Days 
			<!--<input type="radio" name="type" id="type" value='Hours' <?php if($obj->type=='Hours'){echo"checked";}?>>Hours -->
		</td>
	</tr>
	<tr>
		<td align="right">Date Applied : </td>
		<td><input type="text" name="appliedon" id="appliedon" class="date_input" size="12" readonly  value="<?php echo $obj->appliedon; ?>"></td>
	</tr>
	<tr>
		<td align="right">Status : </td>
		<td>
			<input type="radio" name="status" id="status" value='pending' <?php if($obj->status=='pending'){echo"checked";}?>>Pending 
			<?php if($obj->status=='granted'){?>
			<input type="radio" name="status" id="status" value='pending' <?php if($obj->status=='granted'){echo"checked";}?>>Granted 
		        <?php } ?>
		</td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<?php if(!empty($employees->assignmentid)){?>
	<tr>
		<td colspan="2" align="center"><?php if(empty($obj->id)){ ?><input type="submit" class="btn btn-info" name="action" id="action" value="<?php echo $obj->action; ?>"><?php } ?>&nbsp;<input type="submit" name="action" id="action" class="btn btn-danger" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php } ?>
<?php if(!empty($obj->id)){?>
<?php }?>
</div>
<?php 
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>
