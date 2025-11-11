<?php 
require_once("PurchasedetailsDBO.php");
require_once("../../../modules/inv/assets/Assets_class.php");
class Purchasedetails
{				
	var $id;			
	var $purchaseid;
	var $purchasemodeid;
	var $itemid;
	var $assetid;
	var $inwardno;
	var $quantity;			
	var $costprice;			
	var $discount;
	var $discountamount;
	var $vatclasseid;
	var $tax;
	var $vatamount;
	var $bonus;			
	var $total;			
	var $memo;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $purchasedetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->purchaseid=str_replace("'","\'",$obj->purchaseid);
		
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		
		if(empty($obj->assetid))
			$obj->assetid='NULL';
		$this->assetid=$obj->assetid;
		
		$this->inwardno=$obj->inwardno;
		$this->purchasemodeid=$obj->purchasemodeid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->costprice=str_replace("'","\'",$obj->costprice);
		$this->discount=str_replace("'","\'",$obj->discount);
		$this->discountamount=str_replace("'","\'",$obj->discountamount);
		$this->vatclasseid=str_replace("'","\'",$obj->vatclasseid);
		$this->tax=str_replace("'","\'",$obj->tax);
		$this->vatamount=str_replace("'","\'",$obj->vatamount);
		$this->bonus=str_replace("'","\'",$obj->bonus);
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

	//get purchaseid
	function getPurchaseid(){
		return $this->purchaseid;
	}
	//set purchaseid
	function setPurchaseid($purchaseid){
		$this->purchaseid=$purchaseid;
	}

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
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
		$purchasedetailsDBO = new PurchasedetailsDBO();
		$num=count($shop);//print_r($shop);
		$i=0;
		$total=0;
		$ttotal=0;
		$vat=0;
		//Get transaction Identity
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='purchases'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;
		
		$obj->transactdate=$obj->boughton;
		$obj->rate=$obj->exchangerate;
		$obj->eurorate=$obj->exchangerate2;
		$obj->currencyid=$obj->currencyid;

		$it=0;

		$ob->transactdate=$obj->boughton;
		$vats = array();
		
		while($i<$num){
			$obj->quantity=$shop[$i]['quantity'];
			$obj->itemid=$shop[$i]['itemid'];
			$obj->itemname=$shop[$i]['itemname'];
			$obj->assetid=$shop[$i]['assetid'];
			$obj->assetname=$shop[$i]['assetname'];
			$obj->accountid=$shop[$i]['accountid'];
			$obj->code=$shop[$i]['code'];
			$obj->vatclasseid=$shop[$i]['vatclasseid'];
			$obj->tax=$shop[$i]['tax'];
			$obj->vatamount=$shop[$i]['vatamount'];
			$obj->costprice=$shop[$i]['costprice'];
			$obj->tradeprice=$shop[$i]['tradeprice'];
			$obj->discount=$shop[$i]['discount'];
			$obj->discountamount=$shop[$i]['discountamount'];
			$obj->memo=$shop[$i]['memo'];
			$obj->total=$shop[$i]['total'];
			$obj->ttotal=$shop[$i]['ttotal'];
			$obj->inwarddetailid=$shop[$i]['inwarddetailid'];
			
			$total+=$obj->total;
			$ttotal+=$obj->ttotal;
			$vats[$obj->vatclasseid]['amount']+=$obj->vatamount;
			
			$obj->totals=$obj->total;
			$obj->total=$obj->total+$obj->vatamount;
			
			$ob = $this->setObject($obj);
			$ob->effectjournals=$obj->effectjournals;
			if($purchasedetailsDBO->persist($ob)){		
				
				//indicate in GRN as invoiced
				if(!empty($obj->inwarddetailid))
				  mysql_query("update proc_inwarddetails set status=1 where id='$obj->inwarddetailid'");
			}
			$i++;
		}
		
