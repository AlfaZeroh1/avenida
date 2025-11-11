<?php 
require_once("../../../DB.php");
class PatientotherservicesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hos_patientotherservices";

	function persist($obj){
		$sql="insert into hos_patientotherservices(id,documentno,patientid,patienttreatmentid,otherserviceid,charge,remarks,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->documentno',$obj->patientid,'$obj->patienttreatmentid',$obj->otherserviceid,'$obj->charge','$obj->remarks','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update hos_patientotherservices set documentno='$obj->documentno',patientid=$obj->patientid,patienttreatmentid='$obj->patienttreatmentid',otherserviceid=$obj->otherserviceid,charge='$obj->charge',remarks='$obj->remarks',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hos_patientotherservices $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hos_patientotherservices $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

