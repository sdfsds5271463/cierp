<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<table width="1440px" class="list">
  			<tr><td class='H' align="center" colspan="7"><h3>應收賬款明細表<h3></td></tr>
  			<tr><td colspan="7">日期：<?php echo $beginDate;?>至<?php echo $endDate;?></td></tr>
  		</table>
  		<table width="1440px" class="list" border="1">
  			<thead>
  				<tr>
				<th>客戶</th>
  				<th>單據日期</th>
  				<th>單據編號</th>
  				<th>業務類別</th>
  				<th>增加應付款</th>
  				<th>增加預付款</th>
  				<th>應付款餘額</th>
  				</tr>
  			</thead>
  			<tbody>
			<?php 
				 $sum0 = $sum1 = $sum2 = $sum3 = $sum4 = 0;
				 foreach($list1 as $arr=>$row){
				 ?>
  				<tr class="link" data-id="0" data-type="BAL">
  				   <td><?php echo $row['name']?></td>
				   <td></td>
  				   <td>期初餘額</td>
  				   <td></td>
  				   
 
  			       <td class="R"></td>
  			       <td class="R"></td>
  			       <td class="R"><?php echo $row['amount']?></td>
  				</tr>
                <?php 
				 foreach($list2 as $arr1=>$row1){
				 if ($row['id']==$row1['buId']) {
				    $sum1 += $a1 = $row1['billType']=='SALE' ? $row1['arrears'] : 0; 
					$sum2 += $a2 = $row1['billType']=='RECEIPT' ? abs($row1['arrears']) : 0; 
					$a3 = $row['amount'] + $sum1 - $sum2;
				 ?>
  			    
  				<tr>
				   <td><?php echo $row1['contactName']?></td>
  				   <td><?php echo $row1['billDate']?></td>
  				   <td><?php echo $row1['billNo']?></td>
  				   <td><?php echo $row1['transTypeName']?></td>
  			       <td class="R"><?php echo str_money($a1,2)?></td>
  			       <td class="R"><?php echo str_money($a2,2)?></td>
  			       <td class="R"><?php echo str_money($a3,2)?></td>
  				</tr>
				
	            <?php  }}
				$sum = $row['amount'] + $sum1 - $sum2;
				?>
				<tr class="link" data-id="0" data-type="">
  			       <td> </td>
  			       <td></td>
  			       <td></td>
  			       <td>小計</td>
  			       <td class="R"><?php echo str_money($sum1,2)?></td>
  			       <td class="R"><?php echo str_money($sum2,2)?></td>
  			       <td class="R"><?php echo str_money($sum,2)?></td>
  				</tr>
				<?php 
				    $sum3 += $sum1;
					$sum4 += $sum2;
					$sum0 += $sum; 
				 }
				 ?>
  				<tr>
  				<td colspan="4" class="R B">合計：</td>
  				<td class="R B"><?php echo str_money($sum3,2)?></td>
  				<td class="R B"><?php echo str_money($sum4,2)?></td>
  				<td class="R B"><?php echo str_money($sum0,2)?></td>
  				</tr>
				
  				
  			</tbody>
  		</table>