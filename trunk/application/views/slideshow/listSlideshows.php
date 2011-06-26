<div style="float:left">

</div>

<table width="100%">
	<thead>
		<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
			<td>Image</td>
			<td style="width:300px">Title</td>
			<td>URL</td>
			<td>Active</td>
			<td style="width:40px">Sửa</td>
		</tr>
	</thead>
	<tbody>
		<?php
		$i=0;
		foreach($lstslideshows as $slideshow) {
			$i++;
			if($i%2==0)
				echo "<tr class='alternateRow'>";
			else 
				echo "<tr class='normalRow'>";
			?>
				<td id="td_image_display" style="width:200px">
					<a target="_blank" href="<?php echo $slideshow["image"]["fileurl"]?>"><?php echo $slideshow["image"]["filename"]?></a>
				</td>
				<td id="td_id" style="display:none"><?php echo $slideshow["slideshow"]["id"]?></td>
				<td id="td_title" align="left"><?php echo $slideshow["slideshow"]["title"]?></td>
				<td id="td_url" align="left"><?php echo $slideshow["slideshow"]["url"]?></td>
				<td id="td_prior" style="display:none"><?php echo $slideshow["slideshow"]["prior"]?></td>
				<td id="td_image" style="display:none"><?php echo $slideshow["image"]["id"]?></td>
				<td id="td_filename" style="display:none"><?php echo $slideshow["image"]["filename"]?></td>
				<td id="td_fileurl" style="display:none"><?php echo $slideshow["image"]["fileurl"]?></td>
				<td id="td_backuped" align="center">
					<?php 
					if($slideshow["slideshow"]["backuped"]==1) {
						echo "<div class='inactive' onclick='doActive(this)' title='Active slideshow này'></div>";
					} else {
						echo "<div class='active' onclick='doUnActive(this)' title='Bỏ Active slideshow này'></div>";
					}
					?>
				</td>
				<td align="center">
					<input type="button" onclick="select_row(this)" value="Chọn" />
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>