<?php 
require_once("../../../DB.php");
class SubmodulesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="sys_submodules";

	function persist($obj){
		$sql="insert into sys_submodules(id,name,description,moduleid,remarks,indx,url,priority,status,type)
						values('$obj->id','$obj->name','$obj->description',$obj->moduleid,'$obj->remarks','$obj->indx','$obj->url','$obj->priority','$obj->status','$obj->type')";		
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
		$sql="update sys_submodules set name='$obj->name',description='$obj->description',moduleid=$obj->moduleid,remarks='$obj->remarks',indx='$obj->indx',url='$obj->url',priority='$obj->priority',status='$obj->status', type='$obj->type' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from sys_submodules $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from sys_submodules $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

