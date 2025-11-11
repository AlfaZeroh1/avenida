<?php 
require_once("GradesDBO.php");
class Grades
{				
	var $id;			
	var $name;			
	var $remarks;			
	var $gradesDBO;
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
		$gradesDBO = new GradesDBO();
		if($gradesDBO->persist($obj)){
			$this->id=$gradesDBO->id;
			$this->sql=$gradesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$gradesDBO = new GradesDBO();
		if($gradesDBO->update($obj,$where)){
			$this->sql=$gradesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$gradesDBO = new GradesDBO();
		if($gradesDBO->delete($obj,$where=""))		
			$this->sql=$gradesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$gradesDBO = new GradesDBO();
		$this->table=$gradesDBO->table;
		$gradesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$gradesDBO->sql;
		$this->result=$gradesDBO->result;
		$this->fetchObject=$gradesDBO->fetchObject;
		$this->affectedRows=$gradesDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
