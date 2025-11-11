<?php 
require_once("ChecklistsDBO.php");
class Checklists
{				
	var $id;			
	var $name;			
	var $checklistcategoryid;			
	var $tenderid;			
	var $description;			
	var $deadline;			
	var $status;			
	var $doneon;			
	var $completedon;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $checklistsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->checklistcategoryid))
			$obj->checklistcategoryid='NULL';
		$this->checklistcategoryid=$obj->checklistcategoryid;
		if(empty($obj->tenderid))
			$obj->tenderid='NULL';
		$this->tenderid=$obj->tenderid;
		$this->description=str_replace("'","\'",$obj->description);
		$this->deadline=str_replace("'","\'",$obj->deadline);
		$this->status=str_replace("'","\'",$obj->status);
		$this->doneon=str_replace("'","\'",$obj->doneon);
		$this->completedon=str_replace("'","\'",$obj->completedon);
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

	//get checklistcategoryid
	function getChecklistcategoryid(){
		return $this->checklistcategoryid;
	}
	//set checklistcategoryid
	function setChecklistcategoryid($checklistcategoryid){
		$this->checklistcategoryid=$checklistcategoryid;
	}

	//get tenderid
	function getTenderid(){
		return $this->tenderid;
	}
	//set tenderid
	function setTenderid($tenderid){
		$this->tenderid=$tenderid;
	}

	//get description
	function getDescription(){
		return $this->description;
	}
	//set description
	function setDescription($description){
		$this->description=$description;
	}

	//get deadline
	function getDeadline(){
		return $this->deadline;
	}
	//set deadline
	function setDeadline($deadline){
		$this->deadline=$deadline;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
	}

	//get doneon
	function getDoneon(){
		return $this->doneon;
	}
	//set doneon
	function setDoneon($doneon){
		$this->doneon=$doneon;
	}

	//get completedon
	function getCompletedon(){
		return $this->completedon;
	}
	//set completedon
	function setCompletedon($completedon){
		$this->completedon=$completedon;
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
		$checklistsDBO = new ChecklistsDBO();
		if($checklistsDBO->persist($obj)){
			$this->id=$checklistsDBO->id;
			$this->sql=$checklistsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$checklistsDBO = new ChecklistsDBO();
		if($checklistsDBO->update($obj,$where)){
			$this->sql=$checklistsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$checklistsDBO = new ChecklistsDBO();
		if($checklistsDBO->delete($obj,$where=""))		
			$this->sql=$checklistsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$checklistsDBO = new ChecklistsDBO();
		$this->table=$checklistsDBO->table;
		$checklistsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$checklistsDBO->sql;
		$this->result=$checklistsDBO->result;
		$this->fetchObject=$checklistsDBO->fetchObject;
		$this->affectedRows=$checklistsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Responsibility should be provided";
		}
		else if(empty($obj->checklistcategoryid)){
			$error="Category should be provided";
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
