<?php 
require_once("EmployeestatussDBO.php");
class Employeestatuss
{				
	var $id;			
	var $name;			
	var $employeestatussDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
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

	function add($obj){
		$employeestatussDBO = new EmployeestatussDBO();
		if($employeestatussDBO->persist($obj)){
			$this->id=$employeestatussDBO->id;
			$this->sql=$employeestatussDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeestatussDBO = new EmployeestatussDBO();
		if($employeestatussDBO->update($obj,$where)){
			$this->sql=$employeestatussDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeestatussDBO = new EmployeestatussDBO();
		if($employeestatussDBO->delete($obj,$where=""))		
			$this->sql=$employeestatussDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeestatussDBO = new EmployeestatussDBO();
		$this->table=$employeestatussDBO->table;
		$employeestatussDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeestatussDBO->sql;
		$this->result=$employeestatussDBO->result;
		$this->fetchObject=$employeestatussDBO->fetchObject;
		$this->affectedRows=$employeestatussDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
