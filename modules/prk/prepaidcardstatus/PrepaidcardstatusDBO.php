<?php 
require_once("../../../DB.php");
class PrepaidcardstatusDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="prk_prepaidcardstatus";

	function persist($obj){
		$sql="insert into prk_prepaidcardstatus(Card_Number,Amount,Status,User_pin,User_id,Card_Serial_number,User_phone_number,User_Pin_Retries,User_Allowed_pin_Retries)
						values('$obj->Card_Number','$obj->Amount','$obj->Status','$obj->User_pin','$obj->User_id','$obj->Card_Serial_number','$obj->User_phone_number','$obj->User_Pin_Retries','$obj->User_Allowed_pin_Retries')";		
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
		$sql="update prk_prepaidcardstatus set Card_Number='$obj->Card_Number',Amount='$obj->Amount',Status='$obj->Status',User_pin='$obj->User_pin',User_id='$obj->User_id',Card_Serial_number='$obj->Card_Serial_number',User_phone_number='$obj->User_phone_number',User_Pin_Retries='$obj->User_Pin_Retries',User_Allowed_pin_Retries='$obj->User_Allowed_pin_Retries' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from prk_prepaidcardstatus $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from prk_prepaidcardstatus $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

