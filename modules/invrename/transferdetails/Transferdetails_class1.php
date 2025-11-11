<?php 
require_once("TransferdetailsDBO.php");
require_once("../../../modules/sys/transactions/Transactions_class.php");
class Transferdetails
{				
	var $id;			
	var $transferid;			
	var $itemid;	
	var $itemdetailid;
	var $code;			
	var $quantity;			
	var $costprice;			
	var $total;
	var $instalcode;
	var $crdcode;
	var $memo;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $transferdetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->transferid))
			$obj->transferid='NULL';
		$this->transferid=$obj->transferid;
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		
		if(empty($obj->itemdetailid))
			$obj->itemdetailid='NULL';
		$this->itemdetailid=$obj->itemdetailid;
		
		$this->code=str_replace("'","\'",$obj->code);
		$this->instalcode=str_replace("'","\'",$obj->instalcode);
		$this->crdcode=str_replace("'","\'",$obj->crdcode);
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->costprice=str_replace("'","\'",$obj->costprice);
		$this->total=str_replace("'","\'",$obj->total);
		$this->memo=str_replace("'","\'",$obj->memo);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
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

	//get transferid
	function getTransferid(){
		return $this->transferid;
	}
	//set transferid
	function setTransferid($transferid){
		$this->transferid=$transferid;
	}

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get code
	function getCode(){
		return $this->code;
	}
	//set code
	function setCode($code){
		$this->code=$code;
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

	//get total
	function getTotal(){
		return $this->total;
	}
	//set total
	function setTotal($total){
		$this->total=$total;
	}

	//get memo
	function getMemo(){
		return $this->memo;
	}
	//set memo
	function setMemo($memo){
		$this->memo=$memo;
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

	function add($obj,$shop){
		$transferdetailsDBO = new TransferdetailsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		//print_r($shop);
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='Transfers' ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;
		
		$total = 0;
		while($i<$num){
		         //  print_r($shop);
			if(!empty($shop[$i]['id'])){
			  $obj->code=$shop[$i]['code'];
			  $obj->costprice=$shop[$i]['costprice'];
			  $obj->total=$shop[$i]['total'];
			  $obj->itemid=$shop[$i]['itemid'];
			  $obj->itemdetailid=$shop[$i]['itemdetailid'];
			  $obj->itemname=$shop[$i]['itemname'];
			  $obj->quantity=$shop[$i]['quantity'];
			  $obj->memo=$shop[$i]['memo'];
			  $obj->instalcode=$shop[$i]['instalcode'];
			  $obj->crdcode=$shop[$i]['crdcode'];
			  $obj->status=1;
			  
			  $total+=$obj->quantity*$obj->costprice;
			  
			  //$ob = $this->setObject($obj);
			  
			  if($transferdetailsDBO->persist($obj)){	
				  
				  $query="update inv_branchstocks set status='Transferred' where itemdetailid='$obj->itemdetailid' ";
				  mysql_query($query);
				  
				  $this->id=$transferdetailsDBO->id;
				  $this->sql=$transferdetailsDBO->sql;
			  }
			}
		   $i++;
		}
		$shpgeneraljournals = array();
		
			//retrieve account to credit
		$generaljournalaccounts2 = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid is null and acctypeid='34'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;		

				//make debit entry
		$generaljournal = new Generaljournals();
		$ob->tid=$purchasedetails->id;
		$ob->documentno="$obj->documentno";
		$ob->remarks="Transfer # $obj->documentno";
		$ob->memo=$purchasedetails->remarks;
		$ob->accountid=$generaljournalaccounts2->id;
		$ob->daccountid=$generaljournalaccounts->id;
		$ob->transactionid=$transaction->id;
		$ob->mode="credit";
		$ob->debit=$total;
		$ob->credit=0;

		$ob->transactdate=$obj->transferedon;
		$generaljournal->setObject($ob);

		$shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
		$it++;
		
			//retrieve account to credit
		$generaljournalaccounts2 = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='$obj->brancheid' and acctypeid='34'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;		

				//make debit entry
		$generaljournal = new Generaljournals();
		$ob->tid=$purchasedetails->id;
		$ob->documentno="$obj->documentno";
		$ob->remarks="Transfer # $obj->documentno";
		$ob->memo=$purchasedetails->remarks;
		$ob->accountid=$generaljournalaccounts2->id;
		$ob->daccountid=$generaljournalaccounts->id;
		$ob->transactionid=$transaction->id;
		$ob->mode="credit";
		$ob->debit=0;
		$ob->credit=$total;

		$ob->transactdate=$obj->transferedon;
		$generaljournal->setObject($ob);

		$shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
		$it++;
		
		$gn= new Generaljournals();
		$gn->add($obj,$shpgeneraljournals);
		
		return true;	
	}			
	function edit($obj,$where=""){
		$transferdetailsDBO = new TransferdetailsDBO();
		if($transferdetailsDBO->update($obj,$where)){
			$this->sql=$transferdetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$transferdetailsDBO = new TransferdetailsDBO();
		if($transferdetailsDBO->delete($obj,$where=""))		
			$this->sql=$transferdetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$transferdetailsDBO = new TransferdetailsDBO();
		$this->table=$transferdetailsDBO->table;
		$transferdetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$transferdetailsDBO->sql;
		$this->result=$transferdetailsDBO->result;
		$this->fetchObject=$transferdetailsDBO->fetchObject;
		$this->affectedRows=$transferdetailsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->transferid)){
			$error="Transfer should be provided";
		}
		else if(empty($obj->itemid)){
			$error="Product should be provided";
		}
		else if(empty($obj->quantity)){
			$error="Quantity should be provided";
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
