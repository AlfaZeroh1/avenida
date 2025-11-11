<?php 
require_once("../../../DB.php");
class AssignmentsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hrm_assignments";

	function persist($obj){
		$sql="insert into hrm_assignments(id,code,name,departmentid,levelid,leavesectionid,sectionid,remarks,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id','$obj->code','$obj->name',$obj->departmentid,$obj->levelid,'$obj->leavesectionid','$obj->sectionid','$obj->remarks','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";		
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
		$sql="update hrm_assignments set code='$obj->code',name='$obj->name',departmentid=$obj->departmentid,levelid=$obj->levelid,leavesectionid='$obj->leavesectionid',sectionid='$obj->sectionid',remarks='$obj->remarks',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hrm_assignments $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hrm_assignments $join $where $groupby $having $orderby";
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

