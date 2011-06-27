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
<div style="padding-top:10px;font-size:14px" >
	<div style="color: blue; font-size: 20px; text-align: center; font-weight: bold;">Quản Trị Dự Án</div>
	<div class="clearfix" id="shortcuts">
		<ul>
			<li class="first_li" onclick="doDeleteAccounts()"><a href="#"><img alt="Thêm" src="<?php echo BASE_PATH ?>/public/images/icons/delete-icon.png"><span>Xóa</span></a></li>
		</ul>
		<ul>
			<li class="first_li" onclick="doShowDialogEdit()"><a href="#"><img alt="Thêm" src="<?php echo BASE_PATH ?>/public/images/icons/edit-icon.png"><span>Sửa</span></a></li>
		</ul>
	</div>
	<fieldset>
		<table>
		<tbody>
			<tr height="30px">
				<td width="50px">Email :</td>
				<td><input type="text" id="cond_email" style="width:200px" /> <input onclick="doFilter()" value="Tìm Kiếm" type="button" class="button"></td>
			</tr>
		</tbody>
		</table>
		<div id="datagrid">
			<table width="99%">
				<thead>
					<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
						<td width="20px">#</td>
						<td>Email</td>
						<td>Điện thoại</td>
						<td>Last Login</td>
						<td>Quyền</td>
						<td>Active</td>
						<td width="40px">Xử lý</td>
					</tr>
				</thead>
			</table>
		</div>
	</fieldset>
