<?php 
require_once("PlotpaymentdetailsDBO.php");
class Plotpaymentdetails
{				
	var $id;			
	var $plotid;			
	var $clientbankid;			
	var $branch;			
	var $accntno;			
	var $paidon;			
	var $paymentmodeid;			
	var $vatno;			
	var $pin;			
	var $chequesto;								
	var $createdby;
	var $createdon;
	var $lasteditedby;
	var $lasteditedon;	
	var $plotpaymentdetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->plotid=str_replace("'","\'",$obj->plotid);
		$this->clientbankid=str_replace("'","\'",$obj->clientbankid);
		$this->branch=str_replace("'","\'",$obj->branch);
		$this->accntno=str_replace("'","\'",$obj->accntno);
		$this->paidon=str_replace("'","\'",$obj->paidon);
		$this->paymentmodeid=str_replace("'","\'",$obj->paymentmodeid);
		$this->vatno=str_replace("'","\'",$obj->vatno);
		$this->pin=str_replace("'","\'",$obj->pin);
		$this->chequesto=str_replace("'","\'",$obj->chequesto);
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

	//get plotid
	function getPlotid(){
		return $this->plotid;
	}
	//set plotid
	function setPlotid($plotid){
		$this->plotid=$plotid;
	}

	//get clientbankid
	function getClientbankid(){
		return $this->clientbankid;
	}
	//set clientbankid
	function setClientbankid($clientbankid){
		$this->clientbankid=$clientbankid;
	}

	//get branch
	function getBranch(){
		return $this->branch;
	}
	//set branch
	function setBranch($branch){
		$this->branch=$branch;
	}

	//get accntno
	function getAccntno(){
		return $this->accntno;
	}
	//set accntno
	function setAccntno($accntno){
		$this->accntno=$accntno;
	}

	//get paidon
	function getPaidon(){
		return $this->paidon;
	}
	//set paidon
	function setPaidon($paidon){
		$this->paidon=$paidon;
	}

	//get paymentmodeid
	function getPaymentmodeid(){
		return $this->paymentmodeid;
	}
	//set paymentmodeid
	function setPaymentmodeid($paymentmodeid){
		$this->paymentmodeid=$paymentmodeid;
	}

	//get vatno
	function getVatno(){
		return $this->vatno;
	}
	//set vatno
	function setVatno($vatno){
		$this->vatno=$vatno;
	}

	//get pin
	function getPin(){
		return $this->pin;
	}
	//set pin
	function setPin($pin){
		$this->pin=$pin;
	}

	//get chequesto
	function getChequesto(){
		return $this->chequesto;
	}
	//set chequesto
	function setChequesto($chequesto){
		$this->chequesto=$chequesto;
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
		$plotpaymentdetailsDBO = new PlotpaymentdetailsDBO();
		if($plotpaymentdetailsDBO->persist($obj)){
			$this->id=$plotpaymentdetailsDBO->id;
			$this->sql=$plotpaymentdetailsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$plotpaymentdetailsDBO = new PlotpaymentdetailsDBO();
		if($plotpaymentdetailsDBO->update($obj,$where)){
			$this->sql=$plotpaymentdetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$plotpaymentdetailsDBO = new PlotpaymentdetailsDBO();
		if($plotpaymentdetailsDBO->delete($obj,$where=""))		
			$this->sql=$plotpaymentdetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$plotpaymentdetailsDBO = new PlotpaymentdetailsDBO();
		$this->table=$plotpaymentdetailsDBO->table;
		$plotpaymentdetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$plotpaymentdetailsDBO->sql;
		$this->result=$plotpaymentdetailsDBO->result;
		$this->fetchObject=$plotpaymentdetailsDBO->fetchObject;
		$this->affectedRows=$plotpaymentdetailsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->plotid)){
			$error="Plot should be provided";
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
