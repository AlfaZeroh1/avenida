<?php 
require_once("../../../DB.php");
class AcctypesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="sys_acctypes";

	function persist($obj){
		$sql="insert into sys_acctypes(id,code,name,accounttypeid,subaccountypeid,balance,accounttype,direct)
						values('$obj->id','$obj->code','$obj->name',$obj->accounttypeid,$obj->subaccountypeid,'$obj->balance','$obj->accounttype','$obj->direct')";		
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
		$sql="update sys_acctypes set code='$obj->code',name='$obj->name',accounttypeid=$obj->accounttypeid,subaccountypeid=$obj->subaccountypeid,balance='$obj->balance',accounttype='$obj->accounttype',direct='$obj->direct' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from sys_acctypes $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from sys_acctypes $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

