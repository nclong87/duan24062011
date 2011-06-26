<table width="802px" id="table_images">
	<thead id="thead_paging">
		<tr>
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
	</thead>
	<tfoot id="tfoot_paging">
		
	</tfoot>
	<tbody>
		<tr>
			<td >
				<div style="height:350px;overflow:auto;" id="div_imageshow">
				<?php
				foreach($lstImage as $image) {
					echo "<div class='image_box' >";
					echo "<img class='image' width=185px height=140px  src='".$image["image"]["fileurl"]."'/><br/>";
					echo "<div class='title_box'><input type=hidden name='filename' value='".$image["image"]["filename"]."'/><input type=hidden name='fileurl' value='".$image["image"]["fileurl"]."'/><input type=checkbox value='".$image["image"]["id"]."' onclick='imageselect(this);'/> ".$image["image"]["filename"]."</div>";
					echo "</div>";
				}
				?>
				</div>
			</td>
		</tr>
	</tbody>
</table>
<script>
	function imageselect(_this) {
		if(_this.checked == false) {
			i = inArray(img,_this.value,'id');
			imglen = img.length;
			if(i>-1) {
				img[i] = img[imglen - 1];
				img[imglen - 1] = {id:null,filename:'',fileurl:''};
			}
		} else {
			i = inArray(img,null,'id');
			imglen = img.length;
			if(i == -1) {
				alert('Bạn chỉ được chon tối đa '+imglen+' hình');
				_this.checked = false;
			} else {
				fileurl = _this.previousElementSibling.value;
				filename = _this.previousElementSibling.previousElementSibling.value;
				tmp = {id:_this.value,filename:filename,fileurl:fileurl};
				img[i] = tmp;
				//jsdebug(img);
			}
		}
	}
	$(document).ready(function() {
		$("#tfoot_paging").html($("#thead_paging").html());
		$("#div_imageshow input").each(function() {
			if(inArray(img,this.value,'id')!=-1)
				this.checked = true;
		});

	});
</script>