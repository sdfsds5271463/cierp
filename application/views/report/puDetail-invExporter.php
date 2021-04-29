<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

  		<table width="1128px" class="list" >
  			<tr><td class='H' align="center" colspan="8"><h3>採購彙總表（按商品）<h3></td></tr>
  			<tr><td colspan="8">日期：<?php echo $beginDate?>至<?php echo $endDate?></td></tr>
  		</table>
  		<table width="1128px" class="list" border="1">
  			<thead>
  				<tr>
	  				<th>商品編號</th>
	  				<th width="150px">商品名稱</th>
	  				<th>規格型號</th>
	  				<th>單位</th>
	  				<th>倉庫</th>
	  				<th>數量</th>
	  				<th>單價</th>
	  				<th>採購金額</th>
	  				
  				</tr>
  			</thead>
  			<tbody>
 
				<?php 
				 $sum1 = $sum2 = $sum3 = 0;
				 foreach($list as $arr=>$row){
				?>
  				<tr>
  			       <td><?php echo $row['invNumber']?></td>
  			       <td><?php echo $row['invName']?></td>
  			       <td><?php echo $row['invSpec']?></td>
  			       <td><?php echo $row['mainUnit']?></td>
  			       <td><?php echo $row['locationName']?></td>
  			       <td class="R"><?php echo str_money($row['sumqty'],$this->systems['qtyPlaces'])?></td>
  			       <td class="R"><?php echo str_money($row['price'],$this->systems['qtyPlaces'])?></td>
  			       <td class="R"><?php echo str_money($row['sumamount'],2)?></td>
  				</tr>
  			    <?php 
				 $sum1 += $row['sumqty'];  
				 $sum2 += $row['price'];
				 $sum3 += $row['sumamount']; 
				 }
				?>
  				 
  			    <tr>
  				<td colspan="5" class="R B">合計：</td>
  				<td class="R B"><?php echo str_money($sum1,$this->systems['qtyPlaces'])?></td>
  				<td class="R B"><?php echo $sum1>0 ? str_money($sum3/$sum1,$this->systems['qtyPlaces']) : 0?></td>
  				<td class="R B"><?php echo str_money($sum3,2)?></td>
  				</tr>
				
  				 
  			</tbody>
  		</table>





