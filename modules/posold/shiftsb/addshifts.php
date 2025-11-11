<title><?php echo WISEDIGITS; ?>: <?php echo initialCap($page_title); ?></title>
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
 	
 	<?php 
 	$i=0;
 	$brancheteams = new Branchteams();
	$fields="*, pos_teamroles.name teamroleid";
	$join=" left join pos_teamroles on pos_teamroles.id=pos_branchteams.teamroleid ";
	$having="";
	$groupby="";
	$orderby="";
	$where =" where pos_branchteams.brancheid='$obj->brancheid' ";
	$brancheteams->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$res=$brancheteams->result;
	while($row=mysql_fetch_object($res)){
	  $x=0;
	  while($x<$row->number){
	    ?>
	    $("#employeename<?php echo $i; ?>").autocomplete({
		source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)))",
		focus: function(event, ui) {
			event.preventDefault();
			$(this).val(ui.item.label);
		},
		select: function(event, ui) {
			event.preventDefault();
			$(this).val(ui.item.label);
			$("#employeeid<?php echo $i; ?>").val(ui.item.id);
		}
	    });
	  
	  <?php 
	  $i++;
	  $x++;
	}
      } 
      ?>
 	
 } );
 </script>

<div class="container">    
<form action="" method="post">


<div style="margin-bottom:5px;">
<table class="table">
  <tbody>
    <tr>
      <td align="right">TEAMED On:</td>
      <td><input type="text" class="datetime" readonly name="starttime" id="starttime" value="<?php echo $obj->starttime; ?>"/></td>
      
      <td align="right">LOCATION:</td>
      <td style="font-weight:bold;"><?php echo strtoupper($obj->branchname);?>
      <input type="text" readonly name="brancheid" id="brancheid" value="<?php echo $obj->brancheid; ?>"/>
      <input type="hidden" readonly name="personnel" id="personnel" value="<?php echo $obj->personnel; ?>"/>
      </td>
    </tr>
  </tbody>
</table>
</div>

  <div class="row">
    <div class="col-sm-8">
      <div class="panel panel-success">
        <div class="panel-heading">TEAM </div>
        
        
        
        <table class="table">
	  <thead>
	    <tr>
	      <th>ROLE</th>
	      <th>EMPLOYEE</th>
	      
	    </tr>
	  </thead>
	  
	  <tbody>
	        
	    <?php
	    $i=0;
	    $brancheteams = new Branchteams();
	    $fields="*, pos_teamroles.name teamroleid, pos_teamroles.id teamrole";
	    $join=" left join pos_teamroles on pos_teamroles.id=pos_branchteams.teamroleid ";
	    $having="";
	    $groupby="";
	    $orderby=" order by pos_teamroles.name ";
	    $where =" where pos_branchteams.brancheid='$obj->brancheid' ";
	    $brancheteams->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	    $res=$brancheteams->result;
	    while($row=mysql_fetch_object($res)){
	      $x=0;
	      $ids="";	      
	      while($x<$row->number){
	      //get team members
	      $id = substr($ids,0,-1);
	      $query="select pos_teamdetails.id, pos_teamdetails.employeeid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeename from pos_teamdetails left join pos_teams on pos_teamdetails.teamid=pos_teams.id left join hrm_employees on pos_teamdetails.employeeid=hrm_employees.id left join pos_shifts on pos_shifts.teamid=pos_teams.id where pos_teamdetails.teamroleid='$row->teamrole' and pos_shifts.id='$obj->shiftid' ";
	      
	      if(!empty($id))
		$query.=" and pos_teamdetails.id not in($id) ";
	      
	      $rs=mysql_query($query);
	      
	      $obj->employeename="";
	      $obj->employeeid="";
	      
	      if(mysql_affected_rows()>0){
		$rw=mysql_fetch_object($rs);	      
		$ids.=$rw->id.",";
		$obj->employeename=$rw->employeename;
	      }
	      ?>
		<tr>
		  <td><?php echo $row->teamroleid; ?> <?php echo ($x+1); ?></td>
		  <td>
		  <input type="text" id="employeename<?php echo ($i); ?>" name="employeename<?php echo ($i); ?>" value="<?php echo $obj->employeename; ?>"/>
		  <input type="hidden" id="employeeid<?php echo ($i); ?>" name="employeeid<?php echo ($i); ?>" value="<?php echo $obj->employeeid; ?>"/></td>
		</tr>
	      <?
	      $x++;
	      $i++;
	      }
	    
	    }
	    ?>
	    
	  </tbody>
	  
        </table>
	
	<table class="table" align="center">
	  <tbody>
	    <tr>
	      <td align='center'><input type="submit" class="btn btn-primary" name="action" id="action" value="NEW SHIFT"/></td>
	    </tr>
	  </tbody>
	</table>
	
	</div>
      </div>
     </div>
</div>

</form>
<?php 
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>