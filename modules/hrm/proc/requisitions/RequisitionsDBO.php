<?php 
require_once("../../../DB.php");
class RequisitionsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="proc_requisitions";

	function persist($obj){
		$sql="insert into proc_requisitions(id,documentno,description,departmentid,projectid,requisitiondate,remarks,status,file,ipaddress,createdby,createdon,lasteditedby,lasteditedon,employeeid)
						values('$obj->id','$obj->documentno','$obj->description',$obj->departmentid,$obj->projectid,'$obj->requisitiondate','$obj->remarks','$obj->status','$obj->file','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->employeeid')";
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
		$sql="update proc_requisitions set documentno='$obj->documentno',description='$obj->description',departmentid=$obj->departmentid,projectid=$obj->projectid,requisitiondate='$obj->requisitiondate',remarks='$obj->remarks',status='$obj->status',file='$obj->file',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',employeeid='$obj->employeeid' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from proc_requisitions $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from proc_requisitions $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

