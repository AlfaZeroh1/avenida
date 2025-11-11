<?php 
require_once("TenantsDBO.php");
class Tenants
{				
	var $id;			
	var $code;			
	var $firstname;			
	var $middlename;			
	var $lastname;			
	var $postaladdress;			
	var $address;			
	var $registeredon;			
	var $nationalityid;			
	var $tel;			
	var $mobile;			
	var $fax;			
	var $idno;			
	var $passportno;			
	var $dlno;			
	var $occupation;			
	var $email;			
	var $dob;								
	var $createdby;
	var $createdon;
	var $lasteditedby;
	var $lasteditedon;	
	var $tenantsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->code=str_replace("'","\'",$obj->code);
		$this->firstname=str_replace("'","\'",$obj->firstname);
		$this->middlename=str_replace("'","\'",$obj->middlename);
		$this->lastname=str_replace("'","\'",$obj->lastname);
		$this->postaladdress=str_replace("'","\'",$obj->postaladdress);
		$this->address=str_replace("'","\'",$obj->address);
		$this->registeredon=str_replace("'","\'",$obj->registeredon);
		$this->nationalityid=str_replace("'","\'",$obj->nationalityid);
		$this->tel=str_replace("'","\'",$obj->tel);
		$this->mobile=str_replace("'","\'",$obj->mobile);
		$this->fax=str_replace("'","\'",$obj->fax);
		$this->idno=str_replace("'","\'",$obj->idno);
		$this->passportno=str_replace("'","\'",$obj->passportno);
		$this->dlno=str_replace("'","\'",$obj->dlno);
		$this->occupation=str_replace("'","\'",$obj->occupation);
		$this->email=str_replace("'","\'",$obj->email);
		$this->dob=str_replace("'","\'",$obj->dob);
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

	//get code
	function getCode(){
		return $this->code;
	}
	//set code
	function setCode($code){
		$this->code=$code;
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

	//get postaladdress
	function getPostaladdress(){
		return $this->postaladdress;
	}
	//set postaladdress
	function setPostaladdress($postaladdress){
		$this->postaladdress=$postaladdress;
	}

	//get address
	function getAddress(){
		return $this->address;
	}
	//set address
	function setAddress($address){
		$this->address=$address;
	}

	//get registeredon
	function getRegisteredon(){
		return $this->registeredon;
	}
	//set registeredon
	function setRegisteredon($registeredon){
		$this->registeredon=$registeredon;
	}

	//get nationalityid
	function getNationalityid(){
		return $this->nationalityid;
	}
	//set nationalityid
	function setNationalityid($nationalityid){
		$this->nationalityid=$nationalityid;
	}

	//get tel
	function getTel(){
		return $this->tel;
	}
	//set tel
	function setTel($tel){
		$this->tel=$tel;
	}

	//get mobile
	function getMobile(){
		return $this->mobile;
	}
	//set mobile
	function setMobile($mobile){
		$this->mobile=$mobile;
	}

	//get fax
	function getFax(){
		return $this->fax;
	}
	//set fax
	function setFax($fax){
		$this->fax=$fax;
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

	//get dlno
	function getDlno(){
		return $this->dlno;
	}
	//set dlno
	function setDlno($dlno){
		$this->dlno=$dlno;
	}

	//get occupation
	function getOccupation(){
		return $this->occupation;
	}
	//set occupation
	function setOccupation($occupation){
		$this->occupation=$occupation;
	}

	//get email
	function getEmail(){
		return $this->email;
	}
	//set email
	function setEmail($email){
		$this->email=$email;
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

	function add($obj){
		
		$tenants = new Tenants();
		$fields=" (max(id)+1) code ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$tenants->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$ob=$tenants->fetchObject;
		
		$ob->code = str_pad($ob->code, 4, 0, STR_PAD_LEFT);
		
		$obj->code="T".$ob->code;
		
		$tenantsDBO = new TenantsDBO();
		if($tenantsDBO->persist($obj)){
			$this->id=$tenantsDBO->id;
			$this->sql=$tenantsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$tenantsDBO = new TenantsDBO();
		if($tenantsDBO->update($obj,$where)){
			$this->sql=$tenantsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$tenantsDBO = new TenantsDBO();
		if($tenantsDBO->delete($obj,$where=""))		
			$this->sql=$tenantsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$tenantsDBO = new TenantsDBO();
		$this->table=$tenantsDBO->table;
		$tenantsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$tenantsDBO->sql;
		$this->result=$tenantsDBO->result;
		$this->fetchObject=$tenantsDBO->fetchObject;
		$this->affectedRows=$tenantsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->code)){
			$error="Tenant Code should be provided";
		}
		else if(empty($obj->firstname)){
			$error="First Name should be provided";
		}
		else if(empty($obj->lastname)){
			$error="Last Name should be provided";
		}
		/*else if(empty($obj->nationalityid)){
			$error="Nationality should be provided";
		}*/
	
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
