<?php 
require_once("ProjectreviewdetailsDBO.php");
class Projectreviewdetails
{				
	var $id;			
	var $reviewid;			
	var $status;			
	var $remark;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $projectreviewdetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->reviewid=str_replace("'","\'",$obj->reviewid);
		$this->status=str_replace("'","\'",$obj->status);
		$this->remark=str_replace("'","\'",$obj->remark);
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

	//get reviewid
	function getReviewid(){
		return $this->reviewid;
	}
	//set reviewid
	function setReviewid($reviewid){
		$this->reviewid=$reviewid;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
	}

	//get remark
	function getRemark(){
		return $this->remark;
	}
	//set remark
	function setRemark($remark){
		$this->remark=$remark;
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
		$projectreviewdetailsDBO = new ProjectreviewdetailsDBO();
		if($projectreviewdetailsDBO->persist($obj)){
			$this->id=$projectreviewdetailsDBO->id;
			$this->sql=$projectreviewdetailsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$projectreviewdetailsDBO = new ProjectreviewdetailsDBO();
		if($projectreviewdetailsDBO->update($obj,$where)){
			$this->sql=$projectreviewdetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$projectreviewdetailsDBO = new ProjectreviewdetailsDBO();
		if($projectreviewdetailsDBO->delete($obj,$where=""))		
			$this->sql=$projectreviewdetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$projectreviewdetailsDBO = new ProjectreviewdetailsDBO();
		$this->table=$projectreviewdetailsDBO->table;
		$projectreviewdetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$projectreviewdetailsDBO->sql;
		$this->result=$projectreviewdetailsDBO->result;
		$this->fetchObject=$projectreviewdetailsDBO->fetchObject;
		$this->affectedRows=$projectreviewdetailsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
