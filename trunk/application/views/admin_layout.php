<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>.: TRANG QUẢN TRỊ :.</title>
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo BASE_PATH ?>/public/css/style.css" />
	<link rel="Stylesheet" type="text/css" href="<?php echo BASE_PATH ?>/public/css/blue/jquery-ui.css"  />	
	<!--[if IE 7]><link rel="stylesheet" href="<?php echo BASE_PATH ?>/public/css/ie.css" type="text/css" media="screen, projection" /><![endif]-->
	<!--[if IE 6]><link rel="stylesheet" href="<?php echo BASE_PATH ?>/public/css/ie6.css" type="text/css" media="screen, projection" /><![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH ?>/public/css/superfish.css" media="screen">
	<!--[if IE]>
		<style type="text/css">
		  .clearfix {
		    zoom: 1;     /* triggers hasLayout */
		    display: block;     /* resets display for IE/Win */
		    }  /* Only IE can see inside the conditional comment
		    and read this CSS rule. Don't ever use a normal HTML
		    comment inside the CC or it will close prematurely. */
		</style>
	<![endif]-->
	<!-- JavaScript -->
    <script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery-ui.js"></script>
	<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/hoverIntent.js"></script>
	<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/superfish.js"></script>
	<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery_blockUI.js"></script>	
	<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/utils.js"></script>	
	<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/constances.js"></script>	
	<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/validator.js"></script>	
	<script type="text/javascript">
		// initialise plugins
		jQuery(function(){
			jQuery('ul.sf-menu').superfish();
		});

	</script>
	<script type="text/javascript">
		function block(id) {
			$(id).block({ 
				message: '<span style="color:white">Đang tải dữ liệu...</span>', 
				css: { 
					border: 'none', 
					padding: '15px', 
					backgroundColor: '#000', 
					'-webkit-border-radius': '10px', 
					'-moz-border-radius': '10px', 
					opacity: .5, 
					color: '#fff' 
				} 
			}); 
		}
		function unblock(id) {
			$(id).unblock(); 
		}
		function byId(id) {
			return document.getElementById(id);
		}
		function jsdebug(data) {
			alert(data);
		}
	</script>
	 <!--[if IE]><script language="javascript" type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/excanvas.pack.js"></script><![endif]-->
</head>
<body>
<div class="container" id="container">
    <div  id="header">
    	<div id="profile_info">
			<img src="<?php echo BASE_PATH ?>/img/avatar.jpg" id="avatar" alt="avatar" />
			<p>Welcome <strong><?php echo $_SESSION['account']['username'] ?></strong>. <a href="<?php echo BASE_PATH.'/account/doLogout' ?>">Log out?</a></p>
			<p class="last_login">Last login: <?php echo $html->format_date($_SESSION['account']['lastlogin'],'d/m/Y H:i:s') ?></p>
		</div>
		<div id="logo"><h1><a href="<?php echo BASE_PATH.'/admin' ?>">AdmintTheme</a></h1></div>
		
    </div><!-- end header -->
	    <div id="content" >
	    <div id="top_menu" class="clearfix">
	    	<ul class="sf-menu"> <!-- DROPDOWN MENU -->
			<li>
				<a href="#">Quản Lý Dữ Liệu</a>
				<ul>
					<li>
						<a href="<?php echo BASE_PATH ?>/admin/viewAdminAccount">Người Dùng</a>
					</li>
					<li>
						<a href="#aa">Dự Án</a>
					</li>
					<li>
						<a href="#aa">Bất Động Sản</a>
					</li>
					<li>
						<a href="#aa">Tin Tức</a>
					</li>
					<li>
						<a href="#aa">Cổ Đông</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#">Công Cụ & Cấu Hình</a>
				<ul>
					<li>
						<a href="<?php echo BASE_PATH ?>/admin/viewAdminSlideshow">Slide Show</a>
					</li>
					<li>
						<a href="<?php echo BASE_PATH ?>/admin/viewAdminMenu">Quản Trị Menu</a>
					</li>
					<li>
						<a href="<?php echo BASE_PATH ?>/admin/">Cấu Hình</a>
					</li>
					<li>
						<a href="#aa">Công Cụ PR</a>
					</li>
					<li>
						<a href="#aa">Quản Lý Mailing List</a>
					</li>
					<li>
						<a href="#aa">Quản Lý Cache</a>
					</li>
				</ul>
			</li>
		</ul>
			<a href="#" id="visit" class="right">Visit site</a>
	    </div>
		<div id="content_main" class="clearfix">
			<?php
			include (ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . $this->_action . '.php');
			?>
		</div>
		<div  id="footer" class="clearfix">
    	<p class="left">Trang quản trị</p>
		<p class="right">Sàn giao dịch bất động sản Bến Thành Đức Khải - 2011© </p>
	</div><!-- end #footer -->
</div><!-- end container -->
<div id="dialog_panel"></div>	
</body>
</html>
<script type="text/javascript">
	var url_base = '<?php echo BASE_PATH ?>';
	function url(url) {
		return url_base+url;
	}
	function showImagesPanel() {
		$("#dialog_panel").html("");
		$("#dialog_panel").dialog({
			width: 835,
			height:566,
			title:"Thư Viện Hình Ảnh",
			close: function() {
				onCloseImageGallery();
			},
			buttons: {}
		});
		$("#dialog_panel").dialog("open");
		block("#dialog_panel");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/image"),
			success: function(data){
				unblock("#dialog_panel");
				$("#dialog_panel").html(data);
				//$("input:submit, input:button", "#dialog_panel").button();					
			},
			error: function(data){ alert (data);unblock("#dialog_panel");}	
		});
	}
	function showDialog(id,width,title) {
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
		var winH = $(window).height();
		var winW = $(window).width();
		if(width == null) {
			width = 500;
		}
		$(id + ' #dialog').css('width',  width);
		if(title != null) {
			$(id + ' #title_dialog').html(title);
		}
		$(id + ' #dialog').css('top',  10);
		$(id + ' #dialog').css('left', (winW-$(id + ' #dialog').width())/2);
		//Set heigth and width to mask to fill up the whole screen
		$(id+' #mask').css({'width':maskWidth,'height':maskHeight,'opacity':0.5});
		$(id+' #mask').show();
		
		$(id + ' #dialog').fadeIn('fast'); 
	}
	function closeDialog(id) {
		if(id != null) {
			$(id+' #mask').hide();
			$(id + ' .window').hide();
		} else {
			$('#mask').hide();
			$('.window').hide();
		}
		
	}	
	function boundTip(id,content,width,action) {
		if(width==null)
			width = 250;
		if(action==null) {
			$("#"+id).focus(function () {
				xTip = $(this).offset().left+$(this).width();
				yTip = $(this).offset().top;
				showtip(content,width);
			});
			$("#"+id).blur(function () {
				hidetip();
			});
		}
		if(action=="hover") {
			$("#"+id).hover(
				function () {
					xTip = $(this).offset().left+$(this).width();
					yTip = $(this).offset().top;
					showtip(content,width);
				}, 
				function () {
					hidetip();
				}
			);
		}
	}
	$(document).ready(function(){
		$("#dialog_panel").dialog({
			autoOpen: false,
			minWidth: 200,
			modal: true,
			resizable :true
		});	
	});
</script>