<?php 
require_once("EtransactionsDBO.php");
class Etransactions
{				
	var $Txnid;			
	var $id;			
	var $orig;			
	var $dest;			
	var $tstamp;			
	var $details;			
	var $username;			
	var $pass;			
	var $mpesa_code;			
	var $mpesa_acc;			
	var $mpesa_msisdn;			
	var $mpesa_trx_date;			
	var $mpesa_trx_time;			
	var $mpesa_amt;			
	var $mpesa_sender;			
	var $updatecode;			
	var $UpdateDateTime;			
	var $dac_charge;			
	var $council_amt;			
	var $slot_id;			
	var $Vehicle_Reg;			
	var $etransactionsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		if(empty($obj->Txnid))
			$obj->Txnid='NULL';
		$this->Txnid=$obj->Txnid;
		$this->id=str_replace("'","\'",$obj->id);
		$this->orig=str_replace("'","\'",$obj->orig);
		$this->dest=str_replace("'","\'",$obj->dest);
		$this->tstamp=str_replace("'","\'",$obj->tstamp);
		$this->details=str_replace("'","\'",$obj->details);
		$this->username=str_replace("'","\'",$obj->username);
		$this->pass=str_replace("'","\'",$obj->pass);
		if(empty($obj->mpesa_code))
			$obj->mpesa_code='NULL';
		$this->mpesa_code=$obj->mpesa_code;
		$this->mpesa_acc=str_replace("'","\'",$obj->mpesa_acc);
		$this->mpesa_msisdn=str_replace("'","\'",$obj->mpesa_msisdn);
		$this->mpesa_trx_date=str_replace("'","\'",$obj->mpesa_trx_date);
		$this->mpesa_trx_time=str_replace("'","\'",$obj->mpesa_trx_time);
		$this->mpesa_amt=str_replace("'","\'",$obj->mpesa_amt);
		$this->mpesa_sender=str_replace("'","\'",$obj->mpesa_sender);
		$this->updatecode=str_replace("'","\'",$obj->updatecode);
		$this->UpdateDateTime=str_replace("'","\'",$obj->UpdateDateTime);
		$this->dac_charge=str_replace("'","\'",$obj->dac_charge);
		$this->council_amt=str_replace("'","\'",$obj->council_amt);
		$this->slot_id=str_replace("'","\'",$obj->slot_id);
		$this->Vehicle_Reg=str_replace("'","\'",$obj->Vehicle_Reg);
		return $this;
	
	}
	//get Txnid
	function getTxnid(){
		return $this->Txnid;
	}
	//set Txnid
	function setTxnid($Txnid){
		$this->Txnid=$Txnid;
	}

	//get id
	function getId(){
		return $this->id;
	}
	//set id
	function setId($id){
		$this->id=$id;
	}

	//get orig
	function getOrig(){
		return $this->orig;
	}
	//set orig
	function setOrig($orig){
		$this->orig=$orig;
	}

	//get dest
	function getDest(){
		return $this->dest;
	}
	//set dest
	function setDest($dest){
		$this->dest=$dest;
	}

	//get tstamp
	function getTstamp(){
		return $this->tstamp;
	}
	//set tstamp
	function setTstamp($tstamp){
		$this->tstamp=$tstamp;
	}

	//get details
	function getDetails(){
		return $this->details;
	}
	//set details
	function setDetails($details){
		$this->details=$details;
	}

	//get username
	function getUsername(){
		return $this->username;
	}
	//set username
	function setUsername($username){
		$this->username=$username;
	}

	//get pass
	function getPass(){
		return $this->pass;
	}
	//set pass
	function setPass($pass){
		$this->pass=$pass;
	}

	//get mpesa_code
	function getMpesa_code(){
		return $this->mpesa_code;
	}
	//set mpesa_code
	function setMpesa_code($mpesa_code){
		$this->mpesa_code=$mpesa_code;
	}

	//get mpesa_acc
	function getMpesa_acc(){
		return $this->mpesa_acc;
	}
	//set mpesa_acc
	function setMpesa_acc($mpesa_acc){
		$this->mpesa_acc=$mpesa_acc;
	}

	//get mpesa_msisdn
	function getMpesa_msisdn(){
		return $this->mpesa_msisdn;
	}
	//set mpesa_msisdn
	function setMpesa_msisdn($mpesa_msisdn){
		$this->mpesa_msisdn=$mpesa_msisdn;
	}

	//get mpesa_trx_date
	function getMpesa_trx_date(){
		return $this->mpesa_trx_date;
	}
	//set mpesa_trx_date
	function setMpesa_trx_date($mpesa_trx_date){
		$this->mpesa_trx_date=$mpesa_trx_date;
	}

	//get mpesa_trx_time
	function getMpesa_trx_time(){
		return $this->mpesa_trx_time;
	}
	//set mpesa_trx_time
	function setMpesa_trx_time($mpesa_trx_time){
		$this->mpesa_trx_time=$mpesa_trx_time;
	}

	//get mpesa_amt
	function getMpesa_amt(){
		return $this->mpesa_amt;
	}
	//set mpesa_amt
	function setMpesa_amt($mpesa_amt){
		$this->mpesa_amt=$mpesa_amt;
	}

	//get mpesa_sender
	function getMpesa_sender(){
		return $this->mpesa_sender;
	}
	//set mpesa_sender
	function setMpesa_sender($mpesa_sender){
		$this->mpesa_sender=$mpesa_sender;
	}

	//get updatecode
	function getUpdatecode(){
		return $this->updatecode;
	}
	//set updatecode
	function setUpdatecode($updatecode){
		$this->updatecode=$updatecode;
	}

	//get UpdateDateTime
	function getUpdateDateTime(){
		return $this->UpdateDateTime;
	}
	//set UpdateDateTime
	function setUpdateDateTime($UpdateDateTime){
		$this->UpdateDateTime=$UpdateDateTime;
	}

	//get dac_charge
	function getDac_charge(){
		return $this->dac_charge;
	}
	//set dac_charge
	function setDac_charge($dac_charge){
		$this->dac_charge=$dac_charge;
	}

	//get council_amt
	function getCouncil_amt(){
		return $this->council_amt;
	}
	//set council_amt
	function setCouncil_amt($council_amt){
		$this->council_amt=$council_amt;
	}

	//get slot_id
	function getSlot_id(){
		return $this->slot_id;
	}
	//set slot_id
	function setSlot_id($slot_id){
		$this->slot_id=$slot_id;
	}

	//get Vehicle_Reg
	function getVehicle_Reg(){
		return $this->Vehicle_Reg;
	}
	//set Vehicle_Reg
	function setVehicle_Reg($Vehicle_Reg){
		$this->Vehicle_Reg=$Vehicle_Reg;
	}

	function add($obj){
		$etransactionsDBO = new EtransactionsDBO();
		if($etransactionsDBO->persist($obj)){
			$this->id=$etransactionsDBO->id;
			$this->sql=$etransactionsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$etransactionsDBO = new EtransactionsDBO();
		if($etransactionsDBO->update($obj,$where)){
			$this->sql=$etransactionsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$etransactionsDBO = new EtransactionsDBO();
		if($etransactionsDBO->delete($obj,$where=""))		
			$this->sql=$etransactionsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$etransactionsDBO = new EtransactionsDBO();
		$this->table=$etransactionsDBO->table;
		$etransactionsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$etransactionsDBO->sql;
		$this->result=$etransactionsDBO->result;
		$this->fetchObject=$etransactionsDBO->fetchObject;
		$this->affectedRows=$etransactionsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->id)){
			$error=" should be provided";
		}
		else if(empty($obj->orig)){
			$error=" should be provided";
		}
		else if(empty($obj->dest)){
			$error=" should be provided";
		}
		else if(empty($obj->tstamp)){
			$error=" should be provided";
		}
		else if(empty($obj->mpesa_code)){
			$error=" should be provided";
		}
		else if(empty($obj->mpesa_acc)){
			$error=" should be provided";
		}
		else if(empty($obj->mpesa_msisdn)){
			$error=" should be provided";
		}
		else if(empty($obj->mpesa_trx_date)){
			$error=" should be provided";
		}
		else if(empty($obj->mpesa_trx_time)){
			$error=" should be provided";
		}
		else if(empty($obj->mpesa_amt)){
			$error=" should be provided";
		}
		else if(empty($obj->mpesa_sender)){
			$error=" should be provided";
		}
		else if(empty($obj->updatecode)){
			$error=" should be provided";
		}
		else if(empty($obj->UpdateDateTime)){
			$error=" should be provided";
		}
		else if(empty($obj->dac_charge)){
			$error=" should be provided";
		}
		else if(empty($obj->council_amt)){
			$error=" should be provided";
		}
		else if(empty($obj->slot_id)){
			$error=" should be provided";
		}
		else if(empty($obj->Vehicle_Reg)){
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
