<?php 
require_once("EmployeesDBO.php");
class Employees
{				
	var $id;			
	var $pfnum;			
	var $firstname;			
	var $middlename;			
	var $lastname;	
	var $type;
	var $gender;			
	var $bloodgroup;			
	var $rhd;			
	var $supervisorid;			
	var $startdate;			
	var $enddate;			
	var $dob;			
	var $idno;			
	var $passportno;			
	var $phoneno;			
	var $email;			
	var $officemail;			
	var $physicaladdress;			
	var $nationalityid;			
	var $countyid;			
	var $constituencyid;			
	var $location;			
	var $town;			
	var $marital;			
	var $spouse;			
	var $spouseidno;			
	var $spousetel;			
	var $spouseemail;			
	var $nssfno;			
	var $nhifno;			
	var $pinno;			
	var $helbno;			
	var $employeebankid;			
	var $bankbrancheid;			
	var $bankacc;			
	var $clearingcode;			
	var $ref;			
	var $basic;			
	var $assignmentid;			
	var $gradeid;			
	var $statusid;			
	var $image;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $employeesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->pfnum=str_replace("'","\'",$obj->pfnum);
		$this->firstname=str_replace("'","\'",$obj->firstname);
		$this->middlename=str_replace("'","\'",$obj->middlename);
		$this->lastname=str_replace("'","\'",$obj->lastname);
		$this->gender=str_replace("'","\'",$obj->gender);
		$this->type=str_replace("'","\'",$obj->type);
		$this->bloodgroup=str_replace("'","\'",$obj->bloodgroup);
		$this->rhd=str_replace("'","\'",$obj->rhd);
		$this->supervisorid=str_replace("'","\'",$obj->supervisorid);
		$this->startdate=str_replace("'","\'",$obj->startdate);
		$this->enddate=str_replace("'","\'",$obj->enddate);
		$this->dob=str_replace("'","\'",$obj->dob);
		$this->idno=str_replace("'","\'",$obj->idno);
		$this->passportno=str_replace("'","\'",$obj->passportno);
		$this->phoneno=str_replace("'","\'",$obj->phoneno);
		$this->email=str_replace("'","\'",$obj->email);
		$this->officemail=str_replace("'","\'",$obj->officemail);
		$this->physicaladdress=str_replace("'","\'",$obj->physicaladdress);
		if(empty($obj->nationalityid))
			$obj->nationalityid='NULL';
		$this->nationalityid=$obj->nationalityid;
		if(empty($obj->countyid))
			$obj->countyid='NULL';
		$this->countyid=$obj->countyid;
		$this->constituencyid=str_replace("'","\'",$obj->constituencyid);
		$this->location=str_replace("'","\'",$obj->location);
		$this->town=str_replace("'","\'",$obj->town);
		$this->marital=str_replace("'","\'",$obj->marital);
		$this->spouse=str_replace("'","\'",$obj->spouse);
		$this->spouseidno=str_replace("'","\'",$obj->spouseidno);
		$this->spousetel=str_replace("'","\'",$obj->spousetel);
		$this->spouseemail=str_replace("'","\'",$obj->spouseemail);
		$this->nssfno=str_replace("'","\'",$obj->nssfno);
		$this->nhifno=str_replace("'","\'",$obj->nhifno);
		$this->pinno=str_replace("'","\'",$obj->pinno);
		$this->helbno=str_replace("'","\'",$obj->helbno);
		if(empty($obj->employeebankid))
			$obj->employeebankid='NULL';
		$this->employeebankid=$obj->employeebankid;
		if(empty($obj->bankbrancheid))
			$obj->bankbrancheid='NULL';
		$this->bankbrancheid=$obj->bankbrancheid;
		$this->bankacc=str_replace("'","\'",$obj->bankacc);
		$this->clearingcode=str_replace("'","\'",$obj->clearingcode);
		$this->ref=str_replace("'","\'",$obj->ref);
		$this->basic=str_replace("'","\'",$obj->basic);
		if(empty($obj->assignmentid))
			$obj->assignmentid='NULL';
		$this->assignmentid=$obj->assignmentid;
		if(empty($obj->gradeid))
			$obj->gradeid='NULL';
		$this->gradeid=$obj->gradeid;
		if(empty($obj->statusid))
			$obj->statusid='NULL';
		$this->statusid=$obj->statusid;
		$this->image=str_replace("'","\'",$obj->image);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
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

