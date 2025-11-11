<?php 
require_once("../../../DB.php");
class AgentdepositsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="reg_agentdeposits";

	function persist($obj){
		$sql="insert into reg_agentdeposits(id,agentid,bankid,depositedon,amount,slipno,file,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->agentid,$obj->bankid,'$obj->depositedon','$obj->amount','$obj->slipno','$obj->file','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update reg_agentdeposits set agentid=$obj->agentid,bankid=$obj->bankid,depositedon='$obj->depositedon',amount='$obj->amount',slipno='$obj->slipno',file='$obj->file',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from reg_agentdeposits $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from reg_agentdeposits $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

