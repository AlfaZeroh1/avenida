<?php 
require_once("DepartmentsDBO.php");
class Departments
{				
	var $id;			
	var $name;			
	var $remarks;			
	var $departmentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	function add($obj){
		$departmentsDBO = new DepartmentsDBO();
		if($departmentsDBO->persist($obj)){
			$this->id=$departmentsDBO->id;
			$this->sql=$departmentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$departmentsDBO = new DepartmentsDBO();
		if($departmentsDBO->update($obj,$where)){
			$this->sql=$departmentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$departmentsDBO = new DepartmentsDBO();
		if($departmentsDBO->delete($obj,$where=""))		
			$this->sql=$departmentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$departmentsDBO = new DepartmentsDBO();
		$this->table=$departmentsDBO->table;
		$departmentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$departmentsDBO->sql;
		$this->result=$departmentsDBO->result;
		$this->fetchObject=$departmentsDBO->fetchObject;
		$this->affectedRows=$departmentsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Department should be provided";
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
