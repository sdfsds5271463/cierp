<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
  		<table width="1440px" class="list" border="1">
  			<tr><td class='H' align="center" colspan="14"><h3>商品銷售明細表<h3></td></tr>
  			<tr><td colspan="14">日期：<?php echo $beginDate?>至<?php echo $endDate?></td></tr>
  		</table>
  		<table width="1440px" class="list" border="1">
  			<thead>
  				<tr>
  				<th>銷售日期</th>
  				<th>銷售單據號</th>
  				<th>業務類別</th>
				<th>銷售人員</th>
  				<th>客戶</th>
  				<th>商品編號</th>
  				<th>商品名稱</th>
  				<th>規格型號</th>
  				<th>單位</th>
  				<th>倉庫</th>
  				<th>數量</th>
  				<th>單價</th>
  				<th>銷售收入</th>
				<th>備註</th>
  				</tr>
  			</thead>
  			<tbody>
				 <?php 
				 $sum1 = $sum2 = $sum3 = 0;
				 foreach($list as $arr=>$row){
				     $sum1 += $qty    = $row['qty']>0 ? -abs($row['qty']) : abs($row['qty']);   
					 $sum3 += $amount = $row['amount'];        
				 ?>
  			       <tr>
  			       <td><?php echo $row['billDate']?></td>
  			       <td><?php echo $row['billNo']?></td>
  			       <td><?php echo $row['transTypeName']?></td>
				   <td><?php echo $row['salesName']?></td>
  			       <td><?php echo $row['contactName']?></td>
  			       <td><?php echo $row['invNumber']?></td>
  			       <td><?php echo $row['invName']?></td>
  			       <td><?php echo $row['invSpec']?></td>
  			       <td><?php echo $row['mainUnit']?></td>
  			       <td><?php echo $row['locationName']?></td>
				   <td class="R"><?php echo str_money($qty,$this->systems['qtyPlaces'])?></td>
  			       <td class="R"><?php echo str_money($row['price'],$this->systems['qtyPlaces'])?></td>
  			       <td class="R"><?php echo str_money($amount,2)?></td>
				   <td class="R"><?php echo $row['description']?></td>
  			       </tr>
				 <?php 
				 }
				 ?>
  				<tr>
  				<td colspan="10" class="R B">合計：</td>
				<td class="R B"><?php echo str_money($sum1,$this->systems['qtyPlaces'])?></td>
  				<td class="R B"><?php echo $sum1>0 ? str_money($sum3/$sum1,$this->systems['qtyPlaces']) : 0?></td>
  				<td class="R B"><?php echo str_money($sum3,2)?></td>
				<td class="R B"></td>
  				</tr>
  			</tbody>
  		</table>
 