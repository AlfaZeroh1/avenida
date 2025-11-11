<thead>
			     <th width="100" align="left"><span style="text-decoration:underline;font-size:14px !important;">VARIETY</span></th>
			      <th width="100" align="left"><span style="text-decoration:underline;font-size:14px !important;">SIZE</span></th>
			      <th width="100" align="left"><span style="text-decoration:underline;font-size:14px !important;">HEAD TYPE</span></th>
			      <th width="100" align="left"><span style="text-decoration:underline;font-size:14px !important;">NO OF BOXES</span></th>
			      
			      <th width="100" align="left"><span style="text-decoration:underline;font-size:14px !important;">TOTAL STEMS/QUANTIY</span></th>
			      <th width="100" align="left"><span style="text-decoration:underline;font-size:14px !important;">PRICE</span></th>
			      <th width="100" align="left"><span style="text-decoration:underline;font-size:14px !important;">FOB VALUE</span></th>
</thead>
          <tbody>   
            
    <?
    $payables = new Invoices();
    $fields="pos_invoices.id, pos_invoices.documentno, inv_items.name as itemid, pos_invoicedetails.tax, pos_invoices.soldon, pos_invoicedetails.quantity, pos_invoicedetails.total ";
    
	$join=" left join pos_invoicedetails on pos_invoices.id=pos_invoicedetails.invoiceid left join inv_items on pos_invoicedetails.itemid=inv_items.id ";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where pos_invoices.documentno='3' ";
	$payables->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
	$res=$payables->result;
	$total=0;
	while($row=mysql_fetch_object($res)){
			$total+=$row->total;
     ?>
    <tr class="<?php echo $some_class; ?>">
      <td id="tddes" height="24" align="left" class="lines"><strong><?php echo initialCap($row->plotid); ?></strong></td>
      <td id="tddes" height="24" align="left" class="lines"><strong><?php echo initialCap($row->houseid); ?></strong></td>
      <td class="lines" align="left"><?php echo $row->paymenttermid; ?></td>
      <td class="lines" align="left"><strong><?php echo $row->month; ?>&nbsp;<?php echo $row->year; ?></strong></td>
      <td class="noprint lines" align="right"><strong><?php echo formatNumber($row->amount); ?></strong></td>
      <td align="right" id="tdquantity" class="lines"><strong><?php echo formatNumber($row->vatamount); ?></strong></td>
      <td align="right" id="tddisc" class="lines"><?php echo formatNumber($row->total); ?></td>
      </tr>
      <?
           $i++;
	  $j--;       
	  
	  }
      
	  ?>
</tbody>
  </table>