<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<table width="1500px" class="list">
  			<tr><td class='H' align="center" colspan="11"><h3>成本調整單記錄</h3></td></tr>
  		</table>
		<table class="table" width="1500"  border="1">
			<thead>
				<tr>
				    <th width="100" align="center">單據日期</th>
				    <th width="150" align="center">單據編號</th>
				    <th width="120" align="center">業務類別</th>
					<th width="60" align="center">金額</th>
				    <th width="60" align="center">制單人</th>
					<th width="100" align="center">單據備註</th>
					<th width="200" align="center">商品</th>
					<th width="60" align="center">單位</th>
					<th width="80" align="center">調整金額</th>	
					<th width="60" align="center">倉庫</th>	
					<th width="100" align="center">備註</th>	
				</tr>
			</thead>
			<tbody>
			    <?php 
				  $i = 1;
				  $n = 1;
				  $amount = 0;
				  foreach($list as $arr=>$row) {
				      $postData = unserialize($row['postData']);
				      $n = isset($postData['entries']) ? count($postData['entries'])+1 : 1;
				?>
				<tr target="id">
				    <td rowspan="<?php echo $n?>" ><?php echo $row['billDate']?></td>
					<td rowspan="<?php echo $n?>" ><?php echo $row['billNo']?></td>
					<td rowspan="<?php echo $n?>" ><?php echo $row['transTypeName']?></td>
					<td rowspan="<?php echo $n?>" ><?php echo $row['amount']?></td>
					<td rowspan="<?php echo $n?>" ><?php echo $row['userName']?></td>
					<td rowspan="<?php echo $n?>" ><?php echo $row['description']?></td>
				<?php 
				$i = 1;
				foreach($postData['entries'] as $arr1=>$row1) {
					$amount += abs($row1['amount']);
					if ($i==1) {
				?>
				    
					<td ><?php echo $row1['invNumber'].' '.$row1['invName'].' '.$row1['invSpec']?></td>
					<td ><?php echo $row1['mainUnit']?></td>
					<td ><?php echo abs($row1['amount'])?></td>
					<td ><?php echo $row1['locationName']?></td>
					<td ><?php echo $row1['description']?></td>
				</tr>
				<?php } else {?>
				<tr target="id">
					<td ><?php echo $row1['invNumber'].' '.$row1['invName'].' '.$row1['invSpec']?></td>
					<td ><?php echo $row1['mainUnit']?></td>
					<td ><?php echo abs($row1['amount'])?></td>
					<td ><?php echo $row1['locationName']?></td>
					<td ><?php echo $row1['description']?></td>
				</tr>
				<?php }$i++;}?>
				<tr target="id">
					<td >合計</td>
					<td ></td>
					<td ><?php echo $amount?></td>
					<td ></td>
					<td ></td>
	
				</tr>
				 
				<?php $amount = 0;$n = 1;}?>
				

				
				 
				
 </tbody>
</table>	


 