<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<table width="1440px" class="list">
  			<tr><td class='H' align="center" colspan="6"><h3>往來單位欠款表<h3></td></tr>
  			 
  		</table>
  		<table width="1000px" class="list" border="1">
		         
  				<tr>
	  				<th width="80">行號</th>
	  				<th width="120">往來單位編號</th>
	  				<th width="250">往來單位名稱</th>
	  				<th width="120">往來單位性質</th>
	  				<th width="100">應收款餘額</th>
	  				<th width="100">應付款餘額</th>
  				</tr>

  			    <?php 
				 $i = 1;
				 $sum1 = $sum2 = 0;
				 foreach($list as $arr=>$row){
				      $sum1  += $amount1 = $row['type']==-10 ? $row['amount'] : 0; 
					  $sum2  += $amount2 = $row['type']==10 ? $row['amount'] : 0; 
				 ?>
  				<tr>
  			       <td><?php echo $i?></td>
  			       <td><?php echo $row['number']?></td>
  			       <td><?php echo $row['name']?></td>
  			       <td><?php echo $row['type']==10 ? '供應商' : '客戶'?></td>
  			       <td class="R"><?php echo str_money($amount1,2)?></td>
  			       <td class="R"><?php echo str_money($amount2,2)?></td>
  				</tr>
  			    <?php 
				 $i++;
				 }
				 ?>
  				<tr>
  				<td colspan="4" class="R B">合計：</td>
  				<td class="R B"><?php echo str_money($sum1,2)?></td>
  				<td class="R B"><?php echo str_money($sum2,2)?></td>
  				</tr>
  		</table>	
