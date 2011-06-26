<h1>QUẢN TRỊ WIDGET</h1>
<div style="padding-top:1px;font-size:14px" >
	<div style="text-align:left;padding:10px;width:90%;float:left;">
		<div id="top_icon" style="padding-top:0;">
		  <div align="center">
			<div><a href="#"><img src="<?php echo BASE_PATH ?>/public/img/icons/add_icon.png" alt="big_settings" width="25" height="26" border="0" /></a></div>
					<span class="toplinks">
			  <a href="#" onclick="showDialogWidget()"><span class="toplinks">THÊM WIDGET</span></a></span><br />
		  </div>
		</div>
		<div id="top_icon" style="padding-top:0;">
		  <div align="center">
			<div><a href="#"><img src="<?php echo BASE_PATH ?>/public/img/icons/layout_icon.png" alt="big_settings" width="25" height="26" border="0" /></a></div>
					<span class="toplinks">
			  <a href="#" onclick="viewLayout()"><span class="toplinks">XEM LAYOUT</span></a></span><br />
		  </div>
		</div>
	</div>
	<fieldset>
		<div id="datagrid">
			<table width="99%">
				<thead>
					<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
						<td width="10px">#</td>
						<td>Tên widget</td>
						<td>Vị trí</td>
						<td>Thứ tự</td>
						<td>Hiện title</td>
						<td>Component</td>
						<td>Active</td>
						<td>Sửa</td>
					</tr>
				</thead>
			</table>
		</div>
	</fieldset>