		//make credit entries to VAT liability accounts
		foreach ($vats as $key => $value) {
		  if($value>0){
				    
		      $vatclasses = new Vatclasses();
		      $fields="*";
		      $where=" where id='$key'";
		      $join="";
		      $having="";
		      $groupby="";
		      $orderby="";
		      $vatclasses->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $vatclasses->sql;
		      $vatclasses=$vatclasses->fetchObject;
		      
		      //debit Vat account
		      $generaljournalaccounts2 = new Generaljournalaccounts();
		      $fields="*";
		      $where=" where refid = '$vatclasses->liabilityid' and acctypeid=35 ";
		      $join="";
		      $having="";
		      $groupby="";
		      $orderby="";
		      $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		      $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
		      
		      $config = new Config();
		      $fields=" * ";
		      $join="  ";
		      $where=" where id='3' ";
		      $config->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		      $config = $config->fetchObject;
		      
		      //credit Vat control account
		      $generaljournalaccounts = new Generaljournalaccounts();
		      $fields="*";
		      $where=" where refid = '$config->value' and acctypeid=35 ";
		      $join="";
		      $having="";
		      $groupby="";
		      $orderby="";
		      $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		      $generaljournalaccounts=$generaljournalaccounts->fetchObject;
		      
		      //make debit entry
		      $generaljournal = new Generaljournals();
		      $ob->tid=$purchasedetails->id;
		      $ob->documentno="$obj->documentno";
		      $ob->remarks="$obj->receiptno: ".$obj->suppliername;
		      $ob->memo=$purchasedetails->remarks;
		      $ob->accountid=$generaljournalaccounts2->id;
		      $ob->transactionid=$transaction->id;
		      $ob->mode="credit";
		      $ob->rate=$obj->rate;
		      $ob->eurorate=$obj->eurorate;
		      $ob->debit=$value['amount'];
		      $ob->credit=0;
		      $ob->class=$obj->projectid;
		      $generaljournal = $generaljournal->setObject($ob);

		      $shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
		      $it++;
		      
		      //make debit entry
		      $generaljournal = new Generaljournals();
		      $ob->tid=$purchasedetails->id;
		      $ob->documentno="$obj->documentno";
		      $ob->remarks="$obj->receiptno: ".$obj->suppliername;
		      $ob->memo=$purchasedetails->remarks;
		      $ob->accountid=$generaljournalaccounts->id;
		      $ob->transactionid=$transaction->id;
		      $ob->mode="credit";
		      $ob->rate=$obj->rate;
		      $ob->eurorate=$obj->eurorate;
		      $ob->credit=$value['amount'];
		      $ob->balance=$value['amount'];
		      $ob->debit=0;
		      $ob->class=$obj->projectid;
		      $generaljournal = $generaljournal->setObject($ob);

		      $shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'debit'=>"$generaljournal->debit",'balance'=>"$generaljournal->balance",'credit'=>"$generaljournal->credit",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
		      $it++;
		      
		    }
		}
		
		//make debit entry to stock control account
		//get stock control account from configuration
		$config = new Config();
		$fields=" * ";
		$join="  ";
		$where=" where id='3' ";
		$config->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$config = $config->fetchObject;
		
		$generaljournalaccounts2 = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid = '$config->value' and acctypeid='35' ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;

		//make debit entry
		$generaljournal = new Generaljournals();
		$ob->tid=$purchasedetails->id;
		$ob->remarks="$obj->receiptno: ".$obj->suppliername;
		$ob->remarks="$obj->documentno";
		$ob->memo=$generaljournalacc->name;
		$ob->accountid=$generaljournalaccounts2->id;
		$ob->daccountid=$generaljournalaccounts->id;
		$ob->transactionid=$transaction->id;
		$ob->mode="credit";
		$ob->rate=$obj->rate;
		$ob->eurorate=$obj->eurorate;
		$ob->debit=$ttotal;
		$ob->credit=0;
		$ob->class=$obj->projectid;
		$generaljournal = $generaljournal->setObject($ob);

		$shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
		$it++;

		if($obj->purchasemodeid==1){
		  $paymentmodes = new Paymentmodes();
		  $fields="*";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $where=" where id='$obj->paymentmodeid' ";
		  $paymentmodes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $paymentmodes=$paymentmodes->fetchObject;
		 
		  if(!empty($obj->imprestaccountid) and !is_null($obj->imprestaccountid) and $obj->imprestaccountid>0)
		    $obj->bankid=$obj->imprestaccountid;
		    
		  if(empty($obj->bankid) or is_null($obj->bankid) or $obj->bankid=="NULL"){
			  $obj->bankid=1;
		  }
		  
		  if($obj->paymentmodeid==1 or $obj->paymentmodeid==5)
		      $obj->bankid=1;
		      
		      
		  if($obj->paymentmodeid==1){
			  $acctype=24;
			  $obj->bankid=1;
		  }
		  if($obj->paymentmodeid==2 or $obj->paymentmodeid==3 or $obj->paymentmodeid==6){
			  $acctype=8;
			  $obj->bankid=$obj->bankid;
		  }
		  if($obj->paymentmodeid==7){
			  $acctype=24;
			  $obj->bankid=$obj->imprestaccountid;
		  }
		  if($obj->paymentmodeid==11){
			  $acctype=36;
			  $obj->bankid=$obj->employeeid;
		  }
		  if($obj->paymentmodeid==5){
			  //$acctype=24;
					  
			  $obj->bankid=$obj->lplotid;
		  }
		}
		else{
		  $paymentmodes->acctypeid=30;
		  $obj->bankid=$obj->supplierid;
		}

