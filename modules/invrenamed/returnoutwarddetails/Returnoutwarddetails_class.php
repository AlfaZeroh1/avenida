<?php 
require_once("ReturnoutwarddetailsDBO.php");
require_once("../../../modules/inv/assets/Assets_class.php");
require_once("../../../modules/sys/transactions/Transactions_class.php");
require_once("../../../modules/sys/vatclasses/Vatclasses_class.php");
require_once("../../../modules/fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../../modules/fn/generaljournals/Generaljournals_class.php");
require_once("../../../modules/sys/paymentmodes/Paymentmodes_class.php");
class Returnoutwarddetails
{				
	var $id;			
	var $returnoutwardid;			
	var $itemid;
	var $returnedon;
	var $quantity;
	var $types;
	var $transactionid;
	var $assetid;
	var $costprice;			
	var $tax;			
	var $discount;			
	var $total;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $returnoutwarddetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->returnoutwardid))
			$obj->returnoutwardid='NULL';
		$this->returnoutwardid=$obj->returnoutwardid;
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		if(empty($obj->assetid))
			$obj->assetid='NULL';
		$this->assetid=$obj->assetid;
		$this->types=str_replace("'","\'",$obj->typess);
		$this->transactionid=str_replace("'","\'",$obj->transactionid);
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->costprice=str_replace("'","\'",$obj->costprice);
		$this->tax=str_replace("'","\'",$obj->tax);
		$this->returnedon=str_replace("'","\'",$obj->returnedon);
		$this->discount=str_replace("'","\'",$obj->discount);
		$this->total=str_replace("'","\'",$obj->total);
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

	//get returnoutwardid
	function getReturnoutwardid(){
		return $this->returnoutwardid;
	}
	//set returnoutwardid
	function setReturnoutwardid($returnoutwardid){
		$this->returnoutwardid=$returnoutwardid;
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

	//get tax
	function getTax(){
		return $this->tax;
	}
	//set tax
	function setTax($tax){
		$this->tax=$tax;
	}

	//get discount
	function getDiscount(){
		return $this->discount;
	}
	//set discount
	function setDiscount($discount){
		$this->discount=$discount;
	}

	//get total
	function getTotal(){
		return $this->total;
	}
	//set total
	function setTotal($total){
		$this->total=$total;
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
		$returnoutwarddetailsDBO = new ReturnoutwarddetailsDBO();
		$num=count($shop);//print_r($shop);
		$i=0;
		$total=0;
		$ttotal=0;
		//Get transaction Identity
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='returnoutwards'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;
		
		$obj->transactdate=$obj->returnedon;
		$obj->rate=$obj->exchangerate;
		$obj->eurorate=$obj->exchangerate2;
		$obj->currencyid=$obj->currencyid;

		$it=0;

		$ob->transactdate=$obj->returnedon;
		
		while($i<$num){
			$obj->quantity=$shop[$i]['quantity'];
			$obj->itemid=$shop[$i]['itemid'];
			$obj->itemname=$shop[$i]['itemname'];
			$obj->assetid=$shop[$i]['assetid'];
			$obj->assetname=$shop[$i]['assetname'];
			$obj->assetid=$shop[$i]['assetid'];
			$obj->assetname=$shop[$i]['assetname'];
			$obj->code=$shop[$i]['code'];
			$obj->vatclasseid=$shop[$i]['vatclasseid'];
			$obj->tax=$shop[$i]['tax'];
			$obj->vatamount=$shop[$i]['vatamount'];
			$obj->costprice=$shop[$i]['costprice'];
			$obj->tradeprice=$shop[$i]['tradeprice'];
			$obj->discount=$shop[$i]['discount'];
			$obj->remarks=$shop[$i]['remarks'];
			$obj->total=$shop[$i]['total'];
			$obj->ttotal=$shop[$i]['ttotal'];
			$obj->inwarddetailid=$shop[$i]['inwarddetailid'];
			
			$total+=$obj->total;
			
			$obj->total=$obj->total+$obj->vatamount;
			
			$ob = $this->setObject($obj);
			if($returnoutwarddetailsDBO->persist($ob)){		
				
				//indicate in GRN as invoiced
				
				$items = new Items();
				$fields="*";
				$where=" where id='$obj->itemid'";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				$items=$items->fetchObject;
				
				if($obj->vatamount>0){
				  
				  $vatclasses = new Vatclasses();
				  $fields="*";
				  $where=" where id='$obj->vatclasseid'";
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
				  $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $generaljournalaccounts2->sql;
				  $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
				  
				  //make debit entry
				  if($obj->types=='debit'){
				  $generaljournal = new Generaljournals();
				  $ob->tid=$purchasedetails->id;
				  $ob->documentno="$obj->documentno";
				  $ob->remarks="Debit note on $obj->documentno";
				  $ob->memo=$purchasedetails->remarks;
				  $ob->accountid=$generaljournalaccounts2->id;
				  $ob->daccountid=$generaljournalaccounts->id;
				  $ob->transactionid=$transaction->id;
				  $ob->mode="credit";
				  $ob->rate=$obj->rate;
				  $ob->eurorate=$obj->eurorate;
				  $ob->debit=$obj->vatamount;
				  $ob->credit=0;
				  $ob->class=$obj->projectid;
				  
				  }else{
				  $generaljournal = new Generaljournals();
				  $ob->tid=$purchasedetails->id;
				  $ob->documentno="$obj->documentno";
				  $ob->remarks="Credit note on $obj->documentno";
				  $ob->memo=$purchasedetails->remarks;
				  $ob->accountid=$generaljournalaccounts2->id;
				  $ob->daccountid=$generaljournalaccounts->id;
				  $ob->transactionid=$transaction->id;
				  $ob->mode="credit";
				  $ob->rate=$obj->rate;
				  $ob->eurorate=$obj->eurorate;
				  $ob->debit=0;
				  $ob->credit=$obj->vatamount;
				  $ob->class=$obj->projectid;
				  }
                                   
                                  $generaljournal = $generaljournal->setObject($ob);
				  
				  $shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
				  $it++;
				  
				  //credit inventory account
				  if($obj->itemid!='NULL'){
				  $generaljournalaccount = new Generaljournalaccounts();
				  $fields="*";
				  $where=" where refid = '$items->categoryid' and acctypeid='34' ";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $generaljournalaccount->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				  $generaljournalaccount=$generaljournalaccount->fetchObject;
				  }else{				  
// 				  $asset = new Assets();
// 				  $fields="*";
// 				  $where=" where id='$obj->assetid' ";
// 				  $join="";
// 				  $having="";
// 				  $groupby="";
// 				  $orderby="";
// 				  $asset->retrieve($fields, $join, $where, $having, $groupby, $orderby);
// 				  $asset=$asset->fetchObject;
// 				  
// 				  if($obj->types=='debit')
// 				        $quantity=$asset->quantity+$obj->quantity;
// 				  else
// 					$quantity=$asset->quantity-$obj->quantity;
// 				  
// 				  $a = new Assets();
// 				  $a=$a->setObject($asset);
// 				  $a->id=$obj->assetid;
// 				  $a->quantity=$quantity;
// 				  $a->edit($a);
				  
				  $assets = new Assets();
				  $fields="*";
				  $where=" where id='$obj->assetid' ";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $assets->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				  $assets=$assets->fetchObject;
				  
				  $generaljournalaccount = new Generaljournalaccounts();
				  $fields="*";
				  $where=" where refid='$assets->categoryid' and acctypeid='7' ";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $generaljournalaccount->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $generaljournalaccount->sql;
				  $generaljournalaccount=$generaljournalaccount->fetchObject;	
				  }
				  
				  //make credit entry
				  $generaljournal = new Generaljournals();
				  if($obj->types=='debit'){				  
				      $ob->tid=$inwarddetailsDBO->id;
				      $ob->documentno="$obj->documentno";
				      $ob->remarks="Debit Note On GRN $obj->documentno";
				      $ob->memo=$inwarddetailsDBO->remarks;
				      $ob->accountid=$generaljournalaccount->id;
				      $ob->daccountid=$generaljournalaccounts->id;
				      $ob->transactionid=$transaction->id;
				      $ob->mode="credit";
				      $ob->debit=0;
				      $ob->credit=$obj->vatamount;
				      $ob->class=$obj->projectid;
				      $ob->currencyid=$obj->currencyid;
				  }else{
				      $ob->tid=$inwarddetailsDBO->id;
				      $ob->documentno="$obj->documentno";
				      $ob->remarks="Credit Note On GRN $obj->documentno";
				      $ob->memo=$inwarddetailsDBO->remarks;
				      $ob->accountid=$generaljournalaccount->id;
				      $ob->daccountid=$generaljournalaccounts->id;
				      $ob->transactionid=$transaction->id;
				      $ob->mode="credit";
				      $ob->debit=$obj->vatamount;
				      $ob->credit=0;
				      $ob->class=$obj->projectid;
				      $ob->currencyid=$obj->currencyid;
				  }
				  
				  $generaljournal = $generaljournal->setObject($ob);

				  if($generaljournal->debit!=0 or $generaljournal->credit!=0){
				    $shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
				    $it++;
				  }				  
				  
				}				
				
				$this->id=$returnoutwarddetailsDBO->id;
				$this->sql=$returnoutwarddetailsDBO->sql;
			}
			$i++;
		}
		
		$generaljournalaccounts2 = new Generaljournalaccounts();
		$fields="*";
// 		if($obj->purchasemodeid==1)
// 		  $where=" where refid=1 and acctypeid=26 ";
// 		else
		  $where=" where refid = '1' and acctypeid='35' ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
		
		$generaljournalacc = new Generaljournalaccounts();
		$fields="*";
		$where=" where id='$obj->accountid' ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalacc->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$generaljournalacc=$generaljournalacc->fetchObject;
		//make debit entry
		$generaljournal = new Generaljournals();
		if($obj->types=='debit')
		{
		$ob->tid=$purchasedetails->id;
		$ob->documentno="$obj->documentno";
		$ob->remarks="Debit Note On $obj->documentno";
		$ob->memo=$generaljournalacc->name;
		$ob->accountid=$generaljournalaccounts2->id;
		$ob->daccountid=$generaljournalaccounts->id;
		$ob->transactionid=$transaction->id;
		$ob->mode="credit";
		$ob->rate=$obj->rate;
		$ob->eurorate=$obj->eurorate;
		$ob->debit=$total;
		$ob->credit=0;
		$ob->class=$obj->projectid;
		}else{		
		$ob->tid=$purchasedetails->id;
		$ob->documentno="$obj->documentno";
		$ob->remarks="Credit Note On $obj->documentno";
		$ob->memo=$generaljournalacc->name;
		$ob->accountid=$generaljournalaccounts2->id;
		$ob->daccountid=$generaljournalaccounts->id;
		$ob->transactionid=$transaction->id;
		$ob->mode="credit";
		$ob->rate=$obj->rate;
		$ob->eurorate=$obj->eurorate;
		$ob->debit=0;
		$ob->credit=$total;
		$ob->class=$obj->projectid;
		}
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
		if($obj->types=='debit'){
			$ob->tid=$purchasedetails->id;
			$ob->documentno=$obj->documentno;
			$ob->remarks="Debit Note On $obj->documentno";
			$ob->memo="$obj->suppliername";
			$ob->daccountid=$generaljournalaccounts2->id;
			$ob->accountid=$generaljournalaccounts->id;
			$ob->transactionid=$transaction->id;
			$ob->mode="credit";
			$ob->rate=$obj->rate;
			$ob->eurorate=$obj->eurorate;
			$ob->debit=0;
			$ob->credit=$total;
			$ob->class=$obj->projectid;
		}else{
			$ob->tid=$purchasedetails->id;
			$ob->documentno=$obj->documentno;
			$ob->remarks="Credit Note On $obj->documentno";
			$ob->memo="$obj->suppliername";
			$ob->daccountid=$generaljournalaccounts2->id;
			$ob->accountid=$generaljournalaccounts->id;
			$ob->transactionid=$transaction->id;
			$ob->mode="credit";
			$ob->rate=$obj->rate;
			$ob->eurorate=$obj->eurorate;
			$ob->debit=$total;
			$ob->credit=0;
			$ob->class=$obj->projectid;
		}
		$generaljournal2 = $generaljournal2->setObject($ob);
		$shpgeneraljournals[$it]=array('tid'=>"$generaljournal2->tid",'documentno'=>"$generaljournal2->documentno",'remarks'=>"$generaljournal2->remarks",'memo'=>"$generaljournal2->memo",'accountid'=>"$generaljournal2->accountid",'transactionid'=>"$generaljournal2->transactionid",'mode'=>"$generaljournal2->mode",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'debit'=>"$generaljournal2->debit",'credit'=>"$generaljournal2->credit",'transactdate'=>"$generaljournal2->transactdate",'class'=>"$generaljournal->class");
		$it++;

		$gn= new Generaljournals();
		$gn->add($obj,$shpgeneraljournals);

		return true;	
	}			
	function edit($obj,$where=""){
		$returnoutwarddetailsDBO = new ReturnoutwarddetailsDBO();
		if($returnoutwarddetailsDBO->update($obj,$where)){
			$this->sql=$returnoutwarddetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$returnoutwarddetailsDBO = new ReturnoutwarddetailsDBO();
		if($returnoutwarddetailsDBO->delete($obj,$where=""))		
			$this->sql=$returnoutwarddetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$returnoutwarddetailsDBO = new ReturnoutwarddetailsDBO();
		$this->table=$returnoutwarddetailsDBO->table;
		$returnoutwarddetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$returnoutwarddetailsDBO->sql;
		$this->result=$returnoutwarddetailsDBO->result;
		$this->fetchObject=$returnoutwarddetailsDBO->fetchObject;
		$this->affectedRows=$returnoutwarddetailsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->returnoutwardid)){
			$error="Return Outward should be provided";
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
