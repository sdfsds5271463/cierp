<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<table width="1440px" class="list">
  			<tr><td class='H' colspan="20" align="center"><h3>商品收發彙總表<h3></td></tr>
  			<tr><td colspan="20">日期：<?php echo $beginDate;?>至<?php echo $endDate;?></td></tr>
</table>
  		<table width="1440px" class="list" border="1">

  				<tr>
  				<th width="216" rowspan="2">商品編號</th>
  				<th width="216" rowspan="2">商品名稱</th>
  				<th width="216" rowspan="2">規格型號</th>
  				<th width="114" rowspan="2">單位</th>
  				<th width="24" rowspan="2">倉庫</th>
				<th>期初</th>
				<th>調撥入庫</th>
				<th>普通採購</th>
				<th>銷售退回</th>
				<th>盤盈</th>
				<th>其他入庫</th>
				<th>成本調整</th>
				<th>入庫合計</th>
				<th>調撥出庫</th>
				<th>採購退回</th>
				<th>普通銷售</th>
				<th>盤虧</th>
				<th>其他出庫</th>
				<th>出庫合計</th>
				<th>結存</th> 
  				</tr>
				
				<tr>
				<?php for ($i=0;$i<15;$i++) {?>
  				<td align="center">數量</td>
				<?php }?>
  				</tr>
				
				<?php 
				for ($i=0;$i<15;$i++) {
				    $sum['qty_'.$i]  = 0;  
 
					$sum['qty'.$i]   = 0;  
  
				}
				$qty7   = $qty_7   = $qty13  = $qty_13 = 0; 
		       
				foreach($list as $arr=>$row){
				    //期初數量
					$qty_0      = $row['qty0']; 
				 
					
					//結存數量
					$qty_14    = $row['qty14'];             //結存數量
					 
		      
					
					$sum['qty14']   +=  str_money($qty_14,$this->systems['qtyPlaces']); 
				 
					
					for ($i=1;$i<7;$i++) {
						if ($i==1) {                          //調撥  成本另計算
							$qty_7  += abs($row['qty1']);   
						 
						} else {
							$qty_7  += abs($row['qty'.$i]);   
							 
						}
					}
					for ($i=8;$i<13;$i++) {
						if ($i==10 || $i==11 || $i==12 || $i==8) {       //銷售、盤虧、其他出庫  成本另計算
							$qty_13  += abs($row['qty'.$i]);   
							 
						} else {
							$qty_13  += abs($row['qty'.$i]);   
							 
						}
					}
					
                    for ($i=0; $i<15; $i++) {
						if ($i==0) {
							$sum['qty0']   += $sum['qty_'.$i]   = $qty_0;    //期初數量
							  
						} elseif($i==7) {
							$sum['qty7']   += $sum['qty_'.$i]   = $qty_7;    //入庫合計 
							 
						} elseif($i==13) {
							$sum['qty13']  += $sum['qty_'.$i]   = $qty_13;   //出庫合計 
							 
						} elseif($i==14) {                                   
							$sum['qty_'.$i]    = $qty_14;                    //結存合計 
							 
						} else {
							if ($i==10 || $i==11 || $i==12 || $i==1 || $i==8) {  //銷售、盤虧、其他出庫、入庫調撥、出庫調撥  成本另計算
								$sum['qty'.$i]  += $sum['qty_'.$i]   = abs($row['qty'.$i]);  
								 
							} else { 
								$sum['qty'.$i]  += $sum['qty_'.$i]   = abs($row['qty'.$i]);   
								 
							}
						}
					}
					$qty_7 = $qty_13 = 0;         //停止累加 初始化值
				?>
				<tr>
  				   <td><?php echo $row['invNumber']?></td>
  				   <td><?php echo $row['invName']?></td>
  				   <td><?php echo $row['invSpec']?></td>
  				   <td><?php echo $row['mainUnit']?></td>
				   <td><?php echo $row['locationName']?></td>
				   <?php for ($i=0;$i<15;$i++) {?>
				   <td><?php echo str_money($sum['qty_'.$i],$this->systems['qtyPlaces'])?> </td>
				   <?php }?>
  				</tr>
  			   <?php }?>
				<tr>
  				   <td colspan="5">合計:</td>
				   <?php for ($i=0;$i<15;$i++) {?>
				   <td><?php echo str_money($sum['qty'.$i],$this->systems['qtyPlaces'])?></td>
				   <?php }?>
  				</tr>
  		</table>
