<?php 
require_once("../../../DB.php");
class PatientlaboratorytestsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hos_patientlaboratorytests";

	function persist($obj){
		$sql="insert into hos_patientlaboratorytests(id,testno,patientid,patienttreatmentid,laboratorytestid,charge,results,labresults,testedon,consult,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->testno','$obj->patientid','$obj->patienttreatmentid','$obj->laboratorytestid','$obj->charge','$obj->results','$obj->labresults','$obj->testedon','$obj->consult','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update hos_patientlaboratorytests set testno='$obj->testno',patientid='$obj->patientid',patienttreatmentid='$obj->patienttreatmentid',laboratorytestid='$obj->laboratorytestid',charge='$obj->charge',results='$obj->results',labresults='$obj->labresults',testedon='$obj->testedon',consult='$obj->consult',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hos_patientlaboratorytests $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hos_patientlaboratorytests $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

