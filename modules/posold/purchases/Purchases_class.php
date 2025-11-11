<?php 
require_once("PurchasesDBO.php");
class Purchases
{				
	var $id;			
	var $itemid;			
	var $documentno;			
	var $supplierid;			
	var $description;			
	var $quantity;			
	var $costprice;			
	var $tradeprice;			
	var $discount;			
	var $tax;			
	var $bonus;			
	var $total;			
	var $mode;			
	var $boughton;			
	var $memo;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $purchasesDBO;
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
		if(empty($obj->supplierid))
			$obj->supplierid='NULL';
		$this->supplierid=$obj->supplierid;
		$this->description=str_replace("'","\'",$obj->description);
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->costprice=str_replace("'","\'",$obj->costprice);
		$this->tradeprice=str_replace("'","\'",$obj->tradeprice);
		$this->discount=str_replace("'","\'",$obj->discount);
		$this->tax=str_replace("'","\'",$obj->tax);
		$this->bonus=str_replace("'","\'",$obj->bonus);
		$this->total=str_replace("'","\'",$obj->total);
		$this->mode=str_replace("'","\'",$obj->mode);
		$this->boughton=str_replace("'","\'",$obj->boughton);
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

	//get supplierid
	function getSupplierid(){
		return $this->supplierid;
	}
	//set supplierid
	function setSupplierid($supplierid){
		$this->supplierid=$supplierid;
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

	//get mode
	function getMode(){
		return $this->mode;
	}
	//set mode
	function setMode($mode){
		$this->mode=$mode;
	}

	//get boughton
	function getBoughton(){
		return $this->boughton;
	}
	//set boughton
	function setBoughton($boughton){
		$this->boughton=$boughton;
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
		$purchasesDBO = new PurchasesDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){

			$total+=$obj->total;

			$obj->itemid=$shop[$i]['itemid'];
			$obj->itemname=$shop[$i]['itemname'];
			$obj->code=$shop[$i]['code'];
			$obj->tax=$shop[$i]['tax'];
			$obj->discount=$shop[$i]['discount'];
			$obj->costprice=$shop[$i]['costprice'];
			$obj->tradeprice=$shop[$i]['tradeprice'];
			$obj->quantity=$shop[$i]['quantity'];
			if($purchasesDBO->persist($obj)){		
				$this->id=$purchasesDBO->id;
				$this->sql=$purchasesDBO->sql;
			}
			$i++;
		}
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$purchasesDBO = new PurchasesDBO();

		//first delete all records under old documentno
		$where=" where documentno='$obj->olddocumentno' and mode='$obj->oldmode'";
		$purchasesDBO->delete($obj,$where);

		$gn = new GeneralJournals();
		$where=" where documentno='$obj->olddocumentno' and transactionid='2' mode='$obj->oldmode' ";
		$gn->delete($obj,$where);

		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){

			$total+=$obj->total;

			$obj->itemid=$shop['itemid'];
			$obj->itemname=$shop['itemname'];
			$obj->code=$shop['code'];
			$obj->tax=$shop['tax'];
			$obj->discount=$shop['discount'];
			$obj->costprice=$shop['costprice'];
			$obj->tradeprice=$shop['tradeprice'];
			$obj->quantity=$shop['quantity'];
			if($purchasesDBO->update($obj,$where)){
				$this->sql=$purchasesDBO->sql;
			}
		}
		return true;	
	}			
	function delete($obj,$where=""){			
		$purchasesDBO = new PurchasesDBO();
		if($purchasesDBO->delete($obj,$where=""))		
			$this->sql=$purchasesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$purchasesDBO = new PurchasesDBO();
		$this->table=$purchasesDBO->table;
		$purchasesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$purchasesDBO->sql;
		$this->result=$purchasesDBO->result;
		$this->fetchObject=$purchasesDBO->fetchObject;
		$this->affectedRows=$purchasesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->documentno)){
			$error="Document No. should be provided";
		}else if(empty($obj->supplierid)){
			$error="Supplier should be provided";
		}else if(empty($obj->description)){
			$error="Description should be provided";
		}else if(empty($obj->quantity)){
			$error="Quantity should be provided";
		}else if(empty($obj->costprice)){
			$error="Cost Price should be provided";
		}else if(empty($obj->tradeprice)){
			$error="Trade Price should be provided";
		}else if(empty($obj->discount)){
			$error="Discount should be provided";
		}else if(empty($obj->tax)){
			$error="Tax should be provided";
		}else if(empty($obj->bonus)){
			$error="Bonus should be provided";
		}else if(empty($obj->total)){
			$error="Total Taxable Purchase should be provided";
		}else if(empty($obj->mode)){
			$error="Purchase Mode should be provided";
		}else if(empty($obj->boughton)){
			$error="Bought On should be provided";
		}else if(empty($obj->createdby)){
			$error="CreatedBy should be provided";
		}else if(empty($obj->createdon)){
			$error="CreatedOn should be provided";
		}else if(empty($obj->lasteditedby)){
			$error="LastEditedBy should be provided";
		}else if(empty($obj->lasteditedon)){
			$error="LastEditedOn should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->documentno)){
			$error="Document No. should be provided";
		}else if(empty($obj->supplierid)){
			$error="Supplier should be provided";
		}else if(empty($obj->mode)){
			$error="Purchase Mode should be provided";
		}else if(empty($obj->boughton)){
			$error="Bought On should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
