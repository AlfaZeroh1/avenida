<?php 
require_once("../../../DB.php");
class TxnfeedDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="prk_txnfeed";

	function persist($obj){
		$sql="insert into prk_txnfeed(txnid,Vehicle_reg,slot_id,Mpesa_sender,mpesa_trx_time)
						values('$obj->txnid','$obj->Vehicle_reg','$obj->slot_id','$obj->Mpesa_sender','$obj->mpesa_trx_time')";		
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
		$sql="update prk_txnfeed set txnid='$obj->txnid',Vehicle_reg='$obj->Vehicle_reg',slot_id='$obj->slot_id',Mpesa_sender='$obj->Mpesa_sender',mpesa_trx_time='$obj->mpesa_trx_time' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from prk_txnfeed $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from prk_txnfeed $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

