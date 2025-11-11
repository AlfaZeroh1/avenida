<?php 
require_once("../../../DB.php");
class CategorysDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="assets_categorys";

	function persist($obj){
		$sql="insert into assets_categorys(id,name,departmentid,timemethod,noofdepr,endingdate,periodlength,computationmethod,degressivefactor,firstentry, type,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->name',$obj->departmentid,'$obj->timemethod','$obj->noofdepr','$obj->endingdate','$obj->periodlength','$obj->computationmethod','$obj->degressivefactor','$obj->firstentry','$obj->type','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update assets_categorys set name='$obj->name', departmentid=$obj->departmentid,timemethod='$obj->timemethod',noofdepr='$obj->noofdepr',endingdate='$obj->endingdate',periodlength='$obj->periodlength',computationmethod='$obj->computationmethod',degressivefactor='$obj->degressivefactor',firstentry='$obj->firstentry', type='$obj->type',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from assets_categorys $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from assets_categorys $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

