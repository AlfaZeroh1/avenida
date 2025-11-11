<?php 
require_once("../../../DB.php");
class EtransactionsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="fn_etransactions";

	function persist($obj){
		$sql="insert into fn_etransactions(Txnid,id,orig,dest,tstamp,details,username,pass,mpesa_code,mpesa_acc,mpesa_msisdn,mpesa_trx_date,mpesa_trx_time,mpesa_amt,mpesa_sender,updatecode,UpdateDateTime,dac_charge,council_amt,slot_id,Vehicle_Reg)
						values($obj->Txnid,'$obj->id','$obj->orig','$obj->dest','$obj->tstamp','$obj->details','$obj->username','$obj->pass',$obj->mpesa_code,'$obj->mpesa_acc','$obj->mpesa_msisdn','$obj->mpesa_trx_date','$obj->mpesa_trx_time','$obj->mpesa_amt','$obj->mpesa_sender','$obj->updatecode','$obj->UpdateDateTime','$obj->dac_charge','$obj->council_amt','$obj->slot_id','$obj->Vehicle_Reg')";		
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
		$sql="update fn_etransactions set Txnid=$obj->Txnid,orig='$obj->orig',dest='$obj->dest',tstamp='$obj->tstamp',details='$obj->details',username='$obj->username',pass='$obj->pass',mpesa_code=$obj->mpesa_code,mpesa_acc='$obj->mpesa_acc',mpesa_msisdn='$obj->mpesa_msisdn',mpesa_trx_date='$obj->mpesa_trx_date',mpesa_trx_time='$obj->mpesa_trx_time',mpesa_amt='$obj->mpesa_amt',mpesa_sender='$obj->mpesa_sender',updatecode='$obj->updatecode',UpdateDateTime='$obj->UpdateDateTime',dac_charge='$obj->dac_charge',council_amt='$obj->council_amt',slot_id='$obj->slot_id',Vehicle_Reg='$obj->Vehicle_Reg' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from fn_etransactions $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from fn_etransactions $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

