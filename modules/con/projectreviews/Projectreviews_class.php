<?php 
require_once("ProjectreviewsDBO.php");
class Projectreviews
{				
	var $id;			
	var $projectid;			
	var $employeeid;			
	var $findings;			
	var $recommendations;			
	var $reviewedon;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $projectreviewsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->projectid))
			$obj->projectid='NULL';
		$this->projectid=$obj->projectid;
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->findings=str_replace("'","\'",$obj->findings);
		$this->recommendations=str_replace("'","\'",$obj->recommendations);
		$this->reviewedon=str_replace("'","\'",$obj->reviewedon);
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

	//get projectid
	function getProjectid(){
		return $this->projectid;
	}
	//set projectid
	function setProjectid($projectid){
		$this->projectid=$projectid;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get findings
	function getFindings(){
		return $this->findings;
	}
	//set findings
	function setFindings($findings){
		$this->findings=$findings;
	}

	//get recommendations
	function getRecommendations(){
		return $this->recommendations;
	}
	//set recommendations
	function setRecommendations($recommendations){
		$this->recommendations=$recommendations;
	}

	//get reviewedon
	function getReviewedon(){
		return $this->reviewedon;
	}
	//set reviewedon
	function setReviewedon($reviewedon){
		$this->reviewedon=$reviewedon;
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
		$projectreviewsDBO = new ProjectreviewsDBO();
		if($projectreviewsDBO->persist($obj)){
			$this->id=$projectreviewsDBO->id;
			$this->sql=$projectreviewsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$projectreviewsDBO = new ProjectreviewsDBO();
		if($projectreviewsDBO->update($obj,$where)){
			$this->sql=$projectreviewsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$projectreviewsDBO = new ProjectreviewsDBO();
		if($projectreviewsDBO->delete($obj,$where=""))		
			$this->sql=$projectreviewsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$projectreviewsDBO = new ProjectreviewsDBO();
		$this->table=$projectreviewsDBO->table;
		$projectreviewsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$projectreviewsDBO->sql;
		$this->result=$projectreviewsDBO->result;
		$this->fetchObject=$projectreviewsDBO->fetchObject;
		$this->affectedRows=$projectreviewsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->projectid)){
			$error="Project should be provided";
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
