<?php 
require_once("../../../DB.php");
class EmployeepaiddeductionsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hrm_employeepaiddeductions";

	function persist($obj){
		$sql="insert into hrm_employeepaiddeductions(id,employeepaymentid,deductionid,loanid,employeeid,amount,month,year,paidon,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id','$obj->employeepaymentid',$obj->deductionid,$obj->loanid,$obj->employeeid,'$obj->amount','$obj->month','$obj->year','$obj->paidon','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";
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
		$sql="update hrm_employeepaiddeductions set employeepaymentid='$obj->employeepaymentid',deductionid=$obj->deductionid,loanid=$obj->loanid,employeeid=$obj->employeeid,amount='$obj->amount',month='$obj->month',year='$obj->year',paidon='$obj->paidon',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hrm_employeepaiddeductions $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hrm_employeepaiddeductions $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

