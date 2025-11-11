<?php 
require_once("LevelsDBO.php");
class Levels
{				
	var $id;			
	var $name;			
	var $overallno;			
	var $deptno;			
	var $follows;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $levelsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->overallno=str_replace("'","\'",$obj->overallno);
		$this->deptno=str_replace("'","\'",$obj->deptno);
		$this->follows=str_replace("'","\'",$obj->follows);
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

	//get overallno
	function getOverallno(){
		return $this->overallno;
	}
	//set overallno
	function setOverallno($overallno){
		$this->overallno=$overallno;
	}

	//get deptno
	function getDeptno(){
		return $this->deptno;
	}
	//set deptno
	function setDeptno($deptno){
		$this->deptno=$deptno;
	}

	//get follows
	function getFollows(){
		return $this->follows;
	}
	//set follows
	function setFollows($follows){
		$this->follows=$follows;
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
		$levelsDBO = new LevelsDBO();
		if($levelsDBO->persist($obj)){
			$this->id=$levelsDBO->id;
			$this->sql=$levelsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$levelsDBO = new LevelsDBO();
		if($levelsDBO->update($obj,$where)){
			$this->sql=$levelsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$levelsDBO = new LevelsDBO();
		if($levelsDBO->delete($obj,$where=""))		
			$this->sql=$levelsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$levelsDBO = new LevelsDBO();
		$this->table=$levelsDBO->table;
		$levelsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$levelsDBO->sql;
		$this->result=$levelsDBO->result;
		$this->fetchObject=$levelsDBO->fetchObject;
		$this->affectedRows=$levelsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Level should be provided";
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
