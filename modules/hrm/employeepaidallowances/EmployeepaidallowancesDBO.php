<?php 
require_once("../../../DB.php");
class EmployeepaidallowancesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hrm_employeepaidallowances";

	function persist($obj){
		$sql="insert into hrm_employeepaidallowances(id,employeepaymentid,allowanceid,employeeid,overtimeid,hours,amount,month,year,paidon,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id',$obj->employeepaymentid,$obj->allowanceid,$obj->employeeid,$obj->overtimeid,'$obj->hours','$obj->amount','$obj->month','$obj->year','$obj->paidon','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";		
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}	echo mysql_error();	
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update hrm_employeepaidallowances set employeepaymentid=$obj->employeepaymentid,allowanceid=$obj->allowanceid,employeeid=$obj->employeeid,overtimeid=$obj->overtimeid,hours='$obj->hours',amount='$obj->amount',month='$obj->month',year='$obj->year',paidon='$obj->paidon',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hrm_employeepaidallowances $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hrm_employeepaidallowances $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