	//get pfnum
	function getPfnum(){
		return $this->pfnum;
	}
	//set pfnum
	function setPfnum($pfnum){
		$this->pfnum=$pfnum;
	}

	//get firstname
	function getFirstname(){
		return $this->firstname;
	}
	//set firstname
	function setFirstname($firstname){
		$this->firstname=$firstname;
	}

	//get middlename
	function getMiddlename(){
		return $this->middlename;
	}
	//set middlename
	function setMiddlename($middlename){
		$this->middlename=$middlename;
	}

	//get lastname
	function getLastname(){
		return $this->lastname;
	}
	//set lastname
	function setLastname($lastname){
		$this->lastname=$lastname;
	}

	//get gender
	function getGender(){
		return $this->gender;
	}
	//set gender
	function setGender($gender){
		$this->gender=$gender;
	}

	//get bloodgroup
	function getBloodgroup(){
		return $this->bloodgroup;
	}
	//set bloodgroup
	function setBloodgroup($bloodgroup){
		$this->bloodgroup=$bloodgroup;
	}

	//get rhd
	function getRhd(){
		return $this->rhd;
	}
	//set rhd
	function setRhd($rhd){
		$this->rhd=$rhd;
	}

	//get supervisorid
	function getSupervisorid(){
		return $this->supervisorid;
	}
	//set supervisorid
	function setSupervisorid($supervisorid){
		$this->supervisorid=$supervisorid;
	}

	//get startdate
	function getStartdate(){
		return $this->startdate;
	}
	//set startdate
	function setStartdate($startdate){
		$this->startdate=$startdate;
	}

	//get enddate
	function getEnddate(){
		return $this->enddate;
	}
	//set enddate
	function setEnddate($enddate){
		$this->enddate=$enddate;
	}

	//get dob
	function getDob(){
		return $this->dob;
	}
	//set dob
	function setDob($dob){
		$this->dob=$dob;
	}

	//get idno
	function getIdno(){
		return $this->idno;
	}
	//set idno
	function setIdno($idno){
		$this->idno=$idno;
	}

	//get passportno
	function getPassportno(){
		return $this->passportno;
	}
	//set passportno
	function setPassportno($passportno){
		$this->passportno=$passportno;
	}

	//get phoneno
	function getPhoneno(){
		return $this->phoneno;
	}
	//set phoneno
	function setPhoneno($phoneno){
		$this->phoneno=$phoneno;
	}

	//get email
	function getEmail(){
		return $this->email;
	}
	//set email
	function setEmail($email){
		$this->email=$email;
	}

	//get officemail
	function getOfficemail(){
		return $this->officemail;
	}
	//set officemail
	function setOfficemail($officemail){
		$this->officemail=$officemail;
	}

	//get physicaladdress
	function getPhysicaladdress(){
		return $this->physicaladdress;
	}
	//set physicaladdress
	function setPhysicaladdress($physicaladdress){
		$this->physicaladdress=$physicaladdress;
	}

	//get nationalityid
	function getNationalityid(){
		return $this->nationalityid;
	}
	//set nationalityid
	function setNationalityid($nationalityid){
		$this->nationalityid=$nationalityid;
	}

	//get countyid
	function getCountyid(){
		return $this->countyid;
	}
	//set countyid
	function setCountyid($countyid){
		$this->countyid=$countyid;
	}

	//get constituencyid
	function getConstituencyid(){
		return $this->constituencyid;
	}
	//set constituencyid
	function setConstituencyid($constituencyid){
		$this->constituencyid=$constituencyid;
	}

	//get location
	function getLocation(){
		return $this->location;
	}
	//set location
	function setLocation($location){
		$this->location=$location;
	}

	//get town
	function getTown(){
		return $this->town;
	}
	//set town
	function setTown($town){
		$this->town=$town;
	}

	//get marital
	function getMarital(){
		return $this->marital;
	}
	//set marital
	function setMarital($marital){
		$this->marital=$marital;
	}

	//get spouse
	function getSpouse(){
		return $this->spouse;
	}
	//set spouse
	function setSpouse($spouse){
		$this->spouse=$spouse;
	}

	//get spouseidno
	function getSpouseidno(){
		return $this->spouseidno;
	}
	//set spouseidno
	function setSpouseidno($spouseidno){
		$this->spouseidno=$spouseidno;
	}

