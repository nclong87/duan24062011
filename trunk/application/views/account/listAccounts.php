<table width="100%">
	<thead>
		<tr id="thead_paging">
			<td colspan="11" align="center" bgcolor="white" style="color:black">
				<a class="link" style="padding-right:5px" href='#' onclick="selectpage(1)">Begin</a>
				<?php 
				while($pagesbefore<$pagesindex) {
					echo "<a class='link' href='#' onclick='selectpage($pagesbefore)'>$pagesbefore</a>";
					$pagesbefore++;
				}
				?>
				<span style="font-weight:bold;color:red"><?php echo $pagesindex ?></span>
				<?php 
				while($pagesnext>$pagesindex) {
					$pagesindex++;
					echo "<a class='link' href='#' onclick='selectpage($pagesindex)'>$pagesindex</a>";
				}
				?>
				<a class="link" style="padding-left:5px" href='#' onclick="selectpage(<?php echo $pageend ?>)">...<?php echo $pageend ?></a>			
			</td>
		</tr>
		<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
			<td width="20px">#</td>
			<td style="border-left: 1px solid white">Username</td>
			<td style="border-left: 1px solid white">Email</td>
			<td style="border-left: 1px solid white">Last Login</td>
			<td style="border-left: 1px solid white">Quyền</td>
			<td style="border-left: 1px solid white">Active</td>
			<td style="border-left: 1px solid white" width="20px">Chọn</td>
		</tr>
	</thead>
	<tfoot>
		<tr id="tfoot_paging"></tr>
	</tfoot>
	<tbody>
		<?php
		$i=0;
		foreach($lstAccounts as $account) {
			$i++;
			if($i%2==0)
				echo "<tr class='alternateRow'>";
			else 
				echo "<tr class='normalRow'>";
			?>
				<td align="center"><?php echo $i?></td>
				<td style="border-left: 1px solid white" id="td_username" align="center"><?php echo $account["account"]["username"]?></td>
				<td id="td_email" align="center" style="border-left: 1px solid white"><?php echo $account["account"]["email"]?></td>
				<td id="td_sodienthoai" style="display:none"><?php echo $account["account"]["sodienthoai"]?></td>
				<td id="td_lastlogin" align="center" style="border-left: 1px solid white"><?php  echo $html->format_date($account["account"]["lastlogin"],'d/m/Y H:i:s')?></td>
				<td id="td_role" align="center" style="border-left: 1px solid white">
				<?php 
					switch($account["account"]["role"]) {
						case 1:
							echo "Admin";
							break;
						case 2:
							echo "Nhân viên";
							break;
						default:
							echo "Người dùng";
							break;
					}
				?>
				</td>
				<td id="td_active" style="display:none;"><?php echo $account["account"]["active"]?></td>
				<td id="td_active_display" align="center" style="border-left: 1px solid white">
					<?php 
					if($account["account"]["active"]==0) {
						echo "<div class='inactive' title='Chưa active'></div>";
					} else if($account["account"]["active"]==-1) {
						echo "<div class='locked' title='Đã khóa'></div>";
					} else {
						echo "<div class='active' title='Đã active'></div>";
					}
					?>
				</td>
				<td id="td_id" style="display:none;"><?php echo $account["account"]["id"]?></td>
				<td align="center" style="border-left: 1px solid white">
					<input type="checkbox" onclick="doCheck(this)" value="<?php echo $account["account"]["id"]?>" />
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
<script>
	$(document).ready(function() {
		$("#tfoot_paging").html($("#thead_paging").html());
	});
</script>