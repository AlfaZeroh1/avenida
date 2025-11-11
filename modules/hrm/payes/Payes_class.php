<?php 
require_once("PayesDBO.php");
class Payes
{				
	var $id;			
	var $low;			
	var $high;			
	var $percent;			
	var $payesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->low=str_replace("'","\'",$obj->low);
		$this->high=str_replace("'","\'",$obj->high);
		$this->percent=str_replace("'","\'",$obj->percent);
		return $this;
	
	}
	//get id
	function getId(){
		return $this->id;
	}
	//set id
	function setId($id){
		$this->id=$id;
	}

	//get low
	function getLow(){
		return $this->low;
	}
	//set low
	function setLow($low){
		$this->low=$low;
	}

	//get high
	function getHigh(){
		return $this->high;
	}
	//set high
	function setHigh($high){
		$this->high=$high;
	}

	//get percent
	function getPercent(){
		return $this->percent;
	}
	//set percent
	function setPercent($percent){
		$this->percent=$percent;
	}

	function add($obj){
		$payesDBO = new PayesDBO();
		if($payesDBO->persist($obj)){
			$this->id=$payesDBO->id;
			$this->sql=$payesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$payesDBO = new PayesDBO();
		if($payesDBO->update($obj,$where)){
			$this->sql=$payesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$payesDBO = new PayesDBO();
		if($payesDBO->delete($obj,$where=""))		
			$this->sql=$payesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$payesDBO = new PayesDBO();
		$this->table=$payesDBO->table;
		$payesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$payesDBO->sql;
		$this->result=$payesDBO->result;
		$this->fetchObject=$payesDBO->fetchObject;
		$this->affectedRows=$payesDBO->affectedRows;
	}	

	function getPAYE($taxable,$id,$obj){//if($id==17)echo $taxable."<br/>";
		$paye=0;
		
		$payes = new Payes();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		$payes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		while($py=mysql_fetch_object($payes->result)){
			
			if($taxable>=$py->low and $taxable>=$py->high and $py->high>0 and $py->low==0 ){
				$paye+=($py->high-$py->low)*$py->percent;
				//if($id==17)echo $py->low."==".($py->high-$py->low)."==".$paye."==".$py->percent."<br/>";	
				//break;
			}
			//if taxable is greater than low and less than high
			elseif($taxable>=$py->low and $taxable>=$py->high and $py->high>0 and $py->low>0 ){
				$paye+=($py->high-$py->low)*$py->percent;
				//if($id==17)echo $py->low."==".($py->high-$py->low)."==".$paye."==".$py->percent."<br/>";
				//break;
			}
			elseif($taxable>=$py->low and $taxable<$py->high and $py->high>0 ){
				$paye+=($taxable-$py->low)*$py->percent;
				//if($id==17)echo $py->low."==".($py->high-$py->low)."==".$paye."==".$py->percent."<br/>";
				//break;
			}
			elseif($taxable>=$py->low and $taxable>$py->high and $py->high==0 ){
				$paye+=($taxable-$py->low)*$py->percent;
				//if($id==17)echo $py->low."==".($py->high-$py->low)."==".$paye."==".$py->percent."<br/>";
				//break;
			}
			
		}
		
		$reliefs = new Reliefs();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		$reliefs->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$reliefs = $reliefs->fetchObject;
		$paye=$paye-$reliefs->amount;
		
		//if($id==17)echo $py->low."==".($py->high-$py->low)."==".$paye."==".$py->percent."<br/>";
		
		$employeereliefs = new Employeereliefs();
		$fields="sum(amount) amount";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where employeeid='$id'";
		$employeereliefs->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$employeereliefs = $employeereliefs->fetchObject;
		$paye=$paye-$employeereliefs->amount;
		
		$employeedeductions = new Employeedeductions();
		$fields="sum(hrm_employeedeductions.amount* case when hrm_deductions.relief is not null then hrm_deductions.relief else 0 end/100) amount";
		$join=" left join hrm_deductions on hrm_deductions.id=hrm_employeedeductions.deductionid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employeedeductions.employeeid='$id' and hrm_deductions.relief>0 ";
		$date=date("Y-m-d",mktime(0,0,0,$obj->month,01,$obj->year));
	    
		$where.=" and case when hrm_deductions.deductiontypeid=1 and hrm_employeedeductions.tomonth>0 then str_to_date('$date','%Y-%m-%d') between str_to_date(concat(concat(01,concat('-',hrm_employeedeductions.frommonth)),concat('-',hrm_employeedeductions.fromyear)),'%d-%m-%Y') and str_to_date(concat(concat(01,concat('-',hrm_employeedeductions.tomonth)),concat('-',hrm_employeedeductions.toyear)),'%d-%m-%Y') else 1=1 end ";
		$employeedeductions->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$employeedeductions = $employeedeductions->fetchObject;
		$paye=$paye-$employeedeductions->amount;
		
		if($paye<0)
			$paye=0;
		//if($id==17)echo $paye;
		return $paye;
	}
	
	function getTaxable($taxable, $id, $obj){
	  
	  $txb = 0;
	  $pensiondeductions= 0;
	  
	  $deductions = new Deductions();
	  $fields=" sum(hrm_employeedeductions.amount) amount ";
	  $join=" left join hrm_employeedeductions on hrm_employeedeductions.deductionid=hrm_deductions.id ";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $where=" where hrm_employeedeductions.employeeid='$id' and hrm_deductions.taxable='No' ";
	  //if($deductiontypeid==1){
	    $date=date("Y-m-d",mktime(0,0,0,$obj->month,01,$obj->year));
	    
	    $where.=" and case when hrm_deductions.deductiontypeid=1 and hrm_employeedeductions.tomonth>0 then str_to_date('$date','%Y-%m-%d') between str_to_date(concat(concat(01,concat('-',hrm_employeedeductions.frommonth)),concat('-',hrm_employeedeductions.fromyear)),'%d-%m-%Y') and str_to_date(concat(concat(01,concat('-',hrm_employeedeductions.tomonth)),concat('-',hrm_employeedeductions.toyear)),'%d-%m-%Y') else 1=1 end ";
	  //}
	  $deductions->retrieve($fields, $join, $where, $having, $groupby, $orderby);//if($id==17)echo $deductions->sql;
	  $deductions = $deductions->fetchObject;  
	  
	  $nssfs = new Nssfs();
	  $nssf=$nssfs->getNSSF($grosspay);
	  
 	  $pensiondeductions=$deductions->amount+$nssf;
	  if($pensiondeductions>20000){
	       $txb=$taxable-20000;
	    }else{	  
		$txb=$taxable-$pensiondeductions;
	  }
	  	  
	  $surchages = new Surchages();
	  $fields=" sum(hrm_employeesurchages.amount) amount ";
	  $join=" left join hrm_employeesurchages on hrm_employeesurchages.surchageid=hrm_surchages.id ";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $where=" where hrm_employeesurchages.employeeid='$id' and hrm_surchages.taxable='No' ";
	  //if($surchagetypeid==1){
	    $date=date("Y-m-d",mktime(0,0,0,$obj->month,01,$obj->year));
	    
	    $where.=" and str_to_date('$date','%Y-%m-%d') between str_to_date(concat(concat(01,concat('-',hrm_employeesurchages.frommonth)),concat('-',hrm_employeesurchages.fromyear)),'%d-%m-%Y') and str_to_date(concat(concat(01,concat('-',hrm_employeesurchages.tomonth)),concat('-',hrm_employeesurchages.toyear)),'%d-%m-%Y')  ";
	  //}
	  $surchages->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $surchages = $surchages->fetchObject;
	  
	  $txb = $txb-$surchages->amount; 
	  
	  return $txb;
	}
	
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
