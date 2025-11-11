<?php 
require_once("GradingsDBO.php");
class Gradings
{				
	var $id;			
	var $name;			
	var $remarks;			
	var $gradingsDBO;
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
		$gradingsDBO = new GradingsDBO();
		if($gradingsDBO->persist($obj)){
			$this->id=$gradingsDBO->id;
			$this->sql=$gradingsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$gradingsDBO = new GradingsDBO();
		if($gradingsDBO->update($obj,$where)){
			$this->sql=$gradingsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$gradingsDBO = new GradingsDBO();
		if($gradingsDBO->delete($obj,$where=""))		
			$this->sql=$gradingsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$gradingsDBO = new GradingsDBO();
		$this->table=$gradingsDBO->table;
		$gradingsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$gradingsDBO->sql;
		$this->result=$gradingsDBO->result;
		$this->fetchObject=$gradingsDBO->fetchObject;
		$this->affectedRows=$gradingsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Grade should be provided";
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
