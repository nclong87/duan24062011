<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery.form.js"></script>
<div style="height: 115px; width: 802px; position: relative;">
	<fieldset>
	<table width="100%">
		<tbody>
			<tr>
				<td colspan="2" id="image_msg">
				</td>
			</tr>
			<tr>
				<td width="500px">
				<form id="formUploadImage" ENCTYPE="multipart/form-data" method="POST" >
				Chọn File <span class="tipMsg" title="Chỉ cho phép các định dạng ảnh sau : jpg,png,bmp,jpeg,gif">*</span> : <input type="file" name="image" /> <input type="submit" value="Upload" class="button"> 
				</form>
				</td>
				<td  width="300px">
					Lọc theo tên : <input type="text" width="80px" name="image_keyword" id="image_keyword" value=""/>
				</td>
			</tr>
		</tbody>
	</table>
	</fieldset>
</div>
<div style="float: left;" id="lstImage">
</div>
<script>
function image_msg(msg,type) {
	if(type==1) { //Thong diep thong bao
		str = '<div id="success" class="info_div"><span class="ico_success">'+msg+'</span></div>';
		byId("image_msg").innerHTML = str;
	} else if(type == 0) { //Thong diep bao loi
		str = '<div id="fail" class="info_div"><span class="ico_cancel">'+msg+'</span></div>';
		byId("image_msg").innerHTML = str;
	}
}
function selectpage(page) {
	loadimages(page);
}
function loadimages(page){
	byId("image_msg").innerHTML = "";
	block("#lstImage");
	if(page == null)
		page = 1;
	$.ajax({
		type: "GET",
		url : url("/image/showimage/"+page+"/"+byId("image_keyword").value),
		success: function(data){
			unblock("#lstImage");
			$("#lstImage").html(data);
			$(".image").each(function(){
				if($(this).width()>190)
					$(this).width(190);
				if($(this).height()>140)
					$(this).height(140);
			});
		},
		error: function(data){ alert (data);unblock("#lstImage");}	
	});
}
$(document).ready(function() {
	var options = { 
		url:        url("/admin/uploadImage"), 
		type:      "post",
		dataType: "xml",
		success:    function(data) { 
			data = data.body.childNodes[0].innerHTML;		
			if(data == AJAX_DONE) {
				loadimages(1);
				image_msg("Upload file thành công!",1);
			} else if(data == AJAX_ERROR_WRONGFORMAT) {
				image_msg("Upload file sai định dạng!",0);
			} else {
				image_msg("Upload file không thành công!",0);
			}
		} 
	}; 
	// pass options to ajaxForm 
	$('#formUploadImage').ajaxForm(options); 
	$("#image_keyword").keyup(function(event){
		if(event.keyCode == 13) {
			loadimages(1);
		}
		//jsdebug(event);
	});
	loadimages(1);
});
</script>