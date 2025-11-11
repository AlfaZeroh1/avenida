<?php 
require_once("LandlordsDBO.php");
class Landlords
{				
	var $id;			
	var $llcode;			
	var $firstname;			
	var $middlename;			
	var $lastname;			
	var $tel;			
	var $email;			
	var $registeredon;			
	var $fax;			
	var $mobile;			
	var $idno;			
	var $passportno;			
	var $postaladdress;			
	var $address;			
	var $deductcommission;
	var $status;								
	var $createdby;
	var $createdon;
	var $lasteditedby;
	var $lasteditedon;	
	var $landlordsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->llcode=str_replace("'","\'",$obj->llcode);
		$this->firstname=str_replace("'","\'",$obj->firstname);
		$this->middlename=str_replace("'","\'",$obj->middlename);
		$this->lastname=str_replace("'","\'",$obj->lastname);
		$this->tel=str_replace("'","\'",$obj->tel);
		$this->email=str_replace("'","\'",$obj->email);
		$this->registeredon=str_replace("'","\'",$obj->registeredon);
		$this->fax=str_replace("'","\'",$obj->fax);
		$this->mobile=str_replace("'","\'",$obj->mobile);
		$this->idno=str_replace("'","\'",$obj->idno);
		$this->passportno=str_replace("'","\'",$obj->passportno);
		$this->postaladdress=str_replace("'","\'",$obj->postaladdress);
		$this->address=str_replace("'","\'",$obj->address);
		$this->deductcommission=str_replace("'","\'",$obj->deductcommission);
		$this->status=str_replace("'","\'",$obj->status);
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

	//get llcode
	function getLlcode(){
		return $this->llcode;
	}
	//set llcode
	function setLlcode($llcode){
		$this->llcode=$llcode;
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

	//get tel
	function getTel(){
		return $this->tel;
	}
	//set tel
	function setTel($tel){
		$this->tel=$tel;
	}

	//get email
	function getEmail(){
		return $this->email;
	}
	//set email
	function setEmail($email){
		$this->email=$email;
	}

	//get registeredon
	function getRegisteredon(){
		return $this->registeredon;
	}
	//set registeredon
	function setRegisteredon($registeredon){
		$this->registeredon=$registeredon;
	}

	//get fax
	function getFax(){
		return $this->fax;
	}
	//set fax
	function setFax($fax){
		$this->fax=$fax;
	}

	//get mobile
	function getMobile(){
		return $this->mobile;
	}
	//set mobile
	function setMobile($mobile){
		$this->mobile=$mobile;
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

	//get deductcommission
	function getDeductcommission(){
		return $this->deductcommission;
	}
	//set deductcommission
	function setDeductcommission($deductcommission){
		$this->deductcommission=$deductcommission;
	}
	
	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
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
		
		$landlords = new Landlords();
		$fields=" (max(id)+1) code ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$landlords->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$ob=$landlords->fetchObject;
		if(empty($ob->code))
			$ob->code=1;
		
		$ob->code = str_pad($ob->code, 4, 0, STR_PAD_LEFT);
		
		$obj->llcode="L".$ob->code;
		
		$landlordsDBO = new LandlordsDBO();
		if($landlordsDBO->persist($obj)){
			$this->id=$landlordsDBO->id;
			$this->sql=$landlordsDBO->sql;
			return true;	
		}
	}			
	
	function edit($obj,$where=""){
		$landlordsDBO = new LandlordsDBO();
		if($landlordsDBO->update($obj,$where)){
			$this->sql=$landlordsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$landlordsDBO = new LandlordsDBO();
		if($landlordsDBO->delete($obj,$where=""))		
			$this->sql=$landlordsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$landlordsDBO = new LandlordsDBO();
		$this->table=$landlordsDBO->table;
		$landlordsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$landlordsDBO->sql;
		$this->result=$landlordsDBO->result;
		$this->fetchObject=$landlordsDBO->fetchObject;
		$this->affectedRows=$landlordsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->llcode)){
			$error="LL Code should be provided";
		}
		else if(empty($obj->firstname)){
			$error="First Name should be provided";
		}
		else if(empty($obj->lastname)){
			$error="Last Name should be provided";
		}
		else if(empty($obj->registeredon)){
			$error="Date Registered should be provided";
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
