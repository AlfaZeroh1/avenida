<style>



</style>


<script type="text/javascript" charset="utf-8">
$(document).ready(function() {

 	$('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
// 		"sScrollY": 500,
		"bJQueryUI": true,
 		"iDisplayLength":1000,
		"sPaginationType": "full_numbers",
// 		"sScrollX": "100%",
// 		"sScrollXInner": "<?php echo $inner; ?>%",
		"bScrollCollapse": true,
		
		"aoColumnDefs": [
		                 { "bSortable": false, "aTargets": [ 1 ] }
		               ],
		"fnRowCallback": function( nRow, aaData, iDisplayIndex, oSettings ) {
			/* Need to redo the counters if filtered or sorted */
			if ( oSettings.bSorted || oSettings.bFiltered ) {
				for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ ) {
					this.fnUpdate( i+1, oSettings.aiDisplay[i], 0, false, false );
				}
			}
			for(var i=9; i<aaData.length;i++){
			if(i<9)
			  $('td:eq('+i+')', nRow).html(aaData[i]);
			else
			  $('td:eq('+i+')', nRow).html(aaData[i]).formatCurrency().attr('align','right');
			}
			return nRow;
		},
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
			$('th:eq(0)', nRow).html("");
			$('th:eq(1)', nRow).html("");
			$('th:eq(2)', nRow).html("TOTAL");
			var total=[];
			//var k=0;
			for(var i=0; i<aaData.length; i++){
			  //var k = aaData[i].length;
			  
			  for(var j=9; j<aaData[i].length; j++){
			    if(aaData[i][j]=='')
			      aaData[i][j]=0;			      
			      
			      if(i==0)
				total[j]=0;
				
				total[j] = parseFloat(total[j])+parseFloat(aaData[i][j]);	//alert(parseFloat(aaData[i][j]));	
			  }
			  
			}
			
			for(var i=9; i<total.length;i++){
			  $('th:eq('+i+')', nRow).html(total[i]).formatCurrency().attr('align','right');
			}
		}
	} );
$('#tbl_next').click();
$('#tbl_previous').click();
} );

function selectAll(str)
{
	if(str.checked)
	{//check all checkboxes under it
		
		<?php
		$employees = new Employees();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employees.statusid=1 and hrm_employees.id not in(select employeeid from hrm_employeepayments where month='$obj->month' and year='$obj->year')";
		$employees->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		
		while($rw=mysql_fetch_object($employees->result))
		{			
		?>
		if(document.getElementById("<?php echo $rw->id; ?>")){
			//alert("Success <?php echo $rw->id; ?>");
			document.getElementById("<?php echo $rw->id; ?>").checked=true;
			setEmployee("<?php echo $rw->id; ?>");
		}
		<?php		
		}
		?>
	}
	else
	{
		//uncheck all checkboxes under it
		<?php
		$employees = new Employees();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employees.statusid=1 and hrm_employees.id not in(select employeeid from hrm_employeepayments where month='$obj->month' and year='$obj->year')";
		$employees->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		
		while($rw=mysql_fetch_object($employees->result))
		{
		?>
		document.getElementById("<?php echo $rw->id; ?>").checked=false;
		setEmployee("<?php echo $rw->id; ?>");
		<?php
		}
		?>
	}
}

