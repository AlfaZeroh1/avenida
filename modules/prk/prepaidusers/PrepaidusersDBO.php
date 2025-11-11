<?php 
require_once("../../../DB.php");
class PrepaidusersDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="prk_prepaidusers";

	function persist($obj){
		$sql="insert into prk_prepaidusers(User_id,User_pin,Account_balance,last_reload_card,Status,User_phone_number,User_Pin_Retries,User_Allowed_pin_Retries)
						values('$obj->User_id','$obj->User_pin','$obj->Account_balance','$obj->last_reload_card','$obj->Status','$obj->User_phone_number','$obj->User_Pin_Retries','$obj->User_Allowed_pin_Retries')";		
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
		$sql="update prk_prepaidusers set User_id='$obj->User_id',User_pin='$obj->User_pin',Account_balance='$obj->Account_balance',last_reload_card='$obj->last_reload_card',Status='$obj->Status',User_phone_number='$obj->User_phone_number',User_Pin_Retries='$obj->User_Pin_Retries',User_Allowed_pin_Retries='$obj->User_Allowed_pin_Retries' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from prk_prepaidusers $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from prk_prepaidusers $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

