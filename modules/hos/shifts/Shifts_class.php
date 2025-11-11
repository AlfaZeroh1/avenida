<?php 
require_once("ShiftsDBO.php");
class Shifts
{				
	var $id;			
	var $type;			
	var $starttime;			
	var $enddate;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $shiftsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->type=str_replace("'","\'",$obj->type);
		$this->starttime=str_replace("'","\'",$obj->starttime);
		$this->enddate=str_replace("'","\'",$obj->enddate);
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

	//get type
	function getType(){
		return $this->type;
	}
	//set type
	function setType($type){
		$this->type=$type;
	}

	//get starttime
	function getStarttime(){
		return $this->starttime;
	}
	//set starttime
	function setStarttime($starttime){
		$this->starttime=$starttime;
	}

	//get enddate
	function getEnddate(){
		return $this->enddate;
	}
	//set enddate
	function setEnddate($enddate){
		$this->enddate=$enddate;
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
		$shiftsDBO = new ShiftsDBO();
		if($shiftsDBO->persist($obj)){
			$this->id=$shiftsDBO->id;
			$this->sql=$shiftsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$shiftsDBO = new ShiftsDBO();
		if($shiftsDBO->update($obj,$where)){
			$this->sql=$shiftsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$shiftsDBO = new ShiftsDBO();
		if($shiftsDBO->delete($obj,$where=""))		
			$this->sql=$shiftsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$shiftsDBO = new ShiftsDBO();
		$this->table=$shiftsDBO->table;
		$shiftsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$shiftsDBO->sql;
		$this->result=$shiftsDBO->result;
		$this->fetchObject=$shiftsDBO->fetchObject;
		$this->affectedRows=$shiftsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->type)){
			$error="Type should be provided";
		}
		else if(empty($obj->starttime)){
			$error="Start Date should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->remarks)){
			$error="Remarks should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
