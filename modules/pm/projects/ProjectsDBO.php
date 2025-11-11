<?php 
require_once("../../../DB.php");
class ProjectsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="pm_projects";

	function persist($obj){
		$sql="insert into pm_projects(id,customerid,name,description,startdate,expectedcompletion,actualcompletion,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->customerid,'$obj->name','$obj->description','$obj->startdate','$obj->expectedcompletion','$obj->actualcompletion','$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update pm_projects set customerid=$obj->customerid,name='$obj->name',description='$obj->description',startdate='$obj->startdate',expectedcompletion='$obj->expectedcompletion',actualcompletion='$obj->actualcompletion',remarks='$obj->remarks',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from pm_projects $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from pm_projects $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

