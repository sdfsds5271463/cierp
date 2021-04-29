<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<table width="1500px" class="list">
  			<tr><td class='H' align="center" colspan="10"><h3>付款單記錄</h3></td></tr>
  		</table>
		<table class="table" width="1500"  border="1">
			<thead>
				<tr>
				    <th width="100" align="center">單據日期</th>
				    <th width="150" align="center">單據編號</th>
				    <th width="120" align="center">購貨單位</th>
					<th width="60" align="center">付款金額</th>
					<th width="100" align="center">備註</th>
					<th width="200" align="center">結算賬戶</th>
					<th width="60" align="center">付款金額</th>
					<th width="80" align="center">結算方式</th>	
					<th width="60" align="center">結算號</th>	
					<th width="100" align="center">備註</th>	
				</tr>
			</thead>
			<tbody>
			   <?php 
				  $i = 1;
				  $n = 1;
				  $payment = 0;
				  foreach($list as $arr=>$row) {
				      $postData = unserialize($row['postData']);
				      $n = isset($postData['accounts']) ? count($postData['accounts'])+1 : 1;
				?>
				<tr target="id">
				    <td rowspan="<?php echo $n?>" ><?php echo $row['billDate']?></td>
					<td rowspan="<?php echo $n?>" ><?php echo $row['billNo']?></td>
					<td rowspan="<?php echo $n?>" ><?php echo $row['contactNo'].' '.$row['contactName'];?></td>
					<td rowspan="<?php echo $n?>" ><?php echo $row['amount']?></td>
					<td rowspan="<?php echo $n?>" ><?php echo $row['description']?></td>
				<?php 
				$i = 1;
				foreach($postData['accounts'] as $arr1=>$row1) {
					$payment += abs($row1['payment']);
					if ($i==1) {
				?> 
				    
					<td ><?php echo $account[$row1['accId']]?></td>
					<td ><?php echo $row1['payment']?></td>
					<td ><?php echo $category[$row1['wayId']]?></td>
					<td ><?php echo $row1['settlement']?></td>
					<td ><?php echo $row1['remark']?></td>
				</tr>
				<?php } else {?>
				<tr target="id">
					<td ><?php echo $account[$row1['accId']]?></td>
					<td ><?php echo $row1['payment']?></td>
					<td ><?php echo $category[$row1['wayId']]?></td>
					<td ><?php echo $row1['settlement']?></td>
					<td ><?php echo $row1['remark']?></td>
				</tr>
				<?php }$i++;}?>
				<tr target="id">
					<td >合計</td>
					<td ><?php echo $payment?></td>
					<td ></td>
					
					<td ></td>
					<td ></td>
	
				</tr>
				 
				<?php $payment = 0;$n = 1;}?>
				

				
				 
				
 </tbody>
</table>	


 