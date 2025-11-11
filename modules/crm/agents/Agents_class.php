<?php 
require_once("AgentsDBO.php");
class Agents
{				
	var $id;			
	var $name;			
	var $address;			
	var $tel;			
	var $fax;			
	var $email;			
	var $statusid;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $agentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->address=str_replace("'","\'",$obj->address);
		$this->tel=str_replace("'","\'",$obj->tel);
		$this->fax=str_replace("'","\'",$obj->fax);
		$this->email=str_replace("'","\'",$obj->email);
		$this->statusid=str_replace("'","\'",$obj->statusid);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get address
	function getAddress(){
		return $this->address;
	}
	//set address
	function setAddress($address){
		$this->address=$address;
	}

	//get tel
	function getTel(){
		return $this->tel;
	}
	//set tel
	function setTel($tel){
		$this->tel=$tel;
	}

	//get fax
	function getFax(){
		return $this->fax;
	}
	//set fax
	function setFax($fax){
		$this->fax=$fax;
	}

	//get email
	function getEmail(){
		return $this->email;
	}
	//set email
	function setEmail($email){
		$this->email=$email;
	}

	//get statusid
	function getStatusid(){
		return $this->statusid;
	}
	//set statusid
	function setStatusid($statusid){
		$this->statusid=$statusid;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
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
		$agentsDBO = new AgentsDBO();
		if($agentsDBO->persist($obj)){
			$this->id=$agentsDBO->id;
			$this->sql=$agentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$agentsDBO = new AgentsDBO();
		if($agentsDBO->update($obj,$where)){
			$this->sql=$agentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$agentsDBO = new AgentsDBO();
		if($agentsDBO->delete($obj,$where=""))		
			$this->sql=$agentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$agentsDBO = new AgentsDBO();
		$this->table=$agentsDBO->table;
		$agentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$agentsDBO->sql;
		$this->result=$agentsDBO->result;
		$this->fetchObject=$agentsDBO->fetchObject;
		$this->affectedRows=$agentsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Agent Name should be provided";
		}
		else if(empty($obj->statusid)){
			$error="Status should be provided";
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
