<?php 
require_once("../../../DB.php");
class DeductionsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hrm_deductions";

	function persist($obj){
		$sql="insert into hrm_deductions(id,name,deductiontypeid,epays,statement,frommonth,fromyear,tomonth,toyear,deductiontype,amount,relief,overall,acctypeid,liabilityid,expenseid,taxable,status,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id','$obj->name',$obj->deductiontypeid,'$obj->epays','$obj->statement','$obj->frommonth','$obj->fromyear','$obj->tomonth','$obj->toyear','$obj->deductiontype','$obj->amount','$obj->relief','$obj->overall','$obj->acctypeid','$obj->liabilityid','$obj->expenseid','$obj->taxable','$obj->status','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";		
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}		
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update hrm_deductions set name='$obj->name',deductiontypeid=$obj->deductiontypeid,epays='$obj->epays',statement='$obj->statement',frommonth='$obj->frommonth',fromyear='$obj->fromyear',tomonth='$obj->tomonth',toyear='$obj->toyear', deductiontype='$obj->deductiontype',amount='$obj->amount', relief='$obj->relief',overall='$obj->overall',acctypeid='$obj->acctypeid',liabilityid='$obj->liabilityid', expenseid='$obj->expenseid', taxable='$obj->taxable',status='$obj->status',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hrm_deductions $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hrm_deductions $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