				//retrieve account to credit
		$generaljournalaccounts = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='$obj->bankid' and acctypeid='$paymentmodes->acctypeid'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$generaljournalaccounts=$generaljournalaccounts->fetchObject;

				//retrieve account to credit

				//make credit entry
		$generaljournal2 = new Generaljournals();
		$ob->tid=$purchasedetails->id;
		$ob->documentno=$obj->documentno;
		$ob->remarks="$obj->receiptno";
		$ob->memo=$obj->remarks;
		$ob->daccountid=$generaljournalaccounts2->id;
		$ob->accountid=$generaljournalaccounts->id;
		$ob->transactionid=$transaction->id;
		$ob->mode="credit";
		$ob->rate=$obj->rate;
		$ob->eurorate=$obj->eurorate;
		$ob->debit=0;
		$ob->credit=$ttotal;
		$ob->balance=$ttotal;
		$ob->class=$obj->projectid;
		$generaljournal2 = $generaljournal2->setObject($ob);
		$shpgeneraljournals[$it]=array('tid'=>"$generaljournal2->tid",'documentno'=>"$generaljournal2->documentno",'remarks'=>"$generaljournal2->remarks",'memo'=>"$generaljournal2->memo",'accountid'=>"$generaljournal2->accountid",'transactionid'=>"$generaljournal2->transactionid",'mode'=>"$generaljournal2->mode",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'debit'=>"$generaljournal2->debit",'balance'=>"$generaljournal2->balance",'credit'=>"$generaljournal2->credit",'transactdate'=>"$generaljournal2->transactdate",'class'=>"$generaljournal->class");
		$it++;
		
		if($obj->balance>0){
		  		//retrieve account to credit
		    $generaljournalaccounts = new Generaljournalaccounts();
		    $fields="*";
		    $where=" where refid='1' and acctypeid='24'";
		    $join="";
		    $having="";
		    $groupby="";
		    $orderby="";
		    $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		    $generaljournalaccounts=$generaljournalaccounts->fetchObject;

				    //retrieve account to credit

				    //make credit entry
		    $generaljournal2 = new Generaljournals();
		    $ob->tid=$purchasedetails->id;
		    $ob->documentno=$obj->documentno;
		    $ob->remarks="$obj->documentno from $obj->suppliername";
		    $ob->memo=$purchasedetails->remarks;
		    $ob->daccountid=$generaljournalaccounts2->id;
		    $ob->accountid=$generaljournalaccounts->id;
		    $ob->transactionid=$transaction->id;
		    $ob->mode="credit";
		    $ob->rate=$obj->rate;
		    $ob->eurorate=$obj->eurorate;
		    $ob->credit=0;
		    $ob->debit=$obj->balance;
		    $ob->class=$obj->projectid;
		    $generaljournal2 = $generaljournal2->setObject($ob);
		    $shpgeneraljournals[$it]=array('tid'=>"$generaljournal2->tid",'documentno'=>"$generaljournal2->documentno",'remarks'=>"$generaljournal2->remarks",'memo'=>"$generaljournal2->memo",'accountid'=>"$generaljournal2->accountid",'transactionid'=>"$generaljournal2->transactionid",'mode'=>"$generaljournal2->mode",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'debit'=>"$generaljournal2->debit",'credit'=>"$generaljournal2->credit",'transactdate'=>"$generaljournal2->transactdate",'class'=>"$generaljournal->class");
		    
		}
// print_r($shpgeneraljournals);
		$gn= new Generaljournals();
		$gn->add($obj,$shpgeneraljournals);

		return true;	
	}			
	function edit($obj,$where=""){
		$purchasedetailsDBO = new PurchasedetailsDBO();
		if($purchasedetailsDBO->update($obj,$where)){
			$this->sql=$purchasedetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where){			
		$purchasedetailsDBO = new PurchasedetailsDBO();
		if($purchasedetailsDBO->delete($obj,$where))		
			$this->sql=$purchasedetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$purchasedetailsDBO = new PurchasedetailsDBO();
		$this->table=$purchasedetailsDBO->table;
		$purchasedetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$purchasedetailsDBO->sql;
		$this->result=$purchasedetailsDBO->result;
		$this->fetchObject=$purchasedetailsDBO->fetchObject;
		$this->affectedRows=$purchasedetailsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->purchaseid)){
			$error="Purchase should be provided";
		}
		else if(empty($obj->itemid)){
			$error="Item should be provided";
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