	//get spousetel
	function getSpousetel(){
		return $this->spousetel;
	}
	//set spousetel
	function setSpousetel($spousetel){
		$this->spousetel=$spousetel;
	}

	//get spouseemail
	function getSpouseemail(){
		return $this->spouseemail;
	}
	//set spouseemail
	function setSpouseemail($spouseemail){
		$this->spouseemail=$spouseemail;
	}

	//get nssfno
	function getNssfno(){
		return $this->nssfno;
	}
	//set nssfno
	function setNssfno($nssfno){
		$this->nssfno=$nssfno;
	}

	//get nhifno
	function getNhifno(){
		return $this->nhifno;
	}
	//set nhifno
	function setNhifno($nhifno){
		$this->nhifno=$nhifno;
	}

	//get pinno
	function getPinno(){
		return $this->pinno;
	}
	//set pinno
	function setPinno($pinno){
		$this->pinno=$pinno;
	}

	//get helbno
	function getHelbno(){
		return $this->helbno;
	}
	//set helbno
	function setHelbno($helbno){
		$this->helbno=$helbno;
	}

	//get employeebankid
	function getEmployeebankid(){
		return $this->employeebankid;
	}
	//set employeebankid
	function setEmployeebankid($employeebankid){
		$this->employeebankid=$employeebankid;
	}

	//get bankbrancheid
	function getBankbrancheid(){
		return $this->bankbrancheid;
	}
	//set bankbrancheid
	function setBankbrancheid($bankbrancheid){
		$this->bankbrancheid=$bankbrancheid;
	}

	//get bankacc
	function getBankacc(){
		return $this->bankacc;
	}
	//set bankacc
	function setBankacc($bankacc){
		$this->bankacc=$bankacc;
	}

	//get clearingcode
	function getClearingcode(){
		return $this->clearingcode;
	}
	//set clearingcode
	function setClearingcode($clearingcode){
		$this->clearingcode=$clearingcode;
	}

	//get ref
	function getRef(){
		return $this->ref;
	}
	//set ref
	function setRef($ref){
		$this->ref=$ref;
	}

	//get basic
	function getBasic(){
		return $this->basic;
	}
	//set basic
	function setBasic($basic){
		$this->basic=$basic;
	}

	//get assignmentid
	function getAssignmentid(){
		return $this->assignmentid;
	}
	//set assignmentid
	function setAssignmentid($assignmentid){
		$this->assignmentid=$assignmentid;
	}

	//get gradeid
	function getGradeid(){
		return $this->gradeid;
	}
	//set gradeid
	function setGradeid($gradeid){
		$this->gradeid=$gradeid;
	}

	//get statusid
	function getStatusid(){
		return $this->statusid;
	}
	//set statusid
	function setStatusid($statusid){
		$this->statusid=$statusid;
	}

	//get image
	function getImage(){
		return $this->image;
	}
	//set image
	function setImage($image){
		$this->image=$image;
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

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	function add($obj){
		$employeesDBO = new EmployeesDBO();
		if($employeesDBO->persist($obj)){
			$this->id=$employeesDBO->id;
			$this->sql=$employeesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeesDBO = new EmployeesDBO();
		if($employeesDBO->update($obj,$where)){
			$this->sql=$employeesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeesDBO = new EmployeesDBO();
		if($employeesDBO->delete($obj,$where=""))		
			$this->sql=$employeesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeesDBO = new EmployeesDBO();
		$this->table=$employeesDBO->table;
		$employeesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeesDBO->sql;
		$this->result=$employeesDBO->result;
		$this->fetchObject=$employeesDBO->fetchObject;
		$this->affectedRows=$employeesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->type)){
			$error="Employment Type should be provided";
		}
		elseif(empty($obj->firstname)){
			$error="First Name should be provided";
		}
// 		else if(empty($obj->middlename)){
// 			$error="Middle Name should be provided";
// 		}
		else if(empty($obj->lastname)){
			$error="Last Name should be provided";
		}
		else if(empty($obj->idno) and empty($obj->passportno)){
			$error="ID/Passport No should be provided";
		}
// 		else if(empty($obj->marital)){
// 			$error="Marital Status should be provided";
// 		}
		else if(empty($obj->assignmentid)){
			$error="Assignment should be provided";
		}
		else if(empty($obj->pfnum)){
			$error="PFNO. should be provided";
		}
		else if(empty($obj->statusid)){
			$error="Status should be provided";
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