</div>
<script type="text/javascript">
	var objediting; //Object luu lai row dang chinh sua
	var searchString = "&";
	var nPage = 1;
	function message(msg,type) {
		if(type==1) { //Thong diep thong bao
			str = '<div id="success" class="info_div"><span class="ico_success">'+msg+'</span></div>';
			byId("msg").innerHTML = str;
		} else if(type == 0) { //Thong diep bao loi
			str = '<div id="fail" class="info_div"><span class="ico_cancel">'+msg+'</span></div>';
			byId("msg").innerHTML = str;
		}
	}
	function showDialogDuan() {
		doReset();
		showDialog('#dialogDuan',700);
	}
	function selectpage(page) {
		nPage = page;
		loadListAccounts(page+searchString);
	};
	function fillFormValues(cells) { //Lấy giá trị từ row được chọn đưa lên form (click vào nút "Chọn")		
		byId("account_id").value = $.trim($(cells.td_id).text());
		byId("account_username").value = $.trim($(cells.td_username).text());		
		byId("account_email").value = $.trim($(cells.td_email).text());		
		byId("account_sodienthoai").value = $.trim($(cells.td_sodienthoai).text());		
		byId("account_active").value = $.trim($(cells.td_active).text());
		switch($.trim($(cells.td_role).text())) {
			case "Admin":
				byId("account_role").value = 1;
				break;
			case "Nhân viên":
				byId("account_role").value = 2;
				break;
			default:
				byId("account_role").value = 3;
				break;
		}		
	}
	function setRowValues(cells) { //Set giá trị từ form xuống row edit	
		$(cells.td_id).text(byId("account_id").value);
		$(cells.td_username).text(byId("account_username").value);			
		$(cells.td_email).text(byId("account_email").value);			
		$(cells.td_sodienthoai).text(byId("account_sodienthoai").value);			
		$(cells.td_active).text(byId("account_active").value);		
		switch(byId("account_active").value) {
			case "0":
				$(cells.td_active_display).html("<div class='inactive' title='Chưa active'></div>");
				break;
			case "1":
				$(cells.td_active_display).html("<div class='active' title='Đã active'></div>");
				break;
			default:
				$(cells.td_active_display).html("<div class='locked' title='Đã khóa'></div>");
				break;
		}	
		switch(byId("account_role").value) {
			case "1":
				$(cells.td_role).text("Admin");
				break;
			case "2":
				$(cells.td_role).text("Nhân viên");
				break;
			default:
				$(cells.td_role).text("Người dùng");
				break;
		}		
	}
	function doShowDialogEdit() {
		//jsdebug(_this);
		if($("#datagrid :checkbox:checked").length < 1) {
			alert('Vui lòng chọn tài khoản cần sửa!');
			return;
		}
		if($("#datagrid :checkbox:checked").length > 1) {
			alert('Chỉ được chọn 1 dòng để sửa!');
			return;
		}
		doReset();	
		showDialog('#dialogDuan',700);
		var tr = $("#datagrid :checkbox:checked")[0].parentNode.parentNode;
		var cells = tr.cells;
		tr.style.backgroundColor = CONST_ROWSELECTED_COLOR;	
		objediting = tr;			
		fillFormValues(cells);
		return false;
	}
	function doDeleteAccounts() {
		if($("#datagrid :checkbox:checked").length < 1) {
			alert('Vui lòng chọn tài khoản cần xóa!');
			return;
		}
		if(!confirm("Bạn muốn xóa các tài khoản đã chọn?"))
			return;
		dataString = '';
		$("#datagrid :checkbox:checked").each(function(){
			dataString += '&account_id[]='+this.value;
		});
		byId("msg").innerHTML="";
		block("#datagrid");
		//alert(dataString);
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/account/deleteNAccounts"),
			data: dataString,
			success: function(data){
				unblock("#datagrid");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == "DONE") {
					//Load luoi du lieu	
					loadListAccounts(nPage+searchString);
					byId("account_id").value = "";
					message("Xóa tài khoản thành công!",1);	
				} else {
					message('Xóa tài khoản không thành công!',0);					
				}
			},
			error: function(data){ unblock("#datagrid");alert (data);}	
		});
	}
	function doCheck(_this) {
		var tr = _this.parentNode.parentNode;
		if(_this.checked == false) {
			tr.style.backgroundColor = '';	
		} else {
			tr.style.backgroundColor = CONST_ROWSELECTED_COLOR;	
		}
	}
	function doReset() {
		$("#formAccount")[0].reset(); //Reset form cua jquery, giu lai gia tri mac dinh cua cac field	
		if(objediting)
			objediting.style.backgroundColor = '';
		byId("account_id").value="";
		$("#formAccount :input").css('border-color','');
		byId("msg").innerHTML="";
	}
	function loadListAccounts(dataString) {
		block("#datagrid");
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/account/listAccounts/"+dataString),
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
	function saveAccount() {
		checkValidate=true;
		validate(['require'],'account_username',["Vui lòng nhập Username!"]);
		if(byId("account_id").value=="") {
			validate(['require',5],'account_password',["Vui lòng nhập Password!","Password phải lớn hơn 5 ký tự"]);
		} else {
			if(byId("account_password").value!="") {
				validate([5],'account_password',["Password phải lớn hơn 5 ký tự"]);
			}
		}
		validate(['require','email'],'account_email',["Vui lòng nhập Email!",'Email không hợp lệ!']);
		validate(['require'],'account_sodienthoai',["Vui lòng nhập số điện thoại!"]);
		if(checkValidate == false)
			return;
		isUpdate = false;
		if(byId("account_id").value!="") {
			if(!confirm("Bạn muốn cập nhật Tài Khoản này?"))
				return;
			isUpdate = true;
		}
		dataString = $("#formAccount").serialize();
		//alert(dataString);return;
		byId("msg").innerHTML="";
		block("#dialogDuan #dialog");
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/account/saveAccount&"),
			data: dataString,
			success: function(data){
				unblock("#dialogDuan #dialog");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_DONE) {
					//Load luoi du lieu		
					message("Lưu Tài Khoản thành công!",1);
					if(isUpdate == true) {
						var cells = objediting.cells;
						setRowValues(cells);
					} else {
						loadListAccounts('1'+searchString);
					}														
				} else if (data == AJAX_ERROR_EXIST) {
					message('Username này đã tồn tại!',0);	
					byId("account_username").focus();
				} else if (data == AJAX_ERROR_NOTEXIST) {
					message('Username này không tồn tại!',0);										
					byId("account_username").focus();
				} else {
					message('Lưu Tài Khoản không thành công!',0);										
				}
			},
			error: function(data){ unblock("#dialogDuan #dialog");alert (data);}	
		});
	}
	function deleteAccount() {
		account_id = byId("account_id").value;
		if(account_id=="")
			return;
		if(!confirm("Bạn muốn xóa tài khoản này?"))
			return;
		byId("msg").innerHTML="";
		block("#dialogDuan #dialog");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/account/delete&account_id="+account_id),
			success: function(data){
				unblock("#dialogDuan #dialog");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == "DONE") {
					//Load luoi du lieu	
					loadListAccounts(nPage+searchString);
					byId("account_id").value = "";
					message("Xóa tài khoản thành công!",1);	
				} else {
					message('Xóa tài khoản không thành công!',0);					
				}
			},
			error: function(data){ unblock("#dialogDuan #dialog");alert (data);}	
		});
	}
	function doFilter() {	
		searchString = "&cond_email="+byId("cond_email").value;
		loadListAccounts('1'+searchString);
	}
	$(document).ready(function(){				
		document.title = "Quản Trị Người Dùng";
		loadListAccounts('1'+searchString);
	});
</script>