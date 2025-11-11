<?php 
require_once("LeavesectiondetailsDBO.php");
class Leavesectiondetails
{				
	var $id;			
	var $leaveid;			
	var $leavesectionid;			
	var $days;			
	var $duration;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $leavesectiondetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->leaveid))
			$obj->leaveid='NULL';
		$this->leaveid=$obj->leaveid;
		if(empty($obj->leavesectionid))
			$obj->leavesectionid='NULL';
		$this->leavesectionid=$obj->leavesectionid;
		$this->days=str_replace("'","\'",$obj->days);
		$this->duration=str_replace("'","\'",$obj->duration);
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

	//get leaveid
	function getLeaveid(){
		return $this->leaveid;
	}
	//set leaveid
	function setLeaveid($leaveid){
		$this->leaveid=$leaveid;
	}

	//get leavesectionid
	function getLeavesectionid(){
		return $this->leavesectionid;
	}
	//set leavesectionid
	function setLeavesectionid($leavesectionid){
		$this->leavesectionid=$leavesectionid;
	}

	//get days
	function getDays(){
		return $this->days;
	}
	//set days
	function setDays($days){
		$this->days=$days;
	}

	//get duration
	function getDuration(){
		return $this->duration;
	}
	//set duration
	function setDuration($duration){
		$this->duration=$duration;
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
		$leavesectiondetailsDBO = new LeavesectiondetailsDBO();
		if($leavesectiondetailsDBO->persist($obj)){
			$this->id=$leavesectiondetailsDBO->id;
			$this->sql=$leavesectiondetailsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$leavesectiondetailsDBO = new LeavesectiondetailsDBO();
		if($leavesectiondetailsDBO->update($obj,$where)){
			$this->sql=$leavesectiondetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$leavesectiondetailsDBO = new LeavesectiondetailsDBO();
		if($leavesectiondetailsDBO->delete($obj,$where=""))		
			$this->sql=$leavesectiondetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$leavesectiondetailsDBO = new LeavesectiondetailsDBO();
		$this->table=$leavesectiondetailsDBO->table;
		$leavesectiondetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$leavesectiondetailsDBO->sql;
		$this->result=$leavesectiondetailsDBO->result;
		$this->fetchObject=$leavesectiondetailsDBO->fetchObject;
		$this->affectedRows=$leavesectiondetailsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
