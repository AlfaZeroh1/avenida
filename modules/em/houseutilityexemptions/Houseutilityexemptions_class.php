<?php 
require_once("HouseutilityexemptionsDBO.php");
class Houseutilityexemptions
{				
	var $id;			
	var $houseid;			
	var $utilityid;			
	var $remarks;								
	var $createdby;
	var $createdon;
	var $lasteditedby;
	var $lasteditedon;	
	var $houseutilityexemptionsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->houseid=str_replace("'","\'",$obj->houseid);
		$this->utilityid=str_replace("'","\'",$obj->utilityid);
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

	//get houseid
	function getHouseid(){
		return $this->houseid;
	}
	//set houseid
	function setHouseid($houseid){
		$this->houseid=$houseid;
	}

	//get utilityid
	function getUtilityid(){
		return $this->utilityid;
	}
	//set utilityid
	function setUtilityid($utilityid){
		$this->utilityid=$utilityid;
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
		$houseutilityexemptionsDBO = new HouseutilityexemptionsDBO();
		if($houseutilityexemptionsDBO->persist($obj)){
			$this->id=$houseutilityexemptionsDBO->id;
			$this->sql=$houseutilityexemptionsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$houseutilityexemptionsDBO = new HouseutilityexemptionsDBO();
		if($houseutilityexemptionsDBO->update($obj,$where)){
			$this->sql=$houseutilityexemptionsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$houseutilityexemptionsDBO = new HouseutilityexemptionsDBO();
		if($houseutilityexemptionsDBO->delete($obj,$where=""))		
			$this->sql=$houseutilityexemptionsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$houseutilityexemptionsDBO = new HouseutilityexemptionsDBO();
		$this->table=$houseutilityexemptionsDBO->table;
		$houseutilityexemptionsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$houseutilityexemptionsDBO->sql;
		$this->result=$houseutilityexemptionsDBO->result;
		$this->fetchObject=$houseutilityexemptionsDBO->fetchObject;
		$this->affectedRows=$houseutilityexemptionsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->houseid)){
			$error="House should be provided";
		}
		else if(empty($obj->utilityid)){
			$error="Utility should be provided";
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
