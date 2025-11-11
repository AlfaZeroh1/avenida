<?php 
require_once("CustomersDBO.php");
class Customers
{				
	var $id;			
	var $code;			
	var $name;
	var $customerid;
	var $agentid;			
	var $departmentid;			
	var $continentid;			
	var $countryid;			
	var $currencyid;
	var $vatable;
	var $employeeid;			
	var $idno;			
	var $pinno;			
	var $address;			
	var $tel;			
	var $fax;			
	var $email;			
	var $contactname;			
	var $contactphone;			
	var $nextofkin;			
	var $nextofkinrelation;			
	var $nextofkinaddress;			
	var $nextofkinidno;			
	var $nextofkinpinno;			
	var $nextofkintel;			
	var $creditlimit;			
	var $creditdays;			
	var $discount;			
	var $showlogo;	
	var $freightid;	
	var $statusid;
	var $flo;
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $customersDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->code=str_replace("'","\'",$obj->code);
		$this->name=str_replace("'","\'",$obj->name);
		
		if(empty($obj->customerid))
			$obj->customerid='NULL';
		$this->customerid=$obj->customerid;
		
		$this->agentid=str_replace("'","\'",$obj->agentid);
		if(empty($obj->departmentid))
			$obj->departmentid='NULL';
		$this->departmentid=$obj->departmentid;
		if(empty($obj->continentid))
			$obj->continentid='NULL';
		$this->continentid=$obj->continentid;
		if(empty($obj->countryid))
			$obj->countryid='NULL';
		$this->countryid=$obj->countryid;
		if(empty($obj->currencyid))
			$obj->currencyid='NULL';
		$this->currencyid=$obj->currencyid;
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->vatable=$obj->vatable;
		$this->idno=str_replace("'","\'",$obj->idno);
		$this->flo=str_replace("'","\'",$obj->flo);
		$this->pinno=str_replace("'","\'",$obj->pinno);
		$this->address=str_replace("'","\'",$obj->address);
		$this->tel=str_replace("'","\'",$obj->tel);
		$this->fax=str_replace("'","\'",$obj->fax);
		$this->email=str_replace("'","\'",$obj->email);
		$this->contactname=str_replace("'","\'",$obj->contactname);
		$this->contactphone=str_replace("'","\'",$obj->contactphone);
		$this->nextofkin=str_replace("'","\'",$obj->nextofkin);
		$this->nextofkinrelation=str_replace("'","\'",$obj->nextofkinrelation);
		$this->nextofkinaddress=str_replace("'","\'",$obj->nextofkinaddress);
		$this->nextofkinidno=str_replace("'","\'",$obj->nextofkinidno);
		$this->nextofkinpinno=str_replace("'","\'",$obj->nextofkinpinno);
		$this->nextofkintel=str_replace("'","\'",$obj->nextofkintel);
		$this->creditlimit=str_replace("'","\'",$obj->creditlimit);
		$this->creditdays=str_replace("'","\'",$obj->creditdays);
		$this->discount=str_replace("'","\'",$obj->discount);
		$this->showlogo=str_replace("'","\'",$obj->showlogo);
		if(empty($obj->freightid))
			$obj->freightid='NULL';
		$this->freightid=$obj->freightid;
		if(empty($obj->freightid))
			$obj->freightid='NULL';
		
		$this->statusid=$obj->statusid;
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get code
	function getCode(){
		return $this->code;
	}
	//set code
	function setCode($code){
		$this->code=$code;
	}

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get agentid
	function getAgentid(){
		return $this->agentid;
	}
	//set agentid
	function setAgentid($agentid){
		$this->agentid=$agentid;
	}

	//get departmentid
	function getDepartmentid(){
		return $this->departmentid;
	}
	//set departmentid
	function setDepartmentid($departmentid){
		$this->departmentid=$departmentid;
	}

	//get continentid
	function getContinentid(){
		return $this->continentid;
	}
	//set continentid
	function setContinentid($continentid){
		$this->continentid=$continentid;
	}

	//get countryid
	function getCountryid(){
		return $this->countryid;
	}
	//set countryid
	function setCountryid($countryid){
		$this->countryid=$countryid;
	}

	//get currencyid
	function getCurrencyid(){
		return $this->currencyid;
	}
	//set currencyid
	function setCurrencyid($currencyid){
		$this->currencyid=$currencyid;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get idno
	function getIdno(){
		return $this->idno;
	}
	//set idno
	function setIdno($idno){
		$this->idno=$idno;
	}

	//get pinno
	function getPinno(){
		return $this->pinno;
	}
	//set pinno
	function setPinno($pinno){
		$this->pinno=$pinno;
	}

	//get address
	function getAddress(){
		return $this->address;
	}
	//set address
	function setAddress($address){
		$this->address=$address;
	}

	//get tel
	function getTel(){
		return $this->tel;
	}
	//set tel
	function setTel($tel){
		$this->tel=$tel;
	}

	//get fax
	function getFax(){
		return $this->fax;
	}
	//set fax
	function setFax($fax){
		$this->fax=$fax;
	}

	//get email
	function getEmail(){
		return $this->email;
	}
	//set email
	function setEmail($email){
		$this->email=$email;
	}

	//get contactname
	function getContactname(){
		return $this->contactname;
	}
	//set contactname
	function setContactname($contactname){
		$this->contactname=$contactname;
	}

	//get contactphone
	function getContactphone(){
		return $this->contactphone;
	}
	//set contactphone
	function setContactphone($contactphone){
		$this->contactphone=$contactphone;
	}

	//get nextofkin
	function getNextofkin(){
		return $this->nextofkin;
	}
	//set nextofkin
	function setNextofkin($nextofkin){
		$this->nextofkin=$nextofkin;
	}

	//get nextofkinrelation
	function getNextofkinrelation(){
		return $this->nextofkinrelation;
	}
	//set nextofkinrelation
	function setNextofkinrelation($nextofkinrelation){
		$this->nextofkinrelation=$nextofkinrelation;
	}

	//get nextofkinaddress
	function getNextofkinaddress(){
		return $this->nextofkinaddress;
	}
	//set nextofkinaddress
	function setNextofkinaddress($nextofkinaddress){
		$this->nextofkinaddress=$nextofkinaddress;
	}

	//get nextofkinidno
	function getNextofkinidno(){
		return $this->nextofkinidno;
	}
	//set nextofkinidno
	function setNextofkinidno($nextofkinidno){
		$this->nextofkinidno=$nextofkinidno;
	}

	//get nextofkinpinno
	function getNextofkinpinno(){
		return $this->nextofkinpinno;
	}
	//set nextofkinpinno
	function setNextofkinpinno($nextofkinpinno){
		$this->nextofkinpinno=$nextofkinpinno;
	}

	//get nextofkintel
	function getNextofkintel(){
		return $this->nextofkintel;
	}
	//set nextofkintel
	function setNextofkintel($nextofkintel){
		$this->nextofkintel=$nextofkintel;
	}

	//get creditlimit
	function getCreditlimit(){
		return $this->creditlimit;
	}
	//set creditlimit
	function setCreditlimit($creditlimit){
		$this->creditlimit=$creditlimit;
	}

	//get creditdays
	function getCreditdays(){
		return $this->creditdays;
	}
	//set creditdays
	function setCreditdays($creditdays){
		$this->creditdays=$creditdays;
	}

	//get discount
	function getDiscount(){
		return $this->discount;
	}
	//set discount
	function setDiscount($discount){
		$this->discount=$discount;
	}

	//get showlogo
	function getShowlogo(){
		return $this->showlogo;
	}
	//set showlogo
	function setShowlogo($showlogo){
		$this->showlogo=$showlogo;
	}
	
	//get getfreightid
	function getFreightid(){
		return $this->freightid;
	}
	//set Freight
	function setFreightid($freightid){
		$this->freightid=$freightid;
	}

	//get statusid
	function getStatusid(){
		return $this->statusid;
	}
	//set statusid
	function setStatusid($statusid){
		$this->statusid=$statusid;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
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
		$customersDBO = new CustomersDBO();
		if($customersDBO->persist($obj)){
			$this->id=$customersDBO->id;
			$this->sql=$customersDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$customersDBO = new CustomersDBO();
		if($customersDBO->update($obj,$where)){
			$this->sql=$customersDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$customersDBO = new CustomersDBO();
		if($customersDBO->delete($obj,$where=""))		
			$this->sql=$customersDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$customersDBO = new CustomersDBO();
		$this->table=$customersDBO->table;
		$customersDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$customersDBO->sql;
		$this->result=$customersDBO->result;
		$this->fetchObject=$customersDBO->fetchObject;
		$this->affectedRows=$customersDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Customer Name should be provided";
		}
		else if(empty($obj->statusid)){
			$error="Status should be provided";
		}
		else if($obj->id==$obj->customerid and !empty($obj->id)){
			$error="Cannot be subclient to itself";
		}
		elseif(empty($obj->currencyid)){
			$error="Must select Currency";
		}
		elseif(empty($obj->flo)){
			$error="FLO should be Provided!";
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