</div>
<script type="text/javascript">
	var objediting; //Object luu lai row dang chinh sua
	function message(msg,type) {
		if(type==1) { //Thong diep thong bao
			str = "<div class='positive'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
			byId("msg").innerHTML = str;
		} else if(type == 0) { //Thong diep bao loi
			str = "<div class='negative'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
			byId("msg").innerHTML = str;
		}
	}
	function showDialogWidget() {
		doReset();
		showDialog('#dialogWidget');
	}
	function fillFormValues(cells) { //Lấy giá trị từ row được chọn đưa lên form (click vào nút "Chọn")		
		byId("widget_id").value = $.trim($(cells.td_id).text());
		byId("widget_name").value = $.trim($(cells.td_name).text());
		byId("widget_position").value = $.trim($(cells.td_position).text());
		byId("widget_order").value = $.trim($(cells.td_order).text());
		var showtitle = $.trim($(cells.td_showtitle).text());
		if(showtitle == "Y") {
			byId("widget_showtitle").checked = true;
		} else {
			byId("widget_showtitle").checked = false;
		}
		var iscomponent = $.trim($(cells.td_iscomponent).text());
		if(iscomponent == "Y") {
			byId("widget_iscomponent").checked = true;
		} else {
			byId("widget_iscomponent").checked = false;
		}
	}
	function setRowValues(cells) { //Set giá trị từ form xuống row edit	
		$(cells.td_id).text(byId("widget_id").value);
		$(cells.td_name).text(byId("widget_name").value);
		$(cells.td_position).text(byId("widget_position").value);
		$(cells.td_order).text(byId("widget_order").value);	
		if(byId("widget_showtitle").checked == true) {
			$(cells.td_showtitle).text("Y");
		} else {
			$(cells.td_showtitle).text("N");
		}
		if(byId("widget_iscomponent").checked == true) {
			$(cells.td_iscomponent).text("Y");
		} else {
			$(cells.td_iscomponent).text("N");
		}
	}
	function select_row(_this) {
		//jsdebug(_this);
		doReset();	
		showDialog("#dialogWidget");
		var tr = _this.parentNode.parentNode;
		var cells = tr.cells;
		tr.style.backgroundColor = CONST_ROWSELECTED_COLOR;	
		objediting = tr;			
		fillFormValues(cells);
		block("#dialogWidget #dialog");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/widget/getContentById/"+ $.trim($(cells.td_id).text())),
			success: function(data){
				unblock("#dialogWidget #dialog");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				$('#widget_content').html(data);		
			},
			error: function(data){ unblock("#dialogWidget #dialog");alert (data);}	
		});
		return false;
	}
	function doReset() {
		$("#formWidget")[0].reset(); //Reset form cua jquery, giu lai gia tri mac dinh cua cac field	
		if(objediting)
			objediting.style.backgroundColor = '';
		byId("widget_id").value="";
		$('#widget_content').html("");
		$("#formWidget :input").css('border-color','');
		byId("msg").innerHTML="";
	}
	function loadListWidgets() {
		block("#datagrid");
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/widget/listWidgets/true"),
			success : function(data){	
				//alert(data);
				unblock("#datagrid");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
				} else {
					$("#datagrid").html(data);
					$("input:submit, input:button", "#datagrid").button();	
				}
				
			},
			error: function(data){ 
				unblock("#datagrid");
				alert (data);
			}			
		});
	}
	var isUpdate = false;
	function saveWidget() {
		isUpdate = false;
		if(byId("widget_id").value!="") {
			if(!confirm("Bạn muốn cập nhật Widget này?"))
				return;
			isUpdate = true;
		}		
		dataString = $("#formWidget").serialize();
		if(byId("widget_showtitle").checked == true) {
			dataString+="&widget_showtitle=1";
		} else {
			dataString+="&widget_showtitle=0";
		}
		if(byId("widget_iscomponent").checked == true) {
			dataString+="&widget_iscomponent=1";
		} else {
			dataString+="&widget_iscomponent=0";
		}
		//alert(dataString);return;
		block("#dialogWidget #dialog");
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/widget/saveWidget&"),
			data: dataString,
			success: function(data){
				unblock("#dialogWidget #dialog");				
				if(data == AJAX_DONE) {
					//Load luoi du lieu	
					message("Lưu Widget thành công!",1);					
					if(isUpdate == true) {
						var cells = objediting.cells;
						setRowValues(cells);
					} else {
						loadListWidgets();
					}														
				} else {
					message('Lưu Widget không thành công!',0);										
				}
			},
			error: function(data){ unblock("#dialogWidget #dialog");alert (data);}	
		});
	}
	function deleteWidget() {
		if(byId("widget_id").value=="") {
			alert("Vui lòng chọn widget cần xóa!");
			return;
		}
		if(!confirm("Bạn muốn xóa widget này?"))
			return;
		byId("msg").innerHTML="";
		block("#dialogWidget #dialog");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/widget/deleteWidget&id="+byId("widget_id").value),
			success: function(data){
				unblock("#dialogWidget #dialog");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_ERROR_SYSTEM) {
					//Load luoi du lieu		
					message('Thao tác bị lỗi!',0);	
				} else {
					closeDialog('#dialogWidget');
					loadListWidgets(1);
					message("Xóa widget thành công!",1);					
				}
			},
			error: function(data){ unblock("#dialogWidget #dialog");alert (data);}	
		});
	}
	function doActive(_this) {
		var cells = _this.parentNode.parentNode.cells;
		block("#content");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/widget/activeWidget/"+$(cells.td_id).text()),
			success: function(data){
				unblock("#content");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if (data == AJAX_DONE) {					
					message("Active Widget thành công!",1);
					$(cells.td_active).html("<div class='active' onclick='doUnActive(this)' title='Bỏ Active Widget này'></div>");
				} else {
					message("Active Widget không thành công!",0);
				}															
			},
			error: function(data){ alert (data);unblock("#content");}	
		});
	}
	function doUnActive(_this) {
		var cells = _this.parentNode.parentNode.cells;
		block("#content");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/widget/unActiveWidget/"+$(cells.td_id).text()),
			success: function(data){
				unblock("#content");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if (data == AJAX_DONE) {					
					message("Bỏ Active Widget thành công!",1);
					$(cells.td_active).html("<div class='inactive' onclick='doActive(this)' title='Active Widget này'></div>");
				} else {
					message("Bỏ Active Widget không thành công!",0);
				}															
			},
			error: function(data){ alert (data);unblock("#content");}	
		});
	}
	var isChangeLayout = false;
	function viewLayout() {
		isChangeLayout = false;
		$("#dialog_panel").html("");
		$("#dialog_panel").dialog({
			width: 630,
			height:530,
			title:"Quản Lý Layout",
			close: function() {
				if(isChangeLayout==true)
					loadListWidgets();
			},
			buttons: {
				Save: function() {
					dataString = "";
					var top = $("#layout_top").children();
					for(i=0;i<top.length;i++) {
						dataString += "&id[]="+top[i].id+"&position[]=top&order[]="+i;
					}
					var left = $("#layout_leftcol").children();
					for(i=0;i<left.length;i++) {
						dataString += "&id[]="+left[i].id+"&position[]=leftcol&order[]="+i;
					}
					var right = $("#layout_rightcol").children();
					for(i=0;i<right.length;i++) {
						dataString += "&id[]="+right[i].id+"&position[]=rightcol&order[]="+i;
					}
					var bottom = $("#layout_bottom").children();
					for(i=0;i<bottom.length;i++) {
						dataString += "&id[]="+bottom[i].id+"&position[]=footer&order[]="+i;
					}
					//jsdebug(top);
					//alert(dataString);
					block("#dialog_panel");
					$.ajax({
						type: "POST",
						cache: false,
						url : url("/widget/saveLayout"),
						data: dataString,
						success: function(data){
							unblock("#dialog_panel");
							if(data == AJAX_ERROR_NOTLOGIN) {
								location.href = url("/admin/login");
								return;
							}
							if (data == AJAX_DONE) {					
								layout_msg("Lưu Layout thành công!",1);
								isChangeLayout = true;
							} else {
								layout_msg("Lưu Layout không thành công!",0);
							}															
						},
						error: function(data){ alert (data);unblock("#dialog_panel");}	
					});
				},
				Close: function() {
					$(this).dialog('close');
				}
			}
		});
		$("#dialog_panel").dialog("open");
		block("#dialog_panel");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/widget/layout"),
			success: function(data){
				unblock("#dialog_panel");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				$("#dialog_panel").html(data);															
			},
			error: function(data){ alert (data);unblock("#dialog_panel");}	
		});
	}
	
	$(document).ready(function(){
		document.title = "Quản Trị Widget";
		loadListWidgets();
	});
</script>