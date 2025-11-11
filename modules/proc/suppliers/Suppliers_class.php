<?php 
require_once("SuppliersDBO.php");
class Suppliers
{				
	var $id;			
	var $code;			
	var $name;			
	var $suppliercategoryid;
	var $currencyid;
	var $countryid;
	var $regionid;			
	var $subregionid;			
	var $contact;			
	var $physicaladdress;			
	var $tel;
	var $pinno;
	var $vatno;
	var $etrno;
	var $fax;			
	var $email;			
	var $cellphone;			
	var $status;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $suppliersDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->code=str_replace("'","\'",$obj->code);
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->suppliercategoryid))
			$obj->suppliercategoryid='NULL';
		$this->suppliercategoryid=$obj->suppliercategoryid;
		if(empty($obj->regionid))
			$obj->regionid='NULL';
		$this->regionid=$obj->regionid;
		if(empty($obj->currencyid))
			$obj->currencyid='NULL';
		$this->currencyid=$obj->currencyid;
		
		if(empty($obj->countryid))
			$obj->countryid='NULL';
		$this->countryid=$obj->countryid;
		
		if(empty($obj->subregionid))
			$obj->subregionid='NULL';
		$this->subregionid=$obj->subregionid;
		$this->contact=str_replace("'","\'",$obj->contact);
		$this->physicaladdress=str_replace("'","\'",$obj->physicaladdress);
		$this->tel=str_replace("'","\'",$obj->tel);
		$this->pinno=str_replace("'","\'",$obj->pinno);
		$this->vatno=str_replace("'","\'",$obj->vatno);
		$this->etrno=str_replace("'","\'",$obj->etrno);
		$this->fax=str_replace("'","\'",$obj->fax);
		$this->email=str_replace("'","\'",$obj->email);
		$this->cellphone=str_replace("'","\'",$obj->cellphone);
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

	//get suppliercategoryid
	function getSuppliercategoryid(){
		return $this->suppliercategoryid;
	}
	//set suppliercategoryid
	function setSuppliercategoryid($suppliercategoryid){
		$this->suppliercategoryid=$suppliercategoryid;
	}

	//get regionid
	function getRegionid(){
		return $this->regionid;
	}
	//set regionid
	function setRegionid($regionid){
		$this->regionid=$regionid;
	}

	//get subregionid
	function getSubregionid(){
		return $this->subregionid;
	}
	//set subregionid
	function setSubregionid($subregionid){
		$this->subregionid=$subregionid;
	}

	//get contact
	function getContact(){
		return $this->contact;
	}
	//set contact
	function setContact($contact){
		$this->contact=$contact;
	}

	//get physicaladdress
	function getPhysicaladdress(){
		return $this->physicaladdress;
	}
	//set physicaladdress
	function setPhysicaladdress($physicaladdress){
		$this->physicaladdress=$physicaladdress;
	}

	//get tel
	function getTel(){
		return $this->tel;
	}
	//set tel
	function setTel($tel){
		$this->tel=$tel;
	}
	
	//get pinno
	function getPinno(){
		return $this->pinno;
	}
	//set pinno
	function setPinno($tel){
		$this->pinno=$pinno;
	}
	
	//get vatno
	function getVatno(){
		return $this->vatno;
	}
	//set vatno
	function setvatno($vatno){
		$this->vatno=$vatno;
	}
	
	//get etrno
	function getEtrno(){
		return $this->etrno;
	}
	//set etrno
	function setEtrno($etrno){
		$this->etrno=$etrno;
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

	//get cellphone
	function getCellphone(){
		return $this->cellphone;
	}
	//set cellphone
	function setCellphone($cellphone){
		$this->cellphone=$cellphone;
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
		$suppliersDBO = new SuppliersDBO();
		if($suppliersDBO->persist($obj)){
		
			$obj->module="proc";
			$obj->role="suppliers";
			
			$tasks = new Tasks();
			$tasks->workFlow($obj);
		
			$this->id=$suppliersDBO->id;
			$this->sql=$suppliersDBO->sql;
			return true;	
			
			
				
		}
	}			
	function edit($obj,$where=""){
		$suppliersDBO = new SuppliersDBO();
		if($suppliersDBO->update($obj,$where)){
			$this->sql=$suppliersDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$suppliersDBO = new SuppliersDBO();
		if($suppliersDBO->delete($obj,$where=""))		
			$this->sql=$suppliersDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$suppliersDBO = new SuppliersDBO();
		$this->table=$suppliersDBO->table;
		$suppliersDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$suppliersDBO->sql;
		$this->result=$suppliersDBO->result;
		$this->fetchObject=$suppliersDBO->fetchObject;
		$this->affectedRows=$suppliersDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Supplier Name should be provided";
		}
		else if(empty($obj->currencyid)){
			$error="Currency should be provided";
		}
		else if(empty($obj->countryid)){
			$error="Country should be provided";
		}
		else if(empty($obj->status)){
			$error="Status should be provided";
		}
		elseif($this->uniqueName($obj)){
			$error="Name already in use";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
	
	function uniqueName($obj){
	    $suppliers = new Suppliers();
	    $fields="*";
	    $where=" where trim(lower(name))=trim(lower('$obj->name'))";
	    if(!empty($obj->id))
	      $where.=" and id!='$obj->id'";
	    $join="";
	    $having="";
	    $groupby="";
	    $orderby="";
	    $suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	    if($suppliers->affectedRows>0)
	      return true;
	    else
	      return false;
	}
}				
?>
