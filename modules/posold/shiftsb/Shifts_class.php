<?php 
require_once("ShiftsDBO.php");
class Shifts
{				
	var $id;			
	var $teamid;			
	var $brancheid;			
	var $name;			
	var $starttime;			
	var $enddate;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $shiftsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->teamid))
			$obj->teamid='NULL';
		$this->teamid=$obj->teamid;
		if(empty($obj->brancheid))
			$obj->brancheid='NULL';
		$this->brancheid=$obj->brancheid;
		$this->name=str_replace("'","\'",$obj->name);
		$this->starttime=str_replace("'","\'",$obj->starttime);
		$this->enddate=str_replace("'","\'",$obj->enddate);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		
		$this->createdby=$_SESSION['userid'];
		$this->createdon=date("Y-m-d H:i:s");
		$this->lasteditedby=$_SESSION['userid'];
		$this->lasteditedon=date("Y-m-d H:i:s");
		$this->ipaddress=$_SERVER['REMOTE_ADDR'];
	
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

	//get teamid
	function getTeamid(){
		return $this->teamid;
	}
	//set teamid
	function setTeamid($teamid){
		$this->teamid=$teamid;
	}

	//get brancheid
	function getBrancheid(){
		return $this->brancheid;
	}
	//set brancheid
	function setBrancheid($brancheid){
		$this->brancheid=$brancheid;
	}

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get starttime
	function getStarttime(){
		return $this->starttime;
	}
	//set starttime
	function setStarttime($starttime){
		$this->starttime=$starttime;
	}

	//get enddate
	function getEnddate(){
		return $this->enddate;
	}
	//set enddate
	function setEnddate($enddate){
		$this->enddate=$enddate;
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
		$shiftsDBO = new ShiftsDBO();
		if($shiftsDBO->persist($obj)){
			$this->id=$shiftsDBO->id;
			$this->sql=$shiftsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$shiftsDBO = new ShiftsDBO();
		if($shiftsDBO->update($obj,$where)){
			$this->sql=$shiftsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$shiftsDBO = new ShiftsDBO();
		if($shiftsDBO->delete($obj,$where=""))		
			$this->sql=$shiftsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$shiftsDBO = new ShiftsDBO();
		$this->table=$shiftsDBO->table;
		$shiftsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$shiftsDBO->sql;
		$this->result=$shiftsDBO->result;
		$this->fetchObject=$shiftsDBO->fetchObject;
		$this->affectedRows=$shiftsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->starttime)){
			$error="Start Date should be provided";
		}
		else if(empty($obj->enddate)){
			$error="End Date should be provided";
		}
		else if(empty($obj->remarks)){
			$error="Remarks should be provided";
		}
		else if(empty($obj->ipaddress)){
			$error="IP Address should be provided";
		}
		else if(empty($obj->createdby)){
			$error="Created By should be provided";
		}
		else if(empty($obj->createdon)){
			$error="Created On should be provided";
		}
		else if(empty($obj->lasteditedby)){
			$error="Last Editedby should be provided";
		}
		else if(empty($obj->lasteditedon)){
			$error="Last Editedby should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->remarks)){
			$error="Remarks should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
