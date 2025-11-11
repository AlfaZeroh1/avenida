<?php 
require_once("../../../DB.php");
class PrepaidbillingDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="prk_prepaidbilling";

	function persist($obj){
		$sql="insert into prk_prepaidbilling(User_id,User_id_type,Transaction_Type,Transaction_Amount,Account_Balance,Card_number)
						values('$obj->User_id','$obj->User_id_type','$obj->Transaction_Type','$obj->Transaction_Amount','$obj->Account_Balance','$obj->Card_number')";		
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
		$sql="update prk_prepaidbilling set User_id='$obj->User_id',User_id_type='$obj->User_id_type',Transaction_Type='$obj->Transaction_Type',Transaction_Amount='$obj->Transaction_Amount',Account_Balance='$obj->Account_Balance',Card_number='$obj->Card_number' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from prk_prepaidbilling $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from prk_prepaidbilling $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

