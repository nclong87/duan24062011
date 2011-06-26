<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery.form.js"></script>
<link rel="Stylesheet" type="text/css" href="<?php echo BASE_PATH ?>/public/css/descimage.css"  />	
<style type="text/css"> 	
	.input {
		width:86%;
	}
	select {
		margin-right:-5px;
	}
	.select {
		width:86%;
	}
	
</style>
<div class="boxes" id="dialogSlideshow" >
	<fieldset id="dialog" class="window">
		<div class="ui-dialog-titlebar ui-widget-header ui-corner-top ui-helper-clearfix" style="text-align: center; font-size: 13pt; padding: 2px;margin-bottom:3px;" ><span id="title_dialog">Thông Tin Slideshow</span>
		<a href="#" onclick="closeDialog('#dialogSlideshow')" class="ui-dialog-titlebar-close ui-corner-all" role="button" unselectable="on" style="-moz-user-select: none; float: right;"><span class="ui-icon ui-icon-closethick" unselectable="on" style="-moz-user-select: none;">close</span></a>
		</div>
		<fieldset>
			<form id="formUpload">
			<table class="center" width="100%">
			<thead>
				<tr>
					<td colspan="4" id="msg">
					</td>
				</tr>
			</thead>
			<tr>
				<td style="width:100px" align="left" valign="center">Chọn Ảnh :</td>
				<td align="left">
				<span id="div_filedinhkem"><input type="file" name="fileupload" id="fileupload" onchange="doUploadFile()" tabindex=5/> (hoặc) <input type="button" class="button" value="Chọn Từ Thư Viện Ảnh" onclick="showImagesPanel()"/></span>
				<span id="fileuploaded"></span>
				</td>
			</tr>
			</table>
			</form>
			<table class="center" width="100%" style="display:none" id="tbl_Slideshow">
				<tbody>
					<form id="formSlideshow" >
					<input type="hidden" name="slideshow_id" id="slideshow_id"/>
					<input type="hidden" name="slideshow_image" id="slideshow_image"/>
					<tr>
						<td style="width:100px" align="left">Tiêu đề ảnh :</td>
						<td align="left">
							<input type="text" name="slideshow_title" id="slideshow_title"/>
						</td>										
					</tr>
					<tr>
						<td align="left">URL :</td>
						<td align="left">
							<input type="text" name="slideshow_url" id="slideshow_url" style="width:90%;"/>
						</td>										
					</tr>
					<tr>
						<td align="left">Thứ Tự :</td>
						<td align="left">
							<select name="slideshow_prior" id="slideshow_prior">
								<option value="1" selected>1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						</td>										
					</tr>
					<tr>
						<td colspan="6" align="center" height="50px">
							<input onclick="saveSlideshow()" value="Lưu" type="button" class="button">
							<input onclick="deleteSlideshow()" value="Xóa" type="button" class="button">
							<input onclick="doReset()" value="Reset" type="button"  class="button">
						</td>
					</tr>
					</form>
				</tbody>
			</table>
		</fieldset>
	</fieldset>
	<div id="mask"></div>
</div>
<div style="padding-top:10px;font-size:14px" >
	<div style="color: blue; font-size: 20px; text-align: center; font-weight: bold;">Quản Trị Ảnh Slideshow</div>
	<div class="clearfix" id="shortcuts">
		<ul>
			<li class="first_li" onclick="showDialogSlideshow()"><a href="#"><img alt="Thêm" src="<?php echo BASE_PATH ?>/public/img/icons/add-icon.png"><span>Thêm</span></a></li>
		</ul>
	</div>
	<fieldset>
		<div id="datagrid">
			<table width="99%">
				<thead>
					<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
						<td>Image</td>
						<td>Thông tin</td>
						<td style="width:40px">Sửa</td>
					</tr>
				</thead>
			</table>
		</div>
	</fieldset>
