<?php 
require_once("TestDBO.php");
class Test
{				
	var $id;			
	var $name;			
	var $moduleid;			
	var $remarks;			
	var $testDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->moduleid))
			$obj->moduleid='NULL';
		$this->moduleid=$obj->moduleid;
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

	//get moduleid
	function getModuleid(){
		return $this->moduleid;
	}
	//set moduleid
	function setModuleid($moduleid){
		$this->moduleid=$moduleid;
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
		$testDBO = new TestDBO();
		if($testDBO->persist($obj)){
			$this->id=$testDBO->id;
			$this->sql=$testDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$testDBO = new TestDBO();
		if($testDBO->update($obj,$where)){
			$this->sql=$testDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$testDBO = new TestDBO();
		if($testDBO->delete($obj,$where=""))		
			$this->sql=$testDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$testDBO = new TestDBO();
		$this->table=$testDBO->table;
		$testDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$testDBO->sql;
		$this->result=$testDBO->result;
		$this->fetchObject=$testDBO->fetchObject;
		$this->affectedRows=$testDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Name should be provided";
		}
		else if(empty($obj->moduleid)){
			$error="Module should be provided";
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
