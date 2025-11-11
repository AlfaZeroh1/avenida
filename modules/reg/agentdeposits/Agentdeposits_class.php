<?php 
require_once("AgentdepositsDBO.php");
class Agentdeposits
{				
	var $id;			
	var $agentid;			
	var $bankid;			
	var $depositedon;			
	var $amount;			
	var $slipno;			
	var $file;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $agentdepositsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->agentid))
			$obj->agentid='NULL';
		$this->agentid=$obj->agentid;
		if(empty($obj->bankid))
			$obj->bankid='NULL';
		$this->bankid=$obj->bankid;
		$this->depositedon=str_replace("'","\'",$obj->depositedon);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->slipno=str_replace("'","\'",$obj->slipno);
		$this->file=str_replace("'","\'",$obj->file);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		return $this;
	
	}
	//get id
	function getId(){
		return $this->id;
	}
	//set id
	function setId($id){
		$this->id=$id;
	}

	//get agentid
	function getAgentid(){
		return $this->agentid;
	}
	//set agentid
	function setAgentid($agentid){
		$this->agentid=$agentid;
	}

	//get bankid
	function getBankid(){
		return $this->bankid;
	}
	//set bankid
	function setBankid($bankid){
		$this->bankid=$bankid;
	}

	//get depositedon
	function getDepositedon(){
		return $this->depositedon;
	}
	//set depositedon
	function setDepositedon($depositedon){
		$this->depositedon=$depositedon;
	}

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
	}

	//get slipno
	function getSlipno(){
		return $this->slipno;
	}
	//set slipno
	function setSlipno($slipno){
		$this->slipno=$slipno;
	}

	//get file
	function getFile(){
		return $this->file;
	}
	//set file
	function setFile($file){
		$this->file=$file;
	}

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	//get createdby
	function getCreatedby(){
		return $this->createdby;
	}
	//set createdby
	function setCreatedby($createdby){
		$this->createdby=$createdby;
	}

	//get createdon
	function getCreatedon(){
		return $this->createdon;
	}
	//set createdon
	function setCreatedon($createdon){
		$this->createdon=$createdon;
	}

	//get lasteditedby
	function getLasteditedby(){
		return $this->lasteditedby;
	}
	//set lasteditedby
	function setLasteditedby($lasteditedby){
		$this->lasteditedby=$lasteditedby;
	}

	//get lasteditedon
	function getLasteditedon(){
		return $this->lasteditedon;
	}
	//set lasteditedon
	function setLasteditedon($lasteditedon){
		$this->lasteditedon=$lasteditedon;
	}

	function add($obj){
		$agentdepositsDBO = new AgentdepositsDBO();
		if($agentdepositsDBO->persist($obj)){
			$this->id=$agentdepositsDBO->id;
			$this->sql=$agentdepositsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$agentdepositsDBO = new AgentdepositsDBO();
		if($agentdepositsDBO->update($obj,$where)){
			$this->sql=$agentdepositsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$agentdepositsDBO = new AgentdepositsDBO();
		if($agentdepositsDBO->delete($obj,$where=""))		
			$this->sql=$agentdepositsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$agentdepositsDBO = new AgentdepositsDBO();
		$this->table=$agentdepositsDBO->table;
		$agentdepositsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$agentdepositsDBO->sql;
		$this->result=$agentdepositsDBO->result;
		$this->fetchObject=$agentdepositsDBO->fetchObject;
		$this->affectedRows=$agentdepositsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->agentid)){
			$error="Agent should be provided";
		}
		else if(empty($obj->bankid)){
			$error="Bank should be provided";
		}
		else if(empty($obj->slipno)){
			$error="Slip No should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->agentid)){
			$error="Agent should be provided";
		}
		else if(empty($obj->bankid)){
			$error="Bank should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
