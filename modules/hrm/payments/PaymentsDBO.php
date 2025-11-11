<?php 
require_once("../../../DB.php");
class PaymentsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hrm_payments";

	function persist($obj){
		$sql="insert into hrm_payments(id,employeeid,paymentmodeid,assignmentid,bank,bankacc,year,month,gross,paye,paydate,days,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id','$obj->employeeid','$obj->paymentmodeid','$obj->assignmentid','$obj->bank','$obj->bankacc','$obj->year','$obj->month','$obj->gross','$obj->paye','$obj->paydate','$obj->days','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";		
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
		$sql="update hrm_payments set employeeid='$obj->employeeid',paymentmodeid='$obj->paymentmodeid',assignmentid='$obj->assignmentid',bank='$obj->bank',bankacc='$obj->bankacc',year='$obj->year',month='$obj->month',gross='$obj->gross',paye='$obj->paye',paydate='$obj->paydate',days='$obj->days',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hrm_payments $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hrm_payments $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

