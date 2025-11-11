<?php 
require_once("EmployeedisplinarysDBO.php");
class Employeedisplinarys
{				
	var $id;			
	var $employeeid;			
	var $disciplinarytypeid;			
	var $disciplinarydate;			
	var $description;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $employeedisplinarysDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->employeeid=str_replace("'","\'",$obj->employeeid);
		$this->disciplinarytypeid=str_replace("'","\'",$obj->disciplinarytypeid);
		$this->disciplinarydate=str_replace("'","\'",$obj->disciplinarydate);
		$this->description=str_replace("'","\'",$obj->description);
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

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get disciplinarytypeid
	function getDisciplinarytypeid(){
		return $this->disciplinarytypeid;
	}
	//set disciplinarytypeid
	function setDisciplinarytypeid($disciplinarytypeid){
		$this->disciplinarytypeid=$disciplinarytypeid;
	}

	//get disciplinarydate
	function getDisciplinarydate(){
		return $this->disciplinarydate;
	}
	//set disciplinarydate
	function setDisciplinarydate($disciplinarydate){
		$this->disciplinarydate=$disciplinarydate;
	}

	//get description
	function getDescription(){
		return $this->description;
	}
	//set description
	function setDescription($description){
		$this->description=$description;
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
		$employeedisplinarysDBO = new EmployeedisplinarysDBO();
		if($employeedisplinarysDBO->persist($obj)){
			$this->id=$employeedisplinarysDBO->id;
			$this->sql=$employeedisplinarysDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeedisplinarysDBO = new EmployeedisplinarysDBO();
		if($employeedisplinarysDBO->update($obj,$where)){
			$this->sql=$employeedisplinarysDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeedisplinarysDBO = new EmployeedisplinarysDBO();
		if($employeedisplinarysDBO->delete($obj,$where=""))		
			$this->sql=$employeedisplinarysDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeedisplinarysDBO = new EmployeedisplinarysDBO();
		$this->table=$employeedisplinarysDBO->table;
		$employeedisplinarysDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeedisplinarysDBO->sql;
		$this->result=$employeedisplinarysDBO->result;
		$this->fetchObject=$employeedisplinarysDBO->fetchObject;
		$this->affectedRows=$employeedisplinarysDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
