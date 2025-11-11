<?php 
require_once("QuotationsDBO.php");
class Quotations
{				
	var $id;			
	var $itemid;			
	var $documentno;			
	var $customerid;			
	var $agentid;			
	var $employeeid;			
	var $description;			
	var $quantity;			
	var $costprice;			
	var $tradeprice;			
	var $retailprice;			
	var $discount;			
	var $tax;			
	var $bonus;			
	var $total;			
	var $status;			
	var $quotedon;			
	var $memo;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $quotationsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		$this->documentno=str_replace("'","\'",$obj->documentno);
		if(empty($obj->customerid))
			$obj->customerid='NULL';
		$this->customerid=$obj->customerid;
		if(empty($obj->agentid))
			$obj->agentid='NULL';
		$this->agentid=$obj->agentid;
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->description=str_replace("'","\'",$obj->description);
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->costprice=str_replace("'","\'",$obj->costprice);
		$this->tradeprice=str_replace("'","\'",$obj->tradeprice);
		$this->retailprice=str_replace("'","\'",$obj->retailprice);
		$this->discount=str_replace("'","\'",$obj->discount);
		$this->tax=str_replace("'","\'",$obj->tax);
		$this->bonus=str_replace("'","\'",$obj->bonus);
		$this->total=str_replace("'","\'",$obj->total);
		$this->status=str_replace("'","\'",$obj->status);
		$this->quotedon=str_replace("'","\'",$obj->quotedon);
		$this->memo=str_replace("'","\'",$obj->memo);
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

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get customerid
	function getCustomerid(){
		return $this->customerid;
	}
	//set customerid
	function setCustomerid($customerid){
		$this->customerid=$customerid;
	}

	//get agentid
	function getAgentid(){
		return $this->agentid;
	}
	//set agentid
	function setAgentid($agentid){
		$this->agentid=$agentid;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get description
	function getDescription(){
		return $this->description;
	}
	//set description
	function setDescription($description){
		$this->description=$description;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get costprice
	function getCostprice(){
		return $this->costprice;
	}
	//set costprice
	function setCostprice($costprice){
		$this->costprice=$costprice;
	}

	//get tradeprice
	function getTradeprice(){
		return $this->tradeprice;
	}
	//set tradeprice
	function setTradeprice($tradeprice){
		$this->tradeprice=$tradeprice;
	}

	//get retailprice
	function getRetailprice(){
		return $this->retailprice;
	}
	//set retailprice
	function setRetailprice($retailprice){
		$this->retailprice=$retailprice;
	}

	//get discount
	function getDiscount(){
		return $this->discount;
	}
	//set discount
	function setDiscount($discount){
		$this->discount=$discount;
	}

	//get tax
	function getTax(){
		return $this->tax;
	}
	//set tax
	function setTax($tax){
		$this->tax=$tax;
	}

	//get bonus
	function getBonus(){
		return $this->bonus;
	}
	//set bonus
	function setBonus($bonus){
		$this->bonus=$bonus;
	}

	//get total
	function getTotal(){
		return $this->total;
	}
	//set total
	function setTotal($total){
		$this->total=$total;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
	}

	//get quotedon
	function getQuotedon(){
		return $this->quotedon;
	}
	//set quotedon
	function setQuotedon($quotedon){
		$this->quotedon=$quotedon;
	}

	//get memo
	function getMemo(){
		return $this->memo;
	}
	//set memo
	function setMemo($memo){
		$this->memo=$memo;
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

	function add($obj,$shop){
		$quotationsDBO = new QuotationsDBO();
			if($quotationsDBO->persist($obj)){		
				$this->id=$quotationsDBO->id;
				$this->sql=$quotationsDBO->sql;
			}
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$quotationsDBO = new QuotationsDBO();

		//first delete all records under old documentno
		$where=" where documentno='$obj->olddocumentno' and mode='$obj->oldmode'";
		$quotationsDBO->delete($obj,$where);

		$gn = new GeneralJournals();
		$where=" where documentno='$obj->olddocumentno' and transactionid='2' mode='$obj->oldmode' ";
		$gn->delete($obj,$where);

		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){

			$total+=$obj->total;

			$obj->quantity=$shop['quantity'];
			$obj->itemid=$shop['itemid'];
			$obj->itemname=$shop['itemname'];
			$obj->code=$shop['code'];
			$obj->tax=$shop['tax'];
			$obj->discount=$shop['discount'];
			$obj->retailprice=$shop['retailprice'];
			$obj->tradeprice=$shop['tradeprice'];
			if($quotationsDBO->update($obj,$where)){
				$this->sql=$quotationsDBO->sql;
			}
		}
		return true;	
	}			
	function delete($obj,$where=""){			
		$quotationsDBO = new QuotationsDBO();
		if($quotationsDBO->delete($obj,$where=""))		
			$this->sql=$quotationsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$quotationsDBO = new QuotationsDBO();
		$this->table=$quotationsDBO->table;
		$quotationsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$quotationsDBO->sql;
		$this->result=$quotationsDBO->result;
		$this->fetchObject=$quotationsDBO->fetchObject;
		$this->affectedRows=$quotationsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->itemid)){
			$error="Item should be provided";
		}
		else if(empty($obj->documentno)){
			$error="Quote No should be provided";
		}
		else if(empty($obj->customerid)){
			$error="Customer should be provided";
		}
		else if(empty($obj->quotedon)){
			$error="Quoted On should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->documentno)){
			$error="Quote No should be provided";
		}
		else if(empty($obj->customerid)){
			$error="Customer should be provided";
		}
		else if(empty($obj->quotedon)){
			$error="Quoted On should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
