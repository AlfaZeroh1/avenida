<?php 
require_once("TxnfeedDBO.php");
class Txnfeed
{				
	var $txnid;			
	var $Vehicle_reg;			
	var $slot_id;			
	var $Mpesa_sender;			
	var $mpesa_trx_time;			
	var $txnfeedDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->txnid=str_replace("'","\'",$obj->txnid);
		$this->Vehicle_reg=str_replace("'","\'",$obj->Vehicle_reg);
		$this->slot_id=str_replace("'","\'",$obj->slot_id);
		$this->Mpesa_sender=str_replace("'","\'",$obj->Mpesa_sender);
		$this->mpesa_trx_time=str_replace("'","\'",$obj->mpesa_trx_time);
		return $this;
	
	}
	//get txnid
	function getTxnid(){
		return $this->txnid;
	}
	//set txnid
	function setTxnid($txnid){
		$this->txnid=$txnid;
	}

	//get Vehicle_reg
	function getVehicle_reg(){
		return $this->Vehicle_reg;
	}
	//set Vehicle_reg
	function setVehicle_reg($Vehicle_reg){
		$this->Vehicle_reg=$Vehicle_reg;
	}

	//get slot_id
	function getSlot_id(){
		return $this->slot_id;
	}
	//set slot_id
	function setSlot_id($slot_id){
		$this->slot_id=$slot_id;
	}

	//get Mpesa_sender
	function getMpesa_sender(){
		return $this->Mpesa_sender;
	}
	//set Mpesa_sender
	function setMpesa_sender($Mpesa_sender){
		$this->Mpesa_sender=$Mpesa_sender;
	}

	//get mpesa_trx_time
	function getMpesa_trx_time(){
		return $this->mpesa_trx_time;
	}
	//set mpesa_trx_time
	function setMpesa_trx_time($mpesa_trx_time){
		$this->mpesa_trx_time=$mpesa_trx_time;
	}

	function add($obj){
		$txnfeedDBO = new TxnfeedDBO();
		if($txnfeedDBO->persist($obj)){
			$this->id=$txnfeedDBO->id;
			$this->sql=$txnfeedDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$txnfeedDBO = new TxnfeedDBO();
		if($txnfeedDBO->update($obj,$where)){
			$this->sql=$txnfeedDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$txnfeedDBO = new TxnfeedDBO();
		if($txnfeedDBO->delete($obj,$where=""))		
			$this->sql=$txnfeedDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$txnfeedDBO = new TxnfeedDBO();
		$this->table=$txnfeedDBO->table;
		$txnfeedDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$txnfeedDBO->sql;
		$this->result=$txnfeedDBO->result;
		$this->fetchObject=$txnfeedDBO->fetchObject;
		$this->affectedRows=$txnfeedDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->txnid)){
			$error=" should be provided";
		}
		else if(empty($obj->Vehicle_reg)){
			$error=" should be provided";
		}
		else if(empty($obj->slot_id)){
			$error=" should be provided";
		}
		else if(empty($obj->Mpesa_sender)){
			$error=" should be provided";
		}
		else if(empty($obj->mpesa_trx_time)){
			$error=" should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
