<?php 
require_once("../../../DB.php");
class DocumentssDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="dms_documentss";

	function persist($obj){
		$sql="insert into dms_documentss(id,routeid,documentno,documenttypeid,departmentid,departmentcategoryid,categoryid,hrmdepartmentid,document,link,status,expirydate,description,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->routeid,'$obj->documentno',$obj->documenttypeid,$obj->departmentid,$obj->departmentcategoryid,$obj->categoryid,$obj->hrmdepartmentid,'$obj->document','$obj->link','$obj->status','$obj->expirydate','$obj->description','$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}echo mysql_error();		
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update dms_documentss set routeid=$obj->routeid,documentno='$obj->documentno',documenttypeid=$obj->documenttypeid,departmentid=$obj->departmentid,departmentcategoryid='$obj->departmentcategoryid',categoryid=$obj->categoryid,hrmdepartmentid=$obj->hrmdepartmentid,document='$obj->document',link='$obj->link',status='$obj->status',expirydate='$obj->expirydate',description='$obj->description',remarks='$obj->remarks',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from dms_documentss $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from dms_documentss $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

