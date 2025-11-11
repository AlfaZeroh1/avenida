<?php 
require_once("../../../DB.php");
class PatientprescriptionsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hos_patientprescriptions";
//added the totals in the insert query
	function persist($obj){
		$sql="insert into hos_patientprescriptions(id,itemid,patienttreatmentid,quantity,price,frequency,Totals,remarks,duration,issued,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->itemid','$obj->patienttreatmentid','$obj->quantity','$obj->price','$obj->frequency','$obj->totals','$obj->remarks','$obj->duration','$obj->issued','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update hos_patientprescriptions set itemid='$obj->itemid',patienttreatmentid='$obj->patienttreatmentid',quantity='$obj->quantity', remarks='$obj->remarks',price='$obj->price',Totals='$obj->totals',frequency='$obj->frequency',duration='$obj->duration',issued='$obj->issued',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hos_patientprescriptions $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hos_patientprescriptions $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

