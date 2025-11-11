<?php 
require_once("AgentsDBO.php");
class Agents
{				
	var $id;			
	var $name;			
	var $agentid;			
	var $agenttypeid;			
	var $regionid;			
	var $subregionid;			
	var $contactperson;			
	var $tel;			
	var $mobile;			
	var $email;			
	var $remarks;			
	var $ipaddress;			
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
		$this->agentid=str_replace("'","\'",$obj->agentid);
		$this->agenttypeid=str_replace("'","\'",$obj->agenttypeid);
		if(empty($obj->regionid))
			$obj->regionid='NULL';
		$this->regionid=$obj->regionid;
		if(empty($obj->subregionid))
			$obj->subregionid='NULL';
		$this->subregionid=$obj->subregionid;
		$this->contactperson=str_replace("'","\'",$obj->contactperson);
		$this->tel=str_replace("'","\'",$obj->tel);
		$this->mobile=str_replace("'","\'",$obj->mobile);
		$this->email=str_replace("'","\'",$obj->email);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get agentid
	function getAgentid(){
		return $this->agentid;
	}
	//set agentid
	function setAgentid($agentid){
		$this->agentid=$agentid;
	}

	//get agenttypeid
	function getAgenttypeid(){
		return $this->agenttypeid;
	}
	//set agenttypeid
	function setAgenttypeid($agenttypeid){
		$this->agenttypeid=$agenttypeid;
	}

	//get regionid
	function getRegionid(){
		return $this->regionid;
	}
	//set regionid
	function setRegionid($regionid){
		$this->regionid=$regionid;
	}

	//get subregionid
	function getSubregionid(){
		return $this->subregionid;
	}
	//set subregionid
	function setSubregionid($subregionid){
		$this->subregionid=$subregionid;
	}

	//get contactperson
	function getContactperson(){
		return $this->contactperson;
	}
	//set contactperson
	function setContactperson($contactperson){
		$this->contactperson=$contactperson;
	}

	//get tel
	function getTel(){
		return $this->tel;
	}
	//set tel
	function setTel($tel){
		$this->tel=$tel;
	}

	//get mobile
	function getMobile(){
		return $this->mobile;
	}
	//set mobile
	function setMobile($mobile){
		$this->mobile=$mobile;
	}

	//get email
	function getEmail(){
		return $this->email;
	}
	//set email
	function setEmail($email){
		$this->email=$email;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
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
			$error="Agent should be provided";
		}
		else if(empty($obj->regionid)){
			$error="Region should be provided";
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