</div>
<script type="text/javascript">
	var objediting; //Object luu lai row dang chinh sua
	var img = new Array({id:null,filename:'',fileurl:''});
	function message(msg,type) {
		if(type==1) { //Thong diep thong bao
			str = '<div id="success" class="info_div"><span class="ico_success">'+msg+'</span></div>';
			byId("msg").innerHTML = str;
		} else if(type == 0) { //Thong diep bao loi
			str = '<div id="fail" class="info_div"><span class="ico_cancel">'+msg+'</span></div>';
			byId("msg").innerHTML = str;
		}
	}
	function showDialogSlideshow() {
		doReset();
		isUpdate = false;
		showDialog('#dialogSlideshow',800);
	}
	function fillFormValues(cells) { //Lấy giá trị từ row được chọn đưa lên form (click vào nút "Chọn")	
		$("#div_filedinhkem").hide();
		byId("slideshow_id").value = $.trim($(cells.td_id).text());
		byId("slideshow_title").value = $.trim($(cells.td_title).text());
		byId("slideshow_prior").value = $.trim($(cells.td_prior).text());
		byId("slideshow_url").value = $.trim($(cells.td_url).text());	
		byId("slideshow_image").value = $.trim($(cells.td_image).text());	
		idchosen = "chosen_"+$.trim($(cells.td_image).text());
		$("#fileuploaded").html('<div style="display: block;" id="'+idchosen+'" ") class="chosen-container"><span class="chosen"><a href="'+$.trim($(cells.td_fileurl).text())+'" target="_blank">'+$.trim($(cells.td_filename).text())+'</a><img onclick="removechosen('+$.trim($(cells.td_image).text())+')" class="btn-remove-chosen" src="<?php echo BASE_PATH?>/public/img/icons/close_8x8.gif"/></span></div>');
		$("#tbl_Slideshow").show();
		//$("#slideshow_id").attr("readonly", true); 
	}
	function setRowValues(cells) { //Set giá trị từ form xuống row edit	
		$(cells.td_id).text(byId("slideshow_id").value);
		$(cells.td_title).text(byId("slideshow_title").value);
		$(cells.td_prior).text(byId("slideshow_prior").value);
		$(cells.td_url).text(byId("slideshow_url").value);			
		$(cells.td_image).text(byId("slideshow_image").value);			
	}
	function select_row(_this) {
		//jsdebug(_this);
		doReset();	
		showDialog("#dialogSlideshow",800);
		var tr = _this.parentNode.parentNode;
		var cells = tr.cells;
		tr.style.backgroundColor = CONST_ROWSELECTED_COLOR;	
		objediting = tr;			
		fillFormValues(cells);
		return false;
	}
	function doReset() {
		$("#formSlideshow")[0].reset(); //Reset form cua jquery, giu lai gia tri mac dinh cua cac field	
		if(objediting)
			objediting.style.backgroundColor = '';
		byId("slideshow_id").value="";
		if(img[0]['id']!=null)
			removechosen(img[0]['id']);
		img = new Array({id:null,filename:'',fileurl:''});
		$("#formSlideshow :input").css('border-color','');
		byId("msg").innerHTML="";
	}
	function loadListSlideshows() {
		block("#datagrid");
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/slideshow/listSlideshows/true"),
			success : function(data){	
				//alert(data);
				unblock("#datagrid");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
				} else {
					$("#datagrid").html(data);
					//$("input:submit, input:button", "#datagrid").button();	
				}
				
			},
			error: function(data){ 
				unblock("#datagrid");
				alert (data);
			}			
		});
	}
	var isUpdate = false;
	function saveSlideshow() {
		checkValidate=true;
		validate(['require'],'slideshow_image',["Bạn chưa chọn ảnh!"]);
		if(checkValidate == false)
			return;
		if(byId("slideshow_id").value != '') 
			if(!confirm("Bạn muốn cập nhật Slideshow này?"))
				return;
		dataString = $("#formSlideshow").serialize();
		byId("msg").innerHTML="";
		block("#dialogSlideshow #dialog");
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/slideshow/saveSlideshow&"),
			data: dataString,
			success: function(data){
				unblock("#dialogSlideshow #dialog");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_DONE) {
					//Load luoi du lieu	
					message("Lưu Slideshow thành công!",1);
					loadListSlideshows();													
				} else {
					message('Lưu Slideshow không thành công!',0);										
				}
			},
			error: function(data){ unblock("#dialogSlideshow #dialog");alert (data);}	
		});	
	}
	function deleteSlideshow() {
		if(byId("slideshow_id").value=="") {
			alert("Vui lòng chọn slideshow cần xóa!");
			return;
		}
		if(!confirm("Bạn muốn xóa slideshow này?"))
			return;
		byId("msg").innerHTML="";
		block("#dialogSlideshow #dialog");
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/slideshow/deleteSlideshow&id="+byId("slideshow_id").value),
			success: function(data){
				unblock("#dialogSlideshow #dialog");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_ERROR_SYSTEM) {
					//Load luoi du lieu		
					message('Thao tác bị lỗi!',0);	
				} else {
					closeDialog('#dialogSlideshow');
					loadListSlideshows(1);
					message("Xóa slideshow thành công!",1);					
				}
			},
			error: function(data){ unblock("#dialogSlideshow #dialog");alert (data);}	
		});
	}
	function doActive(_this) {
		var cells = _this.parentNode.parentNode.cells;
		//alert($(cells.td_id).text());return;
		block("#content_main");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/slideshow/activeSlideshow/"+$(cells.td_id).text()),
			success: function(data){
				unblock("#content_main");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if (data == AJAX_DONE) {					
					message("Active Slideshow thành công!",1);
					$(cells.td_backuped).html("<div class='active' onclick='doUnActive(this)' title='Bỏ Active Slideshow này'></div>");
				} else {
					message("Active Slideshow không thành công!",0);
				}															
			},
			error: function(data){ alert (data);unblock("#content_main");}	
		});
	}
	function doUnActive(_this) {
		var cells = _this.parentNode.parentNode.cells;
		block("#content_main");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/slideshow/unActiveSlideshow/"+$(cells.td_id).text()),
			success: function(data){
				unblock("#content_main");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if (data == AJAX_DONE) {					
					message("Bỏ Active Slideshow thành công!",1);
					$(cells.td_backuped).html("<div class='inactive' onclick='doActive(this)' title='Active Slideshow này'></div>");
				} else {
					message("Bỏ Active Slideshow không thành công!",0);
				}															
			},
			error: function(data){ alert (data);unblock("#content_main");}	
		});
	}
	function doUploadFile() {
		$("#div_filedinhkem").hide();
		$("#fileuploaded").html("Uploading...");
		$('#formUpload').submit();
	}
	function removechosen(idchosen) {
		img = new Array({id:null,filename:'',fileurl:''});
		$("#chosen_"+idchosen).remove();
		$("#div_filedinhkem").show();
	}
	function onCloseImageGallery() {
		if(img[0]['id']!=null) {
			$("#div_filedinhkem").hide();
			idchosen = "chosen_"+img[0]['id'];
			$("#fileuploaded").html('<div style="display: block;" id="'+idchosen+'" ") class="chosen-container"><span class="chosen"><a href="'+img[0]['fileurl']+'" target="_blank">'+img[0]['filename']+'</a><img onclick="removechosen('+img[0]['id']+')" class="btn-remove-chosen" src="<?php echo BASE_PATH?>/public/img/icons/close_8x8.gif"/></span></div>');
			$("#tbl_Slideshow").show();
		}
	}
	$(document).ready(function(){				
		//$("#widget_content").css("width","300px");
		document.title = "Quản Trị Slideshow";
		$('#formUpload').ajaxForm({ 
			url:        url("/image/upload"), 
			type:      "post",
			dataType: "xml",
			success:    function(data) { 
				data = data.body.childNodes[0].data;	
				$("#fileuploaded").html('');
				if(data == "ERROR_FILESIZE") {
					$("#div_filedinhkem").show();
					message("File upload phải nhỏ hơn 2Mb!",0);
					return;
				}
				if(data == AJAX_ERROR_WRONGFORMAT) {
					$("#div_filedinhkem").show();
					message("Upload file sai định dạng!",0);
					return;
				}
				var jsonObj = eval( "(" + data + ")" );
				idchosen = "chosen_"+jsonObj.id;
				byId("msg").innerHTML="";
				byId("slideshow_image").value = jsonObj.id;
				$("#fileuploaded").html('<div style="display: block;" id="'+idchosen+'" ") class="chosen-container"><span class="chosen"><a href="'+jsonObj.url+'" target="_blank">'+byId("fileupload").value+'</a><img onclick="removechosen('+jsonObj.id+')" class="btn-remove-chosen" src="<?php echo BASE_PATH?>/public/img/icons/close_8x8.gif"/></span></div>');
				$("#tbl_Slideshow").show(); 
			},
			error : function(data) {
				$("#div_filedinhkem").show();
				alert(data);
			} 
		});
		loadListSlideshows();
	});
</script>