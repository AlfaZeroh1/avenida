<?php 
require_once("SubmodulesDBO.php");
class Submodules
{				
	var $id;			
	var $name;			
	var $description;			
	var $moduleid;			
	var $remarks;			
	var $indx;			
	var $url;			
	var $priority;			
	var $status;
	var $type;
	var $submodulesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->description=str_replace("'","\'",$obj->description);
		if(empty($obj->moduleid))
			$obj->moduleid='NULL';
		$this->moduleid=$obj->moduleid;
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->indx=str_replace("'","\'",$obj->indx);
		$this->url=str_replace("'","\'",$obj->url);
		$this->priority=str_replace("'","\'",$obj->priority);
		$this->status=str_replace("'","\'",$obj->status);
		$this->type=str_replace("'","\'",$obj->type);
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

	//get description
	function getDescription(){
		return $this->description;
	}
	//set description
	function setDescription($description){
		$this->description=$description;
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

	//get indx
	function getIndx(){
		return $this->indx;
	}
	//set indx
	function setIndx($indx){
		$this->indx=$indx;
	}

	//get url
	function getUrl(){
		return $this->url;
	}
	//set url
	function setUrl($url){
		$this->url=$url;
	}

	//get priority
	function getPriority(){
		return $this->priority;
	}
	//set priority
	function setPriority($priority){
		$this->priority=$priority;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
	}

	function add($obj){
		$submodulesDBO = new SubmodulesDBO();
		if($submodulesDBO->persist($obj)){
			$this->id=$submodulesDBO->id;
			$this->sql=$submodulesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$submodulesDBO = new SubmodulesDBO();
		if($submodulesDBO->update($obj,$where)){
			$this->sql=$submodulesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$submodulesDBO = new SubmodulesDBO();
		if($submodulesDBO->delete($obj,$where=""))		
			$this->sql=$submodulesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$submodulesDBO = new SubmodulesDBO();
		$this->table=$submodulesDBO->table;
		$submodulesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$submodulesDBO->sql;
		$this->result=$submodulesDBO->result;
		$this->fetchObject=$submodulesDBO->fetchObject;
		$this->affectedRows=$submodulesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Table Name should be provided";
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
