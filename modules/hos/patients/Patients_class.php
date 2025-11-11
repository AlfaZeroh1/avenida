<?php 
require_once("PatientsDBO.php");
class Patients
{				
	var $id;			
	var $patientno;			
	var $surname;			
	var $othernames;			
	var $patientclasseid;			
	var $bloodgroup;			
	var $address;			
	var $email;			
	var $mobile;			
	var $genderid;			
	var $dob;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $civilstatusid;			
	var $patientsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->patientno=str_replace("'","\'",$obj->patientno);
		$this->surname=str_replace("'","\'",$obj->surname);
		$this->othernames=str_replace("'","\'",$obj->othernames);
		if(empty($obj->patientclasseid))
			$obj->patientclasseid='NULL';
		$this->patientclasseid=$obj->patientclasseid;
		$this->bloodgroup=str_replace("'","\'",$obj->bloodgroup);
		$this->address=str_replace("'","\'",$obj->address);
		$this->email=str_replace("'","\'",$obj->email);
		$this->mobile=str_replace("'","\'",$obj->mobile);
		if(empty($obj->genderid))
			$obj->genderid='NULL';
		$this->genderid=$obj->genderid;
		$this->dob=str_replace("'","\'",$obj->dob);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		if(empty($obj->civilstatusid))
			$obj->civilstatusid='NULL';
		$this->civilstatusid=$obj->civilstatusid;
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

	//get patientno
	function getPatientno(){
		return $this->patientno;
	}
	//set patientno
	function setPatientno($patientno){
		$this->patientno=$patientno;
	}

	//get surname
	function getSurname(){
		return $this->surname;
	}
	//set surname
	function setSurname($surname){
		$this->surname=$surname;
	}

	//get othernames
	function getOthernames(){
		return $this->othernames;
	}
	//set othernames
	function setOthernames($othernames){
		$this->othernames=$othernames;
	}

	//get patientclasseid
	function getPatientclasseid(){
		return $this->patientclasseid;
	}
	//set patientclasseid
	function setPatientclasseid($patientclasseid){
		$this->patientclasseid=$patientclasseid;
	}

	//get bloodgroup
	function getBloodgroup(){
		return $this->bloodgroup;
	}
	//set bloodgroup
	function setBloodgroup($bloodgroup){
		$this->bloodgroup=$bloodgroup;
	}

	//get address
	function getAddress(){
		return $this->address;
	}
	//set address
	function setAddress($address){
		$this->address=$address;
	}

	//get email
	function getEmail(){
		return $this->email;
	}
	//set email
	function setEmail($email){
		$this->email=$email;
	}

	//get mobile
	function getMobile(){
		return $this->mobile;
	}
	//set mobile
	function setMobile($mobile){
		$this->mobile=$mobile;
	}

	//get genderid
	function getGenderid(){
		return $this->genderid;
	}
	//set genderid
	function setGenderid($genderid){
		$this->genderid=$genderid;
	}

	//get dob
	function getDob(){
		return $this->dob;
	}
	//set dob
	function setDob($dob){
		$this->dob=$dob;
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

	//get civilstatusid
	function getCivilstatusid(){
		return $this->civilstatusid;
	}
	//set civilstatusid
	function setCivilstatusid($civilstatusid){
		$this->civilstatusid=$civilstatusid;
	}

	function add($obj){
		$patientsDBO = new PatientsDBO();
		if($patientsDBO->persist($obj)){
		
			
			
			$this->id=$patientsDBO->id;
			$this->sql=$patientsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$patientsDBO = new PatientsDBO();
		if($patientsDBO->update($obj,$where)){
			$this->sql=$patientsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$patientsDBO = new PatientsDBO();
		if($patientsDBO->delete($obj,$where=""))		
			$this->sql=$patientsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$patientsDBO = new PatientsDBO();
		$this->table=$patientsDBO->table;
		$patientsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$patientsDBO->sql;
		$this->result=$patientsDBO->result;
		$this->fetchObject=$patientsDBO->fetchObject;
		$this->affectedRows=$patientsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->othernames)){
			$error="Other Names should be provided";
		}
		else if(empty($obj->genderid)){
			$error="Gender should be provided";
		}
		else if(empty($obj->civilstatusid)){
			$error="Civil Status should be provided";
		}
// 		else if(empty($obj->patientclasseid)){
// 			$error="Patient Class should be provided";
// 		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){	
		if(empty($obj->othernames)){
			$error="Other Names should be provided";
		}
		else if(empty($obj->genderid)){
			$error="Gender should be provided";
		}
		else if(empty($obj->civilstatusid)){
			$error="Civil Status should be provided";
		}
// 		else if(empty($obj->patientclasseid)){
// 			$error="Patient Class should be provided";
// 		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