function setEmployee(id){
  //document.getElementById("quantity"+id).disable=false;
    
  if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
  else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {//alert(xmlhttp.responseText);
    //document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
  var url="sets.php?id="+id+"&checked="+$("#"+id).is(':checked');
  xmlhttp.open("GET",url,true);
  xmlhttp.send();
}

function Clickheretoprint(task)
{ 
	var msg;
	
	msg="Do you want to print Pay slips?";
	//var ans=confirm(msg);
	var ans = true;
	if(ans)
	{
		var elements = document.getElementsByTagName("input");
		for(i=0;i<elements.length;i++){
			if(elements[i].type=="checkbox" && !isNaN(elements[i].value)  && elements[i].checked==true){
				var id=elements[i].value;
				if(task=="print")
					poptastic("printpreview.php?id="+id+"&month=<?php echo $obj->month; ?>&year=<?php echo $obj->year?>&fromdate=<?php echo $obj->fromdate; ?>&todate=<?php echo $obj->todate; ?>",650,400);
				else
					poptastic("php.php?id="+id+"&month=<?php echo $obj->month; ?>&year=<?php echo $obj->year; ?>",650,400);
			}
		}
	}
}
</script>
		<form action="employeepayments_proc.php" method="post">
<div style="float:center;">
<hr>
<table class="table">
  <tr>
    <td><strong>Year:</strong></td>
    <td><select name="year" class="input-small">
          <option value="">Select...</option>
          <?php
	  $i=date("Y")-10;
	  while($i<date("Y")+10)
	  {
		?>
		  <option value="<?php echo $i; ?>" <?php if($obj->year==$i){echo"selected";}?>><?php echo $i; ?></option>
		  <?
	    $i++;
	  }
	  ?>
      </select></td>
    <td>Month:</td>
    <td><select name="month">
        <option value="">Select...</option>
        <option value="1" <?php if($obj->month==1){echo"selected";}?>>January</option>
        <option value="2" <?php if($obj->month==2){echo"selected";}?>>February</option>
        <option value="3" <?php if($obj->month==3){echo"selected";}?>>March</option>
        <option value="4" <?php if($obj->month==4){echo"selected";}?>>April</option>
        <option value="5" <?php if($obj->month==5){echo"selected";}?>>May</option>
        <option value="6" <?php if($obj->month==6){echo"selected";}?>>June</option>
        <option value="7" <?php if($obj->month==7){echo"selected";}?>>July</option>
        <option value="8" <?php if($obj->month==8){echo"selected";}?>>August</option>
        <option value="9" <?php if($obj->month==9){echo"selected";}?>>September</option>
        <option value="10" <?php if($obj->month==10){echo"selected";}?>>October</option>
        <option value="11" <?php if($obj->month==11){echo"selected";}?>>November</option>
        <option value="12" <?php if($obj->month==12){echo"selected";}?>>December</option>
      </select>
      </td>
    <td><strong>Bank:</strong></td>
    <td><select name="bankid">
    <option value="">Select...</option>
    <?php
    $banks=new Banks();
    $i=0;
    $fields="hrm_banks.id, hrm_banks.code, hrm_banks.name, hrm_banks.remarks, hrm_banks.createdby, hrm_banks.createdon, hrm_banks.lasteditedby, hrm_banks.lasteditedon";
    $join="";
    $having="";
    $groupby="";
    $orderby="";
    $banks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
    $res=$banks->result;
    while($row=mysql_fetch_object($res))
    {
    ?>
    <option value="<?php echo $row->id; ?>" <?php if($row->id==$obj->bankid){echo"selected";}?>><?php echo $row->name; ?></option>
    <?
    }
    ?>    
    </select> 
    </td>
    <td>Emp Type:</td>
    <td><select name="type" class="input-small">
      <option value="">Select...</option>
      <option value="1" <?php if($obj->type==1){echo"selected";}?>>Permanent</option>
      <option value="2" <?php if($obj->type==2){echo"selected";}?>>Casual</option>
    </select></td>
        <td>From :</td>
        <td><input type="text" name="fromdate" class="date_input" size="12" readonly value="<?php echo $obj->fromdate; ?>"/></td>
        <td>To :</td>
        <td><input type="text" name="todate" class="date_input" size="12" readonly value="<?php echo $obj->todate; ?>"/></td>
	<td>Department:</td>
    <?php
    
  $departments=new Departments();
  $i=0;
  $fields="hrm_departments.id, hrm_departments.name, hrm_departments.code, hrm_departments.leavemembers, hrm_departments.description, hrm_departments.createdby, hrm_departments.createdon, hrm_departments.lasteditedby, hrm_departments.lasteditedon";
  $join="";
  $having="";
  $groupby="";
  $orderby="";
  $where="";
  $departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $res=$departments->result;
  
    ?>
    <td><select name="departmentid" class="input-small">
  <option value="">All</option>
  <?php
	while($row=mysql_fetch_object($res))
	{
	?>
	<option value="<?php echo $row->id; ?>" <?php if($obj->departmentid==$row->id){echo"selected";}?>><?php echo $row->name; ?></option>
	<?
	}
  ?>
  </select></td>
  <td><input type="checkbox" name="allowances" value="1" <?php if($obj->allowances==1){echo "checked";}?> /> Allowances</td>
  <td><input type="checkbox" name="deductions" value="1" <?php if($obj->deductions==1){echo "checked";}?>/> Deductions</td>
  <?php if(empty($paydate)){?>
      <td><input type="submit" name="action" id="action" class="btn btn-primary btn-sm" value="Load" /></td>
      <?php }?>
  </tr>
  
</table>

</div>
<hr>
<div style="clear:both;"></div>

<table style="clear:both;"  width="100%" class="table display"  >
	<thead>
		<tr>
			<th>#</th>
			<th><input type="checkbox" onclick="selectAll(this);"/>All</th>
			<th>Employee </th>
			<th>Position </th>
			<th>Bank </th>
			<th>Bank Branch </th>
			<th>Clearing Code </th>
			<th>Bank Account </th>
			<th>Reference </th>
			<th>Days</th>
			<th class="sum">Basic </th>
			<?php
			$arrears = new Arrears();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where id in(select arrearid from hrm_employeearrears where month='$obj->month' and year='$obj->year') and hrm_arrears.taxable='Yes'";
			$arrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$res=$arrears->result;
			$x=0;
			while($row=mysql_fetch_object($res)){
			  
			  $employeearrears = new Employeearrears();
			    $fields="*";
			    $join=" ";
			    $where=" where hrm_employeearrears.arrearid='$row->id' and hrm_employeearrears.month='$obj->month' and hrm_employeearrears.year='$obj->year'";
			    $having="";
			    $groupby="";
			    $orderby="";
			    $employeearrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			    //$employeearrears = $employeearrears->fetchObject;
			    if($employeearrears->affectedRows>0){
			  ?>
			  <th class="sum"><?php echo $row->name; ?></th>
			  <?php
			  $x++;
			  }
			}
			?>
			<?php if($x>0){?>
			<th>Total Arrears</th>
			<?php }?>
			
			<?php 
			if($obj->allowances==1){
			$allowances=new Allowances();
			$fields="hrm_allowances.id, hrm_allowances.name, hrm_allowances.amount, hrm_allowances.percentaxable, hrm_allowancetypes.name as allowancetypeid, hrm_allowances.overall, hrm_allowances.frommonth, hrm_allowances.fromyear, hrm_allowances.tomonth, hrm_allowances.toyear, hrm_allowances.status, hrm_allowances.createdby, hrm_allowances.createdon, hrm_allowances.lasteditedby, hrm_allowances.lasteditedon";
			$join=" left join hrm_allowancetypes on hrm_allowances.allowancetypeid=hrm_allowancetypes.id ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where  hrm_allowances.status='active'";
			$allowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$res=$allowances->result;
			while($row=mysql_fetch_object($res)){
			  if($row->id==3){
			    //retrieve all overtimes
			    $overtimes = new Overtimes();
			    $fields="*";
			    $join=" ";
			    $where=" ";
			    $having="";
			    $groupby="";
			    $orderby="";
			    $overtimes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			    while($ov=mysql_fetch_object($overtimes->result)){
			      
			      ?>
				      <th class="sum"><?php echo initialCap($ov->name); ?></th>
				      <th class="sum">Amnt</th>
			      <?php 
			      
			    }
			  }else{
			?>
				<th class="sum"><?php echo initialCap($row->name); ?></th>
			<?php 
			}
			}
			}
			?>
			<th class="sum">Total Allowances</th>
			<th class="sum">Gross Pay</th>
			<?php 
			if($obj->deductions==1){
			$deductions=new Deductions();
			$fields="hrm_deductions.id, hrm_deductions.name, hrm_deductiontypes.name as deductiontypeid, hrm_deductions.frommonth, hrm_deductions.fromyear, hrm_deductions.tomonth, hrm_deductions.toyear, hrm_deductions.amount, hrm_deductions.overall, hrm_deductions.status, hrm_deductions.createdby, hrm_deductions.createdon, hrm_deductions.lasteditedby, hrm_deductions.lasteditedon";
			$join=" left join hrm_deductiontypes on hrm_deductions.deductiontypeid=hrm_deductiontypes.id ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where  hrm_deductions.status='active'";
			$deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$res=$deductions->result;
			while($row=mysql_fetch_object($res)){
			
			
			if($row->id==4){
			  $loans = new Loans();
			  $fields="*";
			  $join="";
			  $having="";
			  $groupby="";
			  $orderby="";
			  $where=" ";
			  $loans->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			  $ress=$loans->result;
			  while($roww=mysql_fetch_object($ress)){
				  ?>
						  <th class="sum"><?php echo $roww->name; ?></th>						
						  <th class="sum"><?php echo $roww->name; ?> Interest</th>
					  <?php
					  }
			 }
			 elseif($row->id==5){
			  continue;
			 }
			 else{
			?>
				<th class="sum"><?php echo $row->name; ?></th>
			<?php
			}
			}
			
			
					
					$surchages = new Surchages();
					$fields="*";
					$join="";
					$having="";
					$groupby="";
					$orderby="";
					$where=" ";
					$surchages->retrieve($fields,$join,$where,$having,$groupby,$orderby);
					$res=$surchages->result;
					while($row=mysql_fetch_object($res)){
						?>
							<th class="sum"><?php echo $row->name; ?></th>		
						<?php
						}
			}
			
			?>
			<th class="sum">Total Deductions</th>
			<?php
			$arrears = new Arrears();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where id in(select arrearid from hrm_employeearrears where month='$obj->month' and year='$obj->year') and hrm_arrears.taxable='No'";
			$arrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$res=$arrears->result;
			$x=0;
			while($row=mysql_fetch_object($res)){
			  
			  $employeearrears = new Employeearrears();
			    $fields="*";
			    $join=" ";
			    $where=" where hrm_employeearrears.arrearid='$row->id' and hrm_employeearrears.month='$obj->month' and hrm_employeearrears.year='$obj->year'";
			    $having="";
			    $groupby="";
			    $orderby="";
			    $employeearrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			    //$employeearrears = $employeearrears->fetchObject;
			    if($employeearrears->affectedRows>0){
			    ?>
			  <th class="sum"><?php echo $row->name; ?></th>
			  <?php
			  $x++;
			  }
			  
			}
			?>
			<?php if($x>0){?>
			<th class="sum">Total Arrears</th>
			<?php }?>
			<th class="sum">Net Pay</th>
		</tr>
	</thead>
	<tbody>
	<?php
		if($obj->action=="Load"){
		$i=0;
		$fields="hrm_employees.id, hrm_employees.type, hrm_employees.pfnum, concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) employeeid, hrm_employees.gender, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_nationalitys.name as nationalityid, hrm_countys.name as countyid, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employeebanks.name as bankid, hrm_bankbranches.name as bankbrancheid, hrm_employees.bankacc, hrm_bankbranches.code clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_assignments.name as assignmentid, hrm_grades.name as gradeid, hrm_employeestatuss.name as statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon";
		$join=" left join hrm_nationalitys on hrm_employees.nationalityid=hrm_nationalitys.id  left join hrm_countys on hrm_employees.countyid=hrm_countys.id  left join hrm_employeebanks on hrm_employees.employeebankid=hrm_employeebanks.id  left join hrm_bankbranches on hrm_employees.bankbrancheid=hrm_bankbranches.id  left join hrm_assignments on hrm_employees.assignmentid=hrm_assignments.id  left join hrm_grades on hrm_employees.gradeid=hrm_grades.id  left join hrm_employeestatuss on hrm_employees.statusid=hrm_employeestatuss.id ";
		$having="";
		$groupby="";
		$orderby=" order by hrm_employees.pfnum asc ";
		$where=" where hrm_employees.statusid=1 and case when hrm_employees.type=1 then hrm_employees.id not in(select employeeid from hrm_employeepayments where month='$obj->month' and year='$obj->year') else hrm_employees.id not in(select employeeid from hrm_employeepayments where fromdate between '$obj->fromdate' and '$obj->todate' or todate between '$obj->fromdate' and '$obj->todate') end ".$wh;
		$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employees->sql;
		$res=$employees->result;
		while($row=mysql_fetch_object($res)){
		$i++;
		
		$employeeclockings = new Employeeclockings();
		if($row->type==2){
			
		  
		  $fields="count(distinct today) days";
		  $join=" ";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $where=" where employeeid='$row->id' and today between '$obj->fromdate' and '$obj->todate' ";
		  $employeeclockings->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  
		  //if($employeeclockings->affectedRows>=0){
		  $employeeclockings = $employeeclockings->fetchObject;
		    //continue;
		  //}
		  $employeeclocking = new Employeeclockings();
		  $fields="sum(amount) basic";
		  $join=" ";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $where=" where employeeid='$row->id' and today between '$obj->fromdate' and '$obj->todate' ";
		  $employeeclocking->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  
		  //if($employeeclockings->affectedRows>=0){
		  $employeeclocking = $employeeclocking->fetchObject;
		  
		  $row->basic=$employeeclocking->basic;
		}
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><input name="<?php echo $row->id; ?>" type="checkbox" id="<?php echo $row->id; ?>"  value="<?php echo $row->id; ?>"  /></td>
			<td><?php echo $row->pfnum; ?>&nbsp;<?php echo $row->employeeid; ?></td>
			<td><?php echo $row->assignmentid; ?></td>
			<td><?php echo $row->bankid; ?></td>
			<td><?php echo $row->bankbrancheid; ?></td>
			<td><?php echo $row->clearingcode; ?></td>
			<td><?php echo $row->bankacc; ?></td>
			<td><?php echo $row->ref; ?></td>
			<td><?php echo $employeeclockings->days; ?></td>
			<td align="right"><?php echo $row->basic; ?></td>
			
			<?php
			$totalarrears=0;
			$arrears = new Arrears();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where id in(select arrearid from hrm_employeearrears where month='$obj->month' and year='$obj->year') and hrm_arrears.taxable='Yes'";
			$arrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			//$res=$arrears->result;
			$x=0;
			while($r=mysql_fetch_object($arrears->result)){
			
			   $employeearrears = new Employeearrears();
			    $fields="*";
			    $join=" ";
			    $where=" where hrm_employeearrears.arrearid='$r->id' and hrm_employeearrears.employeeid='$row->id' and hrm_employeearrears.month='$obj->month' and hrm_employeearrears.year='$obj->year'";
			    $having="";
			    $groupby="";
			    $orderby="";
			    $employeearrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			    $employeearrears = $employeearrears->fetchObject;
			    
			    $totalarrears+=$employeearrears->amount;
			  ?>
			  <td><?php echo $employeearrears->amount; ?></td>
			  <?php
			  $x++;
			}
			?>
			<?php if($x>0){?>
			<td><?php echo $totalarrears; ?></td>
			<?php }?>
			
			<?php 
			$totalallowances = 0;
			$taxable=$row->basic;
			$allowances=new Allowances();
			$fields="hrm_allowances.id, hrm_allowances.name, hrm_allowances.amount, hrm_allowances.percentaxable, hrm_allowances.allowancetypeid, hrm_allowancetypes.repeatafter, hrm_allowances.overall, hrm_allowances.frommonth, hrm_allowances.fromyear, hrm_allowances.tomonth, hrm_allowances.toyear, hrm_allowances.status, hrm_allowances.createdby, hrm_allowances.createdon, hrm_allowances.lasteditedby, hrm_allowances.lasteditedon";
			$join=" left join hrm_allowancetypes on hrm_allowances.allowancetypeid=hrm_allowancetypes.id ";
			$having="";
			$groupby="";
			$orderby="";
			//to ensure that the allowance is active
			$where=" where  hrm_allowances.status='active'";
			$allowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			while($rw=mysql_fetch_object($allowances->result)){
			$allowance=0;
			$now=getDates($obj->year, $obj->month, 01);
				//check allowances that affect all
				if($rw->overall=="All"){
					//check if the to date is reached
					$fromdate=getDates($rw->fromyear, $rw->frommonth, 01);
					$todate=getDates($rw->toyear, $rw->tomonth, 01);	
					if(!empty($rw->toyear) and !empty($rw->tomonth)){
					  if($now>=$fromdate and $now<=$todate){
							  //check frequency qualifier
							  $employeepaidallowances=new Employeepaidallowances();
							  $fields="hrm_employeepaidallowances.id, hrm_employeepayments.id employeepaymentid, hrm_employeepaidallowances.allowanceid, hrm_employeepaidallowances.employeeid, hrm_employeepaidallowances.amount, hrm_employeepaidallowances.month, hrm_employeepaidallowances.year, hrm_employeepaidallowances.createdby, hrm_employeepaidallowances.createdon, hrm_employeepaidallowances.lasteditedby, hrm_employeepaidallowances.lasteditedon";
							  $join=" left join hrm_employeepayments on hrm_employeepaidallowances.employeepaymentid=hrm_employeepayments.id ";
							  $where=" where hrm_employeepaidallowances.employeeid=$row->id and hrm_employeepaidallowances.allowanceid=$rw->id ";
							  $having="";
							  $groupby="";
							  $orderby=" order by hrm_employeepaidallowances.id desc";
							  $employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
							  $employeepaidallowances->fetchObject;
							  $next=getDates($employeepaidallowances->year, $employeepaidallowances->month+$row->repeatafter, 01);
							  if($next<=$now){
								  $allowance=$rw->amount;
								  $taxable+=($rw->amount*$rw->percentaxable);
							  }
							  else{
								  $allowance=0;
							  }
					  }
					  else{
						  $allowance=0;
					  }
					}
					else{
					  $allowance=$rw->amount;
					  $taxable+=($rw->amount*$rw->percentaxable);
					}
					if($obj->allowances==1){
					  ?>
						  <td align="right"><?php echo $allowance;  ?></td>
					  <?php 
					  }
				}
				//check employee specific allowances
				else{
					if($rw->id==3){
					  //retrieve all overtimes
					  $overtimes = new Overtimes();
					  $fields="*";
					  $join=" ";
					  $where=" ";
					  $having="";
					  $groupby="";
					  $orderby="";
					  $overtimes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
					  while($ov=mysql_fetch_object($overtimes->result)){
					    $employeeovertimes = new Employeeovertimes();
					    $fields="sum(hours) hrs, sum(hours) hours";
					    $join=" ";
					    $where=" where overtimeid='$ov->id' and employeeid='$row->id' and month='$obj->month' and year='$obj->year' ";
					    $having="";
					    $groupby="";
					    $orderby="";
					    $employeeovertimes->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employeeovertimes->sql;
					    $employeeovertimes = $employeeovertimes->fetchObject;
					    
					    $employeeovertimes->amount=($row->basic/ ($ov->hrs*52/12) *$ov->value)*$employeeovertimes->hrs;
					    $taxable+=($employeeovertimes->amount*$rw->percentaxable);
					    $allowance=$employeeovertimes->amount;
					    if($obj->allowances==1){
					    ?>
						    <td align="right"><?php echo $employeeovertimes->hrs;  ?> </td>
						    <td align="right"><?php echo $employeeovertimes->amount;  ?> </td>
					    <?php 
					    }
					    $totalallowances+=$allowance;
					  }
					  
					}else{
					  $employeeallowances=new Employeeallowances();
					  $fields="hrm_employeeallowances.id, hrm_allowances.name as allowanceid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hrm_allowancetypes.name as allowancetypeid, hrm_employeeallowances.amount amount, hrm_employeeallowances.frommonth, hrm_employeeallowances.fromyear, hrm_employeeallowances.tomonth, hrm_employeeallowances.toyear, hrm_employeeallowances.remarks, hrm_employeeallowances.createdby, hrm_employeeallowances.createdon, hrm_employeeallowances.lasteditedby, hrm_employeeallowances.lasteditedon";
					  $join=" left join hrm_allowances on hrm_employeeallowances.allowanceid=hrm_allowances.id  left join hrm_employees on hrm_employeeallowances.employeeid=hrm_employees.id  left join hrm_allowancetypes on hrm_employeeallowances.allowancetypeid=hrm_allowancetypes.id ";
					  $having="";
					  $groupby="";
					  $orderby="";
					  //checks if allowance is still active
					  $where=" where hrm_employeeallowances.employeeid=$row->id and hrm_employeeallowances.allowanceid=$rw->id ";
					   if($rw->allowancetypeid==2){
					    $date=date("Y-m-d",mktime(0,0,0,$obj->month,01,$obj->year));
					    
					    $where.=" and str_to_date('$date','%Y-%m-%d') between str_to_date(concat(concat(01,concat('-',hrm_employeeallowances.frommonth)),concat('-',hrm_employeeallowances.fromyear)),'%d-%m-%Y') and str_to_date(concat(concat(01,concat('-',hrm_employeeallowances.tomonth)),concat('-',hrm_employeeallowances.toyear)),'%d-%m-%Y') ";
					  }
					  $employeeallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);//if($row->id==8)echo $employeeallowances->sql.";<br/>";
					  $employeeallowances = $employeeallowances->fetchObject;
					  
					  if(!empty($employeeallowances->tomonth) and !empty($employeeallowances->toyear)){
					    $start=getDates($employeeallowances->fromyear, $employeeallowances->frommonth, 01);
					    $todate=getDates($employeeallowances->toyear, $employeeallowances->tomonth, 01);
					    $next=getDates($employeeallowances->year, $employeeallowances->month+$rw->repeatafter, 01);
					    if($now>=$start and $now<=$todate){
						    $allowance=$employeeallowances->amount;
						    $taxable+=($employeeallowances->amount*$rw->percentaxable);
					    }
					    else{
						    $allowance=0;
					    }
					  }
					  else{
					    $allowance=$employeeallowances->amount;
					    $taxable+=($employeeallowances->amount*$rw->percentaxable);
					  }
					  
					  if($obj->allowances==1){
					  ?>
						  <td align="right"><?php echo $allowance;  ?></td>
					  <?php 
					  }
					  $totalallowances+=$allowance;
				      }
				}
				
			
			}
			if($row->type==2){
			  $basic=$row->basic;
			}else{
			  $basic=$row->basic;
			}
			$grosspay=$basic+$totalallowances+$totalarrears;
			?>
			<td align="right"><?php echo $totalallowances; ?></td>
			<td align="right"><?php echo $grosspay; ?></td>
			<?php 
			$totaldeductions = 0;
			$employeedeductionexempt=new Employeedeductionexempt();
			$deductions=new Deductions();
			$fields="hrm_deductions.id, hrm_deductions.name, hrm_deductions.amount, hrm_deductions.deductiontypeid, hrm_deductiontypes.repeatafter, hrm_deductions.overall, hrm_deductions.frommonth, hrm_deductions.fromyear, hrm_deductions.tomonth, hrm_deductions.toyear, hrm_deductions.status, hrm_deductions.createdby, hrm_deductions.createdon, hrm_deductions.lasteditedby, hrm_deductions.lasteditedon";
			$join=" left join hrm_deductiontypes on hrm_deductions.deductiontypeid=hrm_deductiontypes.id ";
			$having="";
			$groupby="";
			$orderby="";
			//to ensure that the deduction is active
			$where=" where  hrm_deductions.status='active'";
			$deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();//echo $deductions->sql;
			while($rw=mysql_fetch_object($deductions->result)){
			$deduction=0;
			$now=getDates($obj->year, $obj->month, 01);
				//check deductions that affect all
				if($rw->id==1){
					//get PAYE
					if(!$employeedeductionexempt->checkEmployeeDEductionStatus($rw->id,$row->id,$obj->month,$obj->year) and $row->type!=2)
					{
					$payes = new Payes();
					//get NSSF
					$nssfs = new Nssfs();
					$taxable=$payes->getTaxable($taxable, $row->id, $obj);//$taxable-$nssfs->getNSSF($grosspay);
					$deduction=$payes->getPAYE($taxable,$row->id,$obj);
					}
					//if($row->id==276)echo $taxable." == ".$deduction."<br/>";
				}
				elseif ($rw->id==2){
					//get NHIF
					if(!$employeedeductionexempt->checkEmployeeDEductionStatus($rw->id,$row->id,$obj->month,$obj->year) and $row->type!=2)
					{
					$nhifs = new Nhifs();
					$deduction=$nhifs->getNHIF($grosspay);//if($row->id==276)echo $taxable." == ".$deduction."<br/>";
					}
				}
				elseif ($rw->id==3){				         
					//get NSSF
					if(!$employeedeductionexempt->checkEmployeeDEductionStatus($rw->id,$row->id,$obj->month,$obj->year) and $row->type!=2)
					{
					$nssfs = new Nssfs();
					$deduction=$nssfs->getNSSF($grosspay);//if($row->id==276)echo $taxable." == ".$deduction."<br/>";
					}
				}
				elseif($rw->overall=="All" and ($rw->id!=1 and $rw->id!=2 and $rw->id!=3)){ 
					//check if the to date is reached
					$fromdate=getDates($rw->fromyear, $rw->frommonth, 01);
					$todate=getDates($rw->toyear, $rw->tomonth, 01);
					if(!empty($rw->toyear) and !empty($rw->tomonth)){
					  if($now>=$fromdate and $now<=$todate){
							  //check frequency qualifier
							  $employeepaiddeductions=new Employeepaiddeductions();
							  $fields="hrm_employeepaiddeductions.id, hrm_employeepayments.id employeepaymentid, hrm_employeepaiddeductions.deductionid, hrm_employeepaiddeductions.employeeid, hrm_employeepaiddeductions.amount, hrm_employeepaiddeductions.month, hrm_employeepaiddeductions.year, hrm_employeepaiddeductions.createdby, hrm_employeepaiddeductions.createdon, hrm_employeepaiddeductions.lasteditedby, hrm_employeepaiddeductions.lasteditedon";
							  $join=" left join hrm_employeepayments on hrm_employeepaiddeductions.employeepaymentid=hrm_employeepayments.id ";
							  $where=" where hrm_employeepaiddeductions.employeeid=$row->id and hrm_employeepaiddeductions.deductionid=$rw->id ";
							  $having="";
							  $groupby="";
							  $orderby=" order by hrm_employeepaiddeductions.id desc";
							  $employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
							  $employeepaiddeductions->fetchObject;
							  
							  $next=getDates($employeepaiddeductions->year, $employeepaiddeductions->month+$rw->repeatafter, 01);
							  if($now>=$next){
								  $deduction=$rw->amount;
							  }
							  else{
								  $deduction=0;
							  }
					  }
					  else{
						  $deduction=0;
					  }
					}
					else{
					  $deduction=$rw->amount;
					}
				}
				//check employee specific deductions
				else{
					 $employeedeductions=new Employeedeductions();
					  $fields="hrm_employeedeductions.id, hrm_deductions.name as deductionid, hrm_deductions.deductiontype, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hrm_deductiontypes.name as deductiontypeid, sum(hrm_employeedeductions.amount) amount, hrm_employeedeductions.frommonth, hrm_employeedeductions.fromyear, hrm_employeedeductions.tomonth, hrm_employeedeductions.toyear, hrm_employeedeductions.remarks, hrm_employeedeductions.createdby, hrm_employeedeductions.createdon, hrm_employeedeductions.lasteditedby, hrm_employeedeductions.lasteditedon";
					  $join=" left join hrm_deductions on hrm_employeedeductions.deductionid=hrm_deductions.id  left join hrm_employees on hrm_employeedeductions.employeeid=hrm_employees.id  left join hrm_deductiontypes on hrm_employeedeductions.deductiontypeid=hrm_deductiontypes.id ";
					  $having="";
					  $groupby=" group by deductionid ";
					  $orderby="";
					  //checks if deduction is still active
					  $where=" where hrm_employeedeductions.employeeid=$row->id and hrm_employeedeductions.deductionid=$rw->id ";
					  if($rw->deductiontypeid==1){
					    $date=date("Y-m-d",mktime(0,0,0,$obj->month,01,$obj->year));
					    
					    $where.=" and str_to_date('$date','%Y-%m-%d') between str_to_date(concat(concat(01,concat('-',hrm_employeedeductions.frommonth)),concat('-',hrm_employeedeductions.fromyear)),'%d-%m-%Y') and str_to_date(concat(concat(01,concat('-',hrm_employeedeductions.tomonth)),concat('-',hrm_employeedeductions.toyear)),'%d-%m-%Y') ";
					  }
					  $employeedeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);//if($row->id==5 and $rw->id==29){echo $employeedeductions->sql."<br/>";}
					  $employeedeductions = $employeedeductions->fetchObject;
					  
					$fromdate=getDates($employeedeductions->fromyear, $employeedeductions->frommonth, 01);
					$todate=getDates($employeedeductions->toyear, $employeedeductions->tomonth, 01);	//if($row->id==18 and $rw->id==7){echo $fromdate." = ".$now." = ".$todate."<br/>";}
					if($now>=$fromdate and $now<=$todate){
					  $next=getDates($employeedeductions->fromyear, ($employeedeductions->frommonth+$row->repeatafter), 01,$row->id);
					  if($next<=$now){//if($row->id==1)echo $employeedeductions->deductionid." == ".$employeedeductions->deductiontype;
						  if($employeedeductions->deductiontype=="%")
						    $deduction=$employeedeductions->amount*$basic;
						  else
						    $deduction=$employeedeductions->amount;
					  }
					  else{
						  $deduction=0;
					  }
					}else{
					  $deduction=0;
					}
				}
								
				if($rw->id==4){
				  $loans = new Loans();
				  $fields="*";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $where="";
				  $loans->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				  while($wr=mysql_fetch_object($loans->result)){
					  $employeeloans = new Employeeloans();
					  $fields="*";
					  $join="";
					  $having="";
					  $groupby="";
					  $orderby=" order by id desc limit 1 ";
					  $where=" where employeeid='$row->id' and loanid='$wr->id' and principal>0 ";
					  $employeeloans->retrieve($fields, $join, $where, $having, $groupby, $orderby); 
					  if($employeeloans->affectedRows>0){
						  while($rww=mysql_fetch_object($employeeloans->result)){		
							  if($rww->principal>$rww->payable)
							    $deduction=$rww->payable;
							  else	
							    $deduction=$rww->principal;
							    
							  $totaldeductions+=$deduction;
							  if($obj->deductions==1){
								  ?>
								  <td align="right"><?php echo $deduction;  ?></td>
								  <?php 
								  }
								  if(strtolower($rww->interesttype)=="amount"){
								    $deduction=$rww->interest;
								  }
								  else{
								    if($rww->method=="straight-line")
									    $deduction=$rww->interest*$rww->initialvalue*$rww->duration/100;
								    elseif($rww->method=="reducing balance")
									    $deduction=$rww->interest*$rww->principal/100;	
									    
								    }
								  
								  $totaldeductions+=$deduction;
								  if($obj->deductions==1){
								  ?>
								  <td align="right"><?php echo $deduction;  ?></td>
								  <?php 
								  }
						  }
					  }
					  else{
					  
						  if($obj->deductions==1){
						  ?>
						  <td align="right"><?php echo 0;  ?></td>
						  <td align="right"><?php echo 0;  ?></td>
						  <?php 
						  }
					  }
				  }
				 }
				 elseif($rw->id==5){
				  continue;
				 }
				 else{
				
				  $employeedeductions=new Employeedeductions();
					$fields="hrm_employeedeductions.id, hrm_deductions.deductiontype, hrm_deductions.name as deductionid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hrm_deductiontypes.name as deductiontypeid, hrm_employeedeductions.amount, hrm_employeedeductions.frommonth, hrm_employeedeductions.fromyear, hrm_employeedeductions.tomonth, hrm_employeedeductions.toyear, hrm_employeedeductions.remarks, hrm_employeedeductions.createdby, hrm_employeedeductions.createdon, hrm_employeedeductions.lasteditedby, hrm_employeedeductions.lasteditedon";
					$join=" left join hrm_deductions on hrm_employeedeductions.deductionid=hrm_deductions.id  left join hrm_employees on hrm_employeedeductions.employeeid=hrm_employees.id  left join hrm_deductiontypes on hrm_employeedeductions.deductiontypeid=hrm_deductiontypes.id ";
					$having="";
					$groupby="";
					$orderby="";
					//checks if deduction is still active
					$where=" where hrm_employeedeductions.employeeid=$row->id and hrm_employeedeductions.deductionid=$rw->id ";
					  if($rw->deductiontypeid==1){
					    $date=date("Y-m-d",mktime(0,0,0,$obj->month,01,$obj->year));
					    
					    $where.=" and str_to_date('$date','%Y-%m-%d') between str_to_date(concat(concat(01,concat('-',hrm_employeedeductions.frommonth)),concat('-',hrm_employeedeductions.fromyear)),'%d-%m-%Y') and str_to_date(concat(concat(01,concat('-',hrm_employeedeductions.tomonth)),concat('-',hrm_employeedeductions.toyear)),'%d-%m-%Y') ";
					  }
					$employeedeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
					$employeedeductions = $employeedeductions->fetchObject;
					//if(!empty($employeedeductions->tomonth) and !empty($employeedeductions->toyear)){
					  $start=getDates($employeedeductions->fromyear, $employeedeductions->frommonth, 01);
					  $todate=getDates($employeedeductions->toyear, $employeedeductions->tomonth, 01);
					  
					  
					  $employeepaiddeductions=new Employeepaiddeductions();
					  $fields="hrm_employeepaiddeductions.id, hrm_employeepayments.id employeepaymentid, hrm_employeepaiddeductions.deductionid, hrm_employeepaiddeductions.employeeid, hrm_employeepaiddeductions.amount, hrm_employeepaiddeductions.month, hrm_employeepaiddeductions.year, hrm_employeepaiddeductions.createdby, hrm_employeepaiddeductions.createdon, hrm_employeepaiddeductions.lasteditedby, hrm_employeepaiddeductions.lasteditedon";
					  $join=" left join hrm_employeepayments on hrm_employeepaiddeductions.employeepaymentid=hrm_employeepayments.id ";
					  $where=" where hrm_employeepaiddeductions.employeeid=$row->id and hrm_employeepaiddeductions.deductionid=$rw->id ";
					  $having="";
					  $groupby="";
					  $orderby=" order by hrm_employeepaiddeductions.id desc";
					  $employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
					  $employeepaiddeductions->fetchObject;
					  
					  $next=getDates($employeepaiddeductions->year, $employeepaiddeductions->month+$rw->repeatafter, 01);
					 if($rw->id!=1 and $rw->id!=2 and $rw->id!=3)
					 {
					  if($now>=$start and $now<=$todate and $next>=$now){
						  if($employeedeductions->deductiontype=="%"){
						    $deduction=$rw->amount*$basic/100;
						  }
						  else
						    $deduction=$employeedeductions->amount;
					//if($row->id==33)echo $employeedeductions->deductionid." == ".$employeedeductions->deductiontype." == ".$deduction."=".$rw->amount."*".$basic;	 
					}
					}
				  $totaldeductions+=$deduction;
				  if($obj->deductions==1){
				  ?>
					  <td align="right"><?php echo $deduction;  ?></td>
				  <?php 
				  }
				 }
			}
						
			$surchages = new Surchages();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where status='Active'";
			$surchages->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			while($wr=mysql_fetch_object($surchages->result)){
				$employeesurchages = new Employeesurchages();
				$fields="sum(amount) amount";
				$join="";
				$having="";
				$groupby=" ";
				$orderby="";
				$where=" where employeeid='$row->id' and surchageid='$wr->id' ";
				$date=date("Y-m-d",mktime(0,0,0,$obj->month,01,$obj->year));
					    
					    $where.=" and str_to_date('$date','%Y-%m-%d') between str_to_date(concat(concat(01,concat('-',frommonth)),concat('-',fromyear)),'%d-%m-%Y') and str_to_date(concat(concat(01,concat('-',tomonth)),concat('-',toyear)),'%d-%m-%Y') ";
				$employeesurchages->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				if($employeesurchages->affectedRows>0){
					while($rw=mysql_fetch_object($employeesurchages->result)){
						$deduction=$rw->amount;
						$totaldeductions+=$deduction;
						if($obj->deductions==1){
						?>
						<td align="right"><?php echo $deduction;  ?></td>
						<?php 
						}
					}
				}
				else{
 					if($obj->deductions==1){
				?>
					<td align="right"><?php echo 0;  ?></td>
					<?php 
 					}
				}
			}
			
			?>
			<td align="right"><?php echo $totaldeductions; ?></td>
			<?php
			$totalarrears1=0;
			$arrears = new Arrears();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where id in(select arrearid from hrm_employeearrears where month='$obj->month' and year='$obj->year') and hrm_arrears.taxable='No'";
			$arrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			//$res=$arrears->result;
			$x=0;
			while($r=mysql_fetch_object($arrears->result)){
			
			   $employeearrears = new Employeearrears();
			    $fields="*";
			    $join=" ";
			    $where=" where hrm_employeearrears.arrearid='$r->id' and hrm_employeearrears.employeeid='$row->id' and hrm_employeearrears.month='$obj->month' and hrm_employeearrears.year='$obj->year'";
			    $having="";
			    $groupby="";
			    $orderby="";
			    $employeearrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			    $employeearrears = $employeearrears->fetchObject;
			    
			    $totalarrears1+=$employeearrears->amount;
			  ?>
			  <td><?php echo $employeearrears->amount; ?></td>
			  <?php
			  $x++;
			}
			?>
			<?php if($x>0){?>
			<td><?php echo $totalarrears1; ?></td>
			<?php }
			$netpay=$grosspay-$totaldeductions+$totalarrears1;
			?>
			<td align="right"><?php echo $netpay;?></td>
		</tr>
	<?php 
	}
	}
	?>
	</tbody>
	<tfoot>
	<tr>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp; </th>
			<th>&nbsp; </th>
			<th>&nbsp; </th>
			<th>&nbsp; </th>
			<th>&nbsp;</th>
			<th>&nbsp; </th>
			<th>&nbsp; </th>
			<th>&nbsp;</th>
			<th>&nbsp; </th>
			<?php
			$arrears = new Arrears();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where id in(select arrearid from hrm_employeearrears where month='$obj->month' and year='$obj->year') and hrm_arrears.taxable='Yes'";
			$arrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$res=$arrears->result;
			$x=0;
			while($row=mysql_fetch_object($res)){
			  
			  $employeearrears = new Employeearrears();
			    $fields="*";
			    $join=" ";
			    $where=" where hrm_employeearrears.arrearid='$row->id' and hrm_employeearrears.month='$obj->month' and hrm_employeearrears.year='$obj->year'";
			    $having="";
			    $groupby="";
			    $orderby="";
			    $employeearrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			    //$employeearrears = $employeearrears->fetchObject;
			    if($employeearrears->affectedRows>0){
			  ?>
			  <th>&nbsp;</th>
			  <?php
			  $x++;
			  }
			}
			?>
			<?php if($x>0){?>
			<th>&nbsp;</th>
			<?php }?>
			
			<?php 
			if($obj->allowances==1){
			$allowances=new Allowances();
			$fields="hrm_allowances.id, hrm_allowances.name, hrm_allowances.amount, hrm_allowances.percentaxable, hrm_allowancetypes.name as allowancetypeid, hrm_allowances.overall, hrm_allowances.frommonth, hrm_allowances.fromyear, hrm_allowances.tomonth, hrm_allowances.toyear, hrm_allowances.status, hrm_allowances.createdby, hrm_allowances.createdon, hrm_allowances.lasteditedby, hrm_allowances.lasteditedon";
			$join=" left join hrm_allowancetypes on hrm_allowances.allowancetypeid=hrm_allowancetypes.id ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where  hrm_allowances.status='active'";
			$allowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$res=$allowances->result;
			while($row=mysql_fetch_object($res)){
			  if($row->id==3){
			    //retrieve all overtimes
			    $overtimes = new Overtimes();
			    $fields="*";
			    $join=" ";
			    $where=" ";
			    $having="";
			    $groupby="";
			    $orderby="";
			    $overtimes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			    while($ov=mysql_fetch_object($overtimes->result)){
			      
			      ?>
				      <th>&nbsp;</th>
				      <th>&nbsp;</th>
			      <?php 
			      
			    }
			  }else{
			?>
				<th>&nbsp;</th>
			<?php 
			}
			}
			}
			?>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<?php 
			if($obj->deductions==1){
			$deductions=new Deductions();
			$fields="hrm_deductions.id, hrm_deductions.name, hrm_deductiontypes.name as deductiontypeid, hrm_deductions.frommonth, hrm_deductions.fromyear, hrm_deductions.tomonth, hrm_deductions.toyear, hrm_deductions.amount, hrm_deductions.overall, hrm_deductions.status, hrm_deductions.createdby, hrm_deductions.createdon, hrm_deductions.lasteditedby, hrm_deductions.lasteditedon";
			$join=" left join hrm_deductiontypes on hrm_deductions.deductiontypeid=hrm_deductiontypes.id ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where  hrm_deductions.status='active'";
			$deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$res=$deductions->result;
			while($row=mysql_fetch_object($res)){
			
			
			if($row->id==4){
			  $loans = new Loans();
			  $fields="*";
			  $join="";
			  $having="";
			  $groupby="";
			  $orderby="";
			  $where=" ";
			  $loans->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			  $ress=$loans->result;
			  while($roww=mysql_fetch_object($ress)){
				  ?>
						  <th>&nbsp;</th>						
						  <th>&nbsp;</th>
					  <?php
					  }
			 }
			 elseif($row->id==5){
			  continue;
			 }
			 else{
			?>
				<th>&nbsp;</th>
			<?php
			}
			}
			
			
					
					$surchages = new Surchages();
					$fields="*";
					$join="";
					$having="";
					$groupby="";
					$orderby="";
					$where=" ";
					$surchages->retrieve($fields,$join,$where,$having,$groupby,$orderby);
					$res=$surchages->result;
					while($row=mysql_fetch_object($res)){
						?>
							<th>&nbsp;</th>		
						<?php
						}
			}
			
			?>
			<th>&nbsp;</th>
			<?php
			$arrears = new Arrears();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where id in(select arrearid from hrm_employeearrears where month='$obj->month' and year='$obj->year') and hrm_arrears.taxable='No'";
			$arrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$res=$arrears->result;
			$x=0;
			while($row=mysql_fetch_object($res)){
			  
			  $employeearrears = new Employeearrears();
			    $fields="*";
			    $join=" ";
			    $where=" where hrm_employeearrears.arrearid='$row->id' and hrm_employeearrears.month='$obj->month' and hrm_employeearrears.year='$obj->year'";
			    $having="";
			    $groupby="";
			    $orderby="";
			    $employeearrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			    //$employeearrears = $employeearrears->fetchObject;
			    if($employeearrears->affectedRows>0){
			    ?>
			  <th>&nbsp;</th>
			  <?php
			  $x++;
			  }
			  
			}
			?>
			<?php if($x>0){?>
			<th>&nbsp;</th>
			<?php }?>
			<th>&nbsp;</th>
		</tr>
	</tfoot>
</table>
<hr>
<table align="center">
<tr>
	<td>Payment Date :
	<input type="text" name="paidon" class="date_input input-medium" size="12" readonly="readonly" value="<?php echo $obj->paidon; ?>"/>
	&nbsp;<input type="submit" name="action" class="btn btn-success" value="Make Payment"/></td>
</tr>
</table>
<hr>
</form>
<?php
include"../../../foot.php";
?>
