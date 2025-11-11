<?php 
require_once("TeamsDBO.php");
class Teams
{				
	var $id;			
	var $brancheid;			
	var $shiftid;			
	var $startedon;			
	var $endedon;			
	var $teamedon;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $teamsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->brancheid))
			$obj->brancheid='NULL';
		$this->brancheid=$obj->brancheid;
		if(empty($obj->shiftid))
			$obj->shiftid='NULL';
		$this->shiftid=$obj->shiftid;
		$this->startedon=str_replace("'","\'",$obj->startedon);
		$this->endedon=str_replace("'","\'",$obj->endedon);
		$this->teamedon=str_replace("'","\'",$obj->teamedon);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		
		$this->createdby=$_SESSION['userid'];
		$this->createdon=date("Y-m-d H:i:s");
		$this->lasteditedby=$_SESSION['userid'];
		$this->lasteditedon=date("Y-m-d H:i:s");
		$this->ipaddress=$_SERVER['REMOTE_ADDR'];
		
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

	//get brancheid
	function getBrancheid(){
		return $this->brancheid;
	}
	//set brancheid
	function setBrancheid($brancheid){
		$this->brancheid=$brancheid;
	}

	//get shiftid
	function getShiftid(){
		return $this->shiftid;
	}
	//set shiftid
	function setShiftid($shiftid){
		$this->shiftid=$shiftid;
	}

	//get startedon
	function getStartedon(){
		return $this->startedon;
	}
	//set startedon
	function setStartedon($startedon){
		$this->startedon=$startedon;
	}

	//get endedon
	function getEndedon(){
		return $this->endedon;
	}
	//set endedon
	function setEndedon($endedon){
		$this->endedon=$endedon;
	}

	//get teamedon
	function getTeamedon(){
		return $this->teamedon;
	}
	//set teamedon
	function setTeamedon($teamedon){
		$this->teamedon=$teamedon;
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
		$teamsDBO = new TeamsDBO();
		if($teamsDBO->persist($obj)){
			$this->id=$teamsDBO->id;
			$this->sql=$teamsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$teamsDBO = new TeamsDBO();
		if($teamsDBO->update($obj,$where)){
			$this->sql=$teamsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$teamsDBO = new TeamsDBO();
		if($teamsDBO->delete($obj,$where=""))		
			$this->sql=$teamsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$teamsDBO = new TeamsDBO();
		$this->table=$teamsDBO->table;
		$teamsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$teamsDBO->sql;
		$this->result=$teamsDBO->result;
		$this->fetchObject=$teamsDBO->fetchObject;
		$this->affectedRows=$teamsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
