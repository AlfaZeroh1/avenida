<?php
require_once("../../../DB.php");
require_once("../generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("Generaljournals_class.php");
require_once("../../em/houses/Houses_class.php");

$db = new DB();

/*$sql="select * from em_tenantpayments where paymenttermid=1";
$res=mysql_query($sql);
while($row=mysql_fetch_object($res)){echo $row->tenantid."\n";
	$rw=mysql_fetch_object(mysql_query("select em_plots.* from em_plots, em_houses where em_houses.id='$row->houseid' and em_houses.plotid=em_plots.id"));
	if($rw->commissiontype==1)
		$obj->amount=$row->amount*$rw->commission/100;
	else
		$obj->amount=$rw->commission;
	$obj->remarks="";
	$obj->memo="";
	
	$acc=mysql_fetch_object(mysql_query("select * from fn_generaljournalaccounts where refid='$rw->landlordid' and acctypeid='33'"));
	
	$r=mysql_fetch_object(mysql_query("select max(documentno) doc from fn_inctransactions"));
	@$sql="insert into fn_inctransactions(id,incomeid,amount,paymentmodeid,bank,chequeno,incomedate,remarks,memo,drawer,jvno,documentno,createdby,createdon,lasteditedby,lasteditedon)
	values('','1','$obj->amount',NULL,'$obj->bank','$obj->chequeno','$row->paidon','$obj->remarks','$obj->memo','$obj->drawer','$obj->jvno','$r->doc','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";
	if(mysql_query($sql)){
		$obj->tid=mysql_insert_id();
		@$ql="insert into fn_generaljournals(id,accountid,daccountid,tid,documentno,mode,transactionid,remarks,memo,transactdate,debit,credit,jvno,chequeno,did,reconstatus,recondate,class,createdby,createdon,lasteditedby,lasteditedon)
		values('','1','$acc->id','$obj->tid','$r->doc','$obj->mode','6','$obj->remarks','$obj->memo','$row->paidon','0','$obj->amount','$obj->jvno','$obj->chequeno','$obj->did','$obj->reconstatus','$obj->recondate','A','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";
		mysql_query($ql);
		$did=mysql_insert_id();
		
		@$l="insert into fn_generaljournals(id,accountid,daccountid,tid,documentno,mode,transactionid,remarks,memo,transactdate,debit,credit,jvno,chequeno,did,reconstatus,recondate,class,createdby,createdon,lasteditedby,lasteditedon)
		values('','$acc->id','1','$obj->tid','$r->doc','$obj->mode','6','$obj->remarks','$obj->memo','$row->paidon','$obj->amount','0','$obj->jvno','$obj->chequeno','$did','$obj->reconstatus','$obj->recondate','A','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";
		mysql_query($l);echo mysql_error();
		$did2=mysql_insert_id();
		mysql_query("update fn_generaljournals set did='$did2' where id='$did'");
	}echo mysql_error();
}*/
/*$res=mysql_query("show tables");
while($row=mysql_fetch_array($res)){
	$sql="show index from $row[0]";
	$rs=mysql_query($sql);
	while($rw=mysql_fetch_object($rs)){
		if($rw->Key_name!="PRIMARY"){
			mysql_query("alter table $row[0] drop foreign key $rw->Key_name");
			mysql_query("alter table $row[0] drop index $rw->Key_name");
			$ext=explode("wd", $rw->Key_name);
			mysql_query("alter table $row[0] add constraint $rw->Key_name foreign key($rw->Column_name) references $ext[2](id)");
		}
	}*/
	
	
		/*echo $row[0]."\n";
		mysql_query("SET FOREIGN_KEY_CHECKS=0;");
		if(mysql_query("truncate $row[0]"))
				echo "";
		else 
			echo " => Could not Truncate";*/
		/*while($rw=mysql_fetch_array($rs)){
			if($rw[2]=="NO")
				$rw[2]="not null";
			else
			    $rw[2]="";
			
			if($rw[3]=="MUL")
				$rw[3]="";
			
			$desc=mysql_fetch_object(mysql_query("select * from test.summary where tbl='$row[0]' and name='$rw[0]'"));
			$ql="alter table $row[0] modify $rw[0] $rw[1] $rw[2] $rw[3] $rw[4] $rw[5] comment '".initialCap($desc->comment)."';";echo $ql;
			if(mysql_query($ql))
				echo "Modified $row[0].$rw[0]";
			else
				echo "Could not Modify";*/
			
			//print_r($rw);
		//}
	//}
	//$sql="alter table $row[0] modify id int(11) auto_increment primary key";
	/*if(substr($row[0], 0,7)=="payroll"){
		$sql = "rename table $row[0] to ".str_replace('payroll', 'hrm', $row[0]);echo $sql;
		echo $row[0]."\n";
		if(mysql_query($sql))
			echo"Updated $row[0]\n";
	}*/
	//if(mysql_query($sql))
		//echo"Updated $row[0]\n";
//}


/*$sql="select table_name from information_schema.tables where table_schema='jk' and table_name like 'em_%'";
$res=mysql_query($sql);
while($row=mysql_fetch_object($res)){
	echo "alter table $row->table_name add createdby int(11), add createdon datetime, add lasteditedby int(11), add lasteditedon datetime";
	if(@mysql_query("alter table $row->table_name add createdby int(11), add createdon datetime, add lasteditedby int(11), add lasteditedon datetime"))
		echo $row->table_name."\n";
	else
		echo "Could not alter ".$row->table_name."\n".mysql_error();
}*/

/*$sql="select table_name from information_schema.tables where table_schema='wisecoder' and table_name like 'auth_%' or table_name like 'inv_%' or table_name like 'pos_%' or table_name like 'crm_%' or table_name like 'hrm_%' or table_name like 'em_%'";
$res=mysql_query($sql);
while($row=mysql_fetch_object($res)){
	//echo "alter table $row->table_name add ipaddress varchar(32)";
	//if(@mysql_query("alter table $row->table_name add ipaddress varchar(32)"))
	if(@mysql_query("alter table $row->table_name add createdby int(11), add createdon datetime, add lasteditedby int(11), add lasteditedon datetime"))
		echo $row->table_name."\n";
	else
		echo "Could not alter ".$row->table_name."\n".mysql_error();
}*/

/*function listFolderFiles($dir,$dr="",$dest=""){ 
    $ffs = scandir($dir); 
    foreach($ffs as $ff){
       // if(is_array($exclude) and !in_array($ff,$exclude)){ 
            if($ff != '.' && $ff != '..'){ 
            if(!is_dir($dir.'/'.$ff)){ 
            	$pos=strpos($ff, "_class");
            	if($pos){
            		$st = $dr.$ff; 
            		$dest=$dest.$ff;echo $st." => ".$dest."\n";
            		
            		//read 
            		$filename = $st;
            		$handle = fopen($filename, "r");
            		$contents = fread($handle, filesize($filename));
            		
            		fclose($handle);
            		
            		//copy($st, $dest);
            	}
            } 
            
            
            if(is_dir($dir.'/'.$ff)){
            	$str = $dir."".$ff."/";
            	$dest="/var/www/estate/modules/hrm/".$ff."/";
            	listFolderFiles($dir.'/'.$ff,$str,$dest);
             
            }
        } 
    } 
} 

listFolderFiles('/var/www/wisecoder/modules/hrm/');
*/


//tenants
/*$query="select l.id, l.tenant_code,l.reg_date,p.mid_name,p.first_name,p.last_name,p.national_id_no,p.pin,p.email,p.url,p.phone,p.fax,p.date_of_birth,p.marital_status,p.sex,p.description,p.mobile,p.passport_no,p.postal_address,p.physical_address,p.class_name,p.dl_no,p.dependants,p.nationality,p.occupation,p.hse_phone,p.postal_address2,p.postal_address3,p.postal_address4 from express_one_v1realmplaug09.em_tenants l left join express_one_v1realmplaug09.mc_person p on p.id=l.person_id";
$result=mysql_query($query);
while ($row=mysql_fetch_object($result)){
	
	$row->first_name=str_replace("'", "\'", $row->first_name);
	$row->mid_name=str_replace("'", "\'", $row->mid_name);
	$row->last_name=str_replace("'", "\'", $row->last_name);
	
	$name=$row->first_name." ".$row->mid_name." ".$row->last_name." A/C";
	
	echo "Tenants: ".$name;

//	$nat = mysql_fetch_object(mysql_query("select * from sys_nationalitys where name='$row->nationality'"));
			
	@$query="insert into em_tenants(code,firstname,middlename,lastname,postaladdress,address,registeredon,nationalityid,tel,mobile,fax,idno,passportno,dlno,occupation,email,dob)
			values('$row->tenant_code','$row->first_name','$row->mid_name','$row->last_name','$row->postal_address','$row->physical_address','$row->reg_date','93','$row->phone','$row->mobile','$row->fax','$row->national_id_no','$row->passport_no','$row->dl_no','$row->occupation','$row->email','$row->date_of_birth') ";
	
	if(mysql_query($query))
		echo "		Success\n";
	else
		echo "		Failure\n".mysql_error();
	$tenantid=mysql_insert_id();
	//add generaljournal account	
	
	//generaljournal accounts
	mysql_query("insert into fn_generaljournalaccounts(refid,code,name,acctypeid,categoryid) values('$tenantid','$row->tenant_code','$name','32','12')");
}*/

//landlords
/*$query="select l.id, l.ll_number,l.blocked,l.reg_date,p.mid_name,p.first_name,p.last_name,p.national_id_no,p.pin,p.email,p.url,p.phone,p.fax,p.date_of_birth,p.marital_status,p.sex,p.description,p.mobile,p.passport_no,p.postal_address,p.physical_address,p.class_name,p.dl_no,p.dependants,p.nationality,p.occupation,p.hse_phone,p.postal_address2,p.postal_address3,p.postal_address4 from express_one_v1realmplaug09.em_landlords l left join express_one_v1realmplaug09.mc_person p on p.id=l.person_id";
$result=mysql_query($query);
while ($row=mysql_fetch_object($result)){
	
	$row->first_name=str_replace("'", "\'", $row->first_name);
	$row->mid_name=str_replace("'", "\'", $row->mid_name);
	$row->last_name=str_replace("'", "\'", $row->last_name);
	
	$name=$row->first_name." ".$row->mid_name." ".$row->last_name." A/C";
	
	echo "Landlords: ".$name;
	
	$sql="insert into em_landlords(llcode,firstname,middlename,lastname,tel,email,registeredon,fax,mobile,idno,passportno,postaladdress,address,deductcommission,status)
		values('$row->ll_number','$row->first_name','$row->mid_name','$row->last_name','$row->phone','$row->email','$row->reg_date','$row->fax','$row->mobile','$row->national_id_no','$row->passport_no','$row->postal_address','$row->physical_address','Yes','$row->blocked')";
	
	if(mysql_query($sql))
		echo "		Success\n";
	else
		echo "		Failure\n".mysql_error();
	$landlordid=mysql_insert_id();	
	
	
	//generaljournal accounts
	mysql_query("insert into fn_generaljournalaccounts(refid,code,name,acctypeid,categoryid) values('$landlordid','$row->ll_number','$name','33','6')");
	
	$query1="select id,landlord,plot_number,plot_title,lr_number,zone,location,estate,road,blocked,plot_action,houses,notes,utility_type,mng_startdate,mng_months,c_commission,reviewfee_rate,arrearsfee_rate,letfee_rate,size,plot_type,field_officer,mng_indefinate,sep_commission,special_deposit,dep_months,elec_deposit,utils_exemptmgtfee,water_deposit,mgtfee_paid_personally,dep_manage,no_lease,plot_code,vatable,plot_description,targetrate,letablearea,unusedarea,bank,bankaccountno,paymentdate,paymentmode,taxagent,location2,owner,vatregno,pin,deliv_address1,deliv_address2,deliv_address3,pay_ref1,pay_ref2,pay_ref3,statement_type,chequesto,holdcheques,property_tax,property_taxutils,deposit_mgtfee_exmpt,prepayment_manage,plot_condition,r_ceiling,accomodate,fence,plot_floor,doors,windows,walls,plot_roof,tenure from express_one_v1realmplaug09.em_plots where landlord='$row->id'";
	$result1=mysql_query($query1);
	while($row1=mysql_fetch_object($result1)){
		
		if($row1->plot_type=="RESIDENTIAL")
			$typeid=1;
		if($row1->plot_type=="COMMERCIAL")
			$typeid=2;
		if($row1->plot_type=="MIXED")
			$typeid=3;
		
		if($row1->plot_action=="LET")
			$actionid=1;
		if($row1->plot_action=="MANAGE")
			$actionid=2;
		
		$regionid=1;
		
		$sql2="insert into em_plots(code,landlordid,actionid,noofhouses,regionid,managefrom,managefor,indefinite,typeid,commissiontype,commission,target,name,lrno,estate,road,location,paydate,status)
				values('$row1->plot_code','$landlordid','$actionid','$row1->houses','$regionid','$row1->mng_startdate','$row1->mng_months','$row1->mng_indefinate','$typeid','1','$row1->c_commission','$row1->targetrate','$row1->plot_title','$row1->lr_number','$row1->estate','$row1->road','$row1->location','$row1->paymentdate','$row1->blocked')";
		echo $row1->plot_title;
		if(mysql_query($sql2))
			echo "			Plots Success\n";
		else
			"		Plots Failure\n";
		
		$plotid=mysql_insert_id();
		$query2="select id,house_number,size,bedrms,plot,rent,owner_occupied,self_contained,bed_sitter,sitting_rm,kitchen,hse_type,reserved,reserved_by,reserve_hrentid,house_code,tentcode,notes,plot_floor,house_no2,charge_utilities,elec_acno,water_acno,dep_months,special_deposit from express_one_v1realmplaug09.em_houses where plot='$row1->id'";
		$result2=mysql_query($query2);
		while($row2=mysql_fetch_object($result2)){
			$descriptionid=1;
			$sql3="insert into em_houses(hseno,hsecode,plotid,amount,size,bedrms,floor,elecaccno,wateraccno,hsedescriptionid,housestatusid,rentalstatusid)
					values('$row2->house_number','$row2->house_code','$plotid','$row2->rent','$row2->size','$row2->bedrms','$row2->plot_floor','$row2->elec_acno','$row2->water_acno','$descriptionid','1','1')";
			
			echo $row2->house_number;
			if(mysql_query($sql3))
				echo "			Success\n";
			else
				echo "			Failure\n";
			$houseid=mysql_insert_id();
			
		}
	}
}*/

/*$query="select * from em_houses";
$result=mysql_query($query);
while($row=mysql_fetch_object($result)){
	
	$sql="select h.id,h.house,h.date_occupied,h.tenant,h.rental_status,h.rental_type,h.date_vacated,h.existing_tenant,h.diff_rent_dates,h.rent_due_date,h.track_lease,h.lease_date,h.lease_months,h.suppres_letter,h.lease_inc_type,h.lease_inc_amt,h.lease_incevery_months,h.suspend,h.rent_till,h.suppres_statement,h.reject_cheq,h.no_cheq,h.exempt_vat,h.lease_end,h.closed,h.no_receipt_msg,h.no_receipt,h.property_usage,h.suppres_letfees, hr.house_code, hr.tentcode,hr.owner_occupied from express_one_v1realmplaug09.em_houses_rent h left join express_one_v1realmplaug09.em_houses hr on h.house=hr.id where HOUSE_CODE='$row->hsecode' and h.rental_status='Renting'";
	$houses=mysql_fetch_object(mysql_query($sql));
	$sql2="select * from em_tenants where code='$houses->tentcode'";
	$tenant=mysql_fetch_object(mysql_query($sql2));
	
	
	echo "House: ".$houses->house_code;
	
	if($houses->lease_inc_type=="Percentage")
		$inctype="%";
	else
		$inctype=$houses->lease_inc_type;
	
	$payable=$houses->owner_occupied;
	
	$sql="insert into em_housetenants(houseid,tenantid,rentaltypeid,occupiedon,leasestarts,renewevery,leaseends,increasetype,increaseby,increaseevery,rentduedate,lastmonthinvoiced,lastyearinvoiced,payable)
			values('$row->id','$tenant->id','$houses->rental_type','$houses->date_occupied','$houses->lease_date','$houses->lease_months','$houses->lease_end','$inctype','$houses->lease_inc_amt','$houses->lease_incevery_months','$houses->rent_due_date','10','2013','$payable')";
	if(mysql_query($sql))
		echo "Success\n";
	else
		echo "Failure\n";
}*/

//setting jvno
$i=0;
$query=mysql_query("select distinct jvno from fn_generaljournals where jvno!='' and jvno is not null");
/*while($row=mysql_fetch_object($query)){
  $i++;
  echo "Updating Journals: ".$row->jvno."\n";
  mysql_query("update fn_generaljournals set jvno='$i' where jvno='$row->jvno'");
}*/
 mysql_query("alter table fn_generaljournals modify jvno int(11) comment 'JVNo' ");
 
 mysql_query("create table tmp_fn as select * from fn_generaljournals where jvno!=''");
 mysql_query("truncate fn_generaljournals");
 mysql_query("insert into fn_generaljournals select * from tmp_fn");
 mysql_query("drop table tmp_fn");
 
 //harvest em_payables
 $query="select * from em_payables";
 $res=mysql_query($query);
 /*while($obj=mysql_fetch_object($res)){
 echo "Payables: ".$obj->id."\n";
 $obj->id="";
    //retrieve account to debit to tenants A/C (subsidiary of Rent receivable A/C)
		$generaljournalaccounts = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='$obj->tenantid' and acctypeid='32'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$generaljournalaccounts=$generaljournalaccounts->fetchObject;
		
		//retrieve house landlord
		$houses = new Houses();
		$fields=" em_plots.landlordid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where em_houses.id='$obj->houseid'";
		$join=" left join em_plots on em_plots.id=em_houses.plotid ";
		$houses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$houses = $houses->fetchObject;
		
		if(empty($obj->bankid))
					$obj->bankid=1;
					
					if($obj->paymentmodeid==1){
						$acctype=24;
						$refid=1;
					}
					else{
						$acctype=8;
						$refid=$obj->bankid;
					}
		
			$generaljournalaccounts2 = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='1' and acctypeid='11'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$generaljournalaccounts2=$generaljournalaccounts3->fetchObject;
		
		

		$it=0;
		
		$ob->chequeno="";
		$ob->reconstatus="No";
		$ob->recondate=date("Y-m-d");
		
		$ob->createdby=$_SESSION['userid'];
		$ob->createdon=date("Y-m-d H:i:s");
		$ob->lasteditedby=$_SESSION['userid'];
		$ob->lasteditedon=date("Y-m-d H:i:s");
		
		
		$ob->jvno="";
		$ob->id="";
		$ob->did="";
		
		//make debit entry
		$generaljournal = new Generaljournals();
		$ob->tid=$payablesDBO->id;
		$ob->documentno="$obj->documentno";
		$ob->remarks="Invoice for ".$obj->month." ".$obj->year;
		$ob->memo=$obj->remarks;
		$ob->accountid=$generaljournalaccounts->id;
		$ob->daccountid=$generaljournalaccounts2->id;
		$ob->transactionid=$transaction->id;
		$ob->mode=4;
		$ob->class="B";
		$ob->debit=$obj->amount;
		$ob->credit=0;
		$generaljournal->setObject($ob);
		//$generaljournal->add($generaljournal);
		
		$shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'accountname'=>"$generaljournalaccounts->name", 'memo'=>"$generaljournal->memo", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total",'transactionid'=>"$ob->transactionid");
		
		$it++;
					
		//make credit entry
		
			$generaljournal2 = new Generaljournals();
			$ob->tid=$payablesDBO->id;
			$ob->documentno=$obj->documentno;
			$ob->remarks="Invoice for ".$obj->month." ".$obj->year;
			$ob->memo=$obj->remarks;
			$ob->daccountid=$generaljournalaccounts->id;
			$ob->accountid=$generaljournalaccounts2->id;
			$ob->transactionid=$transaction->id;
			$ob->mode=4;
			$ob->class="B";
			$ob->debit=0;
			$ob->credit=$obj->amount;
			$generaljournal2->setObject($ob);
			//$generaljournal2->add($generaljournal2);
		
			$shpgeneraljournals[$it]=array('accountid'=>"$generaljournal2->accountid", 'accountname'=>"$generaljournalaccounts2->name", 'memo'=>"$generaljournal2->memo", 'debit'=>"$generaljournal2->debit", 'credit'=>"$generaljournal2->credit", 'total'=>"$generaljournal2->total",'transactionid'=>"$ob->transactionid");
			
			$gn = new Generaljournals();
			$gn->add($obj, $shpgeneraljournals);
			
			//$generaljournal->did=$generaljournal2->id;
			//$generaljournal->edit($generaljournal);
		
 }*/
 
 //harvest landlordpayments
 $query="select em_landlordpayments.*,concat(em_landlords.firstname,' ',concat(em_landlords.middlename,' ',em_landlords.lastname)) landlordname from em_landlordpayments left join em_landlords on em_landlords.id=em_landlordpayments.landlordid";
  $res=mysql_query($query);
 while($obj=mysql_fetch_object($res)){
  
    echo "Landlord Payments: ".$row->id."\n";
    
    //Get transaction Identity
				$transaction = new Transactions();
				$fields="*";
				$where=" where lower(replace(name,' ',''))='LandlordPayments'";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				$transaction=$transaction->fetchObject;
				
				$ob->transactdate=$obj->paidon;
				
				//retrieve account to debit
				$generaljournalaccounts = new Generaljournalaccounts();
				$fields="*";
				$where=" where refid='$obj->landlordid' and acctypeid='33'";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				$generaljournalaccounts=$generaljournalaccounts->fetchObject;
				
				$paymentmodes = new Paymentmodes();
				$fields="*";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where id='$obj->paymentmodeid' ";
				$paymentmodes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				$paymentmodes=$paymentmodes->fetchObject;
				
				if(empty($obj->bankid))
					$obj->bankid=1;
					
					if($obj->paymentmodeid==1){
						$acctype=24;
						$refid=1;
					}
					else{
						$acctype=8;
						$refid=$obj->bankid;
					}
				
				$it=0;
				
				//retrieve account to credit
				$generaljournalaccounts2 = new Generaljournalaccounts();
				$fields="*";
				$where=" where refid='$refid' and acctypeid='$acctype'";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
				
				//make credit entry
				$generaljournal = new Generaljournals();
				$ob->tid=$tenantpayments->id;
				$ob->documentno=$obj->documentno;
				$ob->remarks="Payment for ".$obj->month." ".$obj->year;
				$ob->memo=$tenantpayments->remarks;
				$ob->accountid=$generaljournalaccounts->id;
				$ob->daccountid=$generaljournalaccounts2->id;
				$ob->transactionid=$transaction->id;
				$ob->mode=$obj->paymentmodeid;
				$ob->debit=$obj->amount;
				$ob->credit=0;
				$ob->class="B";
				$generaljournal->setObject($ob);
				//$generaljournal->add($generaljournal);
				
				$shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'accountname'=>"$generaljournalaccounts->name", 'documentno'=>"$generaljournal->documentno", 'remarks'=>"$generaljournal->remarks", 'memo'=>"$generaljournal->memo", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'class'=>"B", 'total'=>"$generaljournal->total",'transactdate'=>"$generaljournal->paidon");
				
				$it++;
				
				//make credit entry
				$generaljournal2 = new Generaljournals();
				$ob->tid=$tenantpayments->id;
				$ob->documentno=$obj->documentno;
				$ob->remarks="Payment to ".$obj->landlordname;
				$ob->memo=$tenantpayments->remarks;
				$ob->daccountid=$generaljournalaccounts->id;
				$ob->accountid=$generaljournalaccounts2->id;
				$ob->transactionid=$transaction->id;
				$ob->mode=$obj->paymentmodeid;
				$ob->debit=0;
				$ob->class="B";
				$ob->credit=$obj->amount;
				$ob->did=$generaljournal->id;
				$generaljournal2->setObject($ob);
				//$generaljournal2->add($generaljournal2);
				
				$shpgeneraljournals[$it]=array('accountid'=>"$generaljournal2->accountid", 'accountname'=>"$generaljournalaccounts2->name", 'documentno'=>"$generaljournal2->documentno", 'remarks'=>"$generaljournal2->remarks", 'memo'=>"$generaljournal2->memo", 'debit'=>"$generaljournal2->debit", 'credit'=>"$generaljournal2->credit", 'class'=>"B", 'total'=>"$generaljournal2->total",'transactdate'=>"$generaljournal->paidon");
					
				$gn = new Generaljournals();
				$gn->add($obj, $shpgeneraljournals);
    
 }
 
 //harvest tenantpayments
 $query="select em_tenantpayments.*,concat(em_tenants.firstname,' ',concat(em_tenants.middlename,' ',em_tenants.lastname)) tenantname from em_tenantpayments left join em_tenants on em_tenants.id=em_tenantpayments.tenantid";
  $res=mysql_query($query);
 while($obj=mysql_fetch_object($res)){
  echo "Tenant Payments: ".$row->id."\n";
  
  //retrieve account to credit
		$generaljournalaccounts = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='$obj->tenantid' and acctypeid='32'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$generaljournalaccounts=$generaljournalaccounts->fetchObject;

		if($obj->paymentmodeid==1){
			$acctype=24;
			$refid=1;
		}
		else{
			$acctype=8;
			$refid=$obj->bankid;
		}
		
		$it=0;
		
		//retrieve house landlord
		$houses = new Houses();
		$fields=" em_plots.landlordid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where em_houses.id='$obj->houseid'";
		$join=" left join em_plots on em_plots.id=em_houses.plotid ";
		$houses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$houses = $houses->fetchObject;
		
		$paymentmodes = new Paymentmodes();
		$fields=" * ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where id='$obj->paymentmodeid'";
		$join=" ";
		$paymentmodes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$paymentmodes = $paymentmodes->fetchObject;
		
				//retrieve account to debit
		$generaljournalaccounts2 = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='$obj->bankid' and acctypeid='$paymentmodes->acctypeid'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;

				//make credit entry
		$generaljournal = new Generaljournals();
		$ob->tid=$tenantpayments->id;
		$ob->documentno="$obj->documentno";
		$ob->remarks="Payment for the month ";
		$ob->memo=$tenantpayments->remarks;
		$ob->accountid=$generaljournalaccounts->id;
		$ob->daccountid=$generaljournalaccounts2->id;
		$ob->transactionid=$transaction->id;
		$ob->mode=$obj->paymentmodeid;
		$ob->class="B";
		$ob->debit=0;
		$ob->credit=$total;
		$generaljournal->setObject($ob);
		//$generaljournal->add($generaljournal);
		
		$shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'documentno'=>"$generaljournal->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts->name", 'memo'=>"$generaljournal->memo", 'remarks'=>"$generaljournal->remarks", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total",'transactdate'=>"$obj->paidon");
		
		$it++;
		
				//make credit entry
		$generaljournal2 = new Generaljournals();
		$ob->tid=$tenantpayments->id;
		$ob->documentno=$obj->documentno;
		$ob->remarks="Receipt from ".$obj->tenantname;
		$ob->memo=$tenantpayments->remarks;
		$ob->daccountid=$generaljournalaccounts->id;
		$ob->accountid=$generaljournalaccounts2->id;
		$ob->transactionid=$transaction->id;
		$ob->mode=$obj->paymentmodeid;
		$ob->debit=$total;
		$ob->credit=0;
		$ob->class="B";
		$ob->did=$generaljournal->id;
		$generaljournal2->setObject($ob);
		//$generaljournal2->add($generaljournal2);

		$shpgeneraljournals[$it]=array('accountid'=>"$generaljournal2->accountid", 'documentno'=>"$generaljournal->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts2->name", 'memo'=>"$generaljournal2->memo",'remarks'=>"$generaljournal2->remarks", 'debit'=>"$generaljournal2->debit", 'credit'=>"$generaljournal2->credit", 'total'=>"$generaljournal2->total",'transactdate'=>"$obj->paidon");
			
		$gn = new Generaljournals();
		$gn->add($obj, $shpgeneraljournals);
  
 }

?>