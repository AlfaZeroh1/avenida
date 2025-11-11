<?php 
require_once("../../../DB.php");
class EmployeedeductionsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hrm_employeedeductions";

	function persist($obj){
		$sql="insert into hrm_employeedeductions(id,deductionid,amount,deductiontypeid,frommonth,fromyear,tomonth,toyear,remarks,employeeid,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id','$obj->deductionid','$obj->amount','$obj->deductiontypeid','$obj->frommonth','$obj->fromyear','$obj->tomonth','$obj->toyear','$obj->remarks','$obj->employeeid','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";		
		$this->sql=$sql;if($obj->deductionid==5)echo $sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}		echo mysql_error();
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update hrm_employeedeductions set deductionid='$obj->deductionid',amount='$obj->amount',deductiontypeid='$obj->deductiontypeid',frommonth='$obj->frommonth',fromyear='$obj->fromyear',tomonth='$obj->tomonth',toyear='$obj->toyear',remarks='$obj->remarks',employeeid='$obj->employeeid',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hrm_employeedeductions $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hrm_employeedeductions $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

