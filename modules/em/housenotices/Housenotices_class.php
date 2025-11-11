<?php 
require_once("HousenoticesDBO.php");
class Housenotices
{				
	var $id;			
	var $houseid;			
	var $noticedate;			
	var $tovacateon;			
	var $status;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $housenoticesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->houseid))
			$obj->houseid=NULL;
		$this->houseid=$obj->houseid;
		$this->noticedate=str_replace("'","\'",$obj->noticedate);
		$this->tovacateon=str_replace("'","\'",$obj->tovacateon);
		$this->status=str_replace("'","\'",$obj->status);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
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

	//get noticedate
	function getNoticedate(){
		return $this->noticedate;
	}
	//set noticedate
	function setNoticedate($noticedate){
		$this->noticedate=$noticedate;
	}

	//get tovacateon
	function getTovacateon(){
		return $this->tovacateon;
	}
	//set tovacateon
	function setTovacateon($tovacateon){
		$this->tovacateon=$tovacateon;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
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

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	function add($obj){
		$housenoticesDBO = new HousenoticesDBO();
		if($housenoticesDBO->persist($obj)){
			$this->id=$housenoticesDBO->id;
			$this->sql=$housenoticesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$housenoticesDBO = new HousenoticesDBO();
		if($housenoticesDBO->update($obj,$where)){
			$this->sql=$housenoticesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$housenoticesDBO = new HousenoticesDBO();
		if($housenoticesDBO->delete($obj,$where=""))		
			$this->sql=$housenoticesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$housenoticesDBO = new HousenoticesDBO();
		$this->table=$housenoticesDBO->table;
		$housenoticesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$housenoticesDBO->sql;
		$this->result=$housenoticesDBO->result;
		$this->fetchObject=$housenoticesDBO->fetchObject;
		$this->affectedRows=$housenoticesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->houseid)){
			$error="House should be provided";
		}
		else if(empty($obj->noticedate)){
			$error="Notice Date should be provided";
		}
		else if(empty($obj->tovacateon)){
			$error="Vacation Date should be provided";
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
