<!DOCTYPE html>
<html lang="en">
<head>
<title></title>
<meta charset="utf-8">
<link rel="stylesheet" href="<?php echo BASE_PATH ?>/public/css/reset.css" type="text/css" media="screen">
<link rel="stylesheet" href="<?php echo BASE_PATH ?>/public/css/style.css" type="text/css" media="screen">
<link rel="stylesheet" href="<?php echo BASE_PATH ?>/public/css/layout.css" type="text/css" media="screen">
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery-1.6.min.js"></script>
<script src="<?php echo BASE_PATH ?>/public/js/cufon-yui.js" type="text/javascript"></script>
<script src="<?php echo BASE_PATH ?>/public/js/cufon-replace.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/tms-0.3.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/tms_presets.js"></script> 
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery.easing.1.3.js"></script> 
<script src="<?php echo BASE_PATH ?>/public/js/FF-cash.js" type="text/javascript"></script>
<!--[if lt IE 7]>
	<div style=' clear: both; text-align:center; position: relative;'>
		<a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img src="http://www.theie6countdown.com/images/upgrade.jpg" border="0"  alt="" /></a>
	</div>
<![endif]-->
<!--[if lt IE 9]>
	<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/html5.js"></script>
	<style>
	#search-form {behavior:url("<?php echo BASE_PATH ?>/public/js/PIE.htc");position:relative}
	.search-form {behavior:url("<?php echo BASE_PATH ?>/public/js/PIE.htc");position:relative}
	#search-form a {behavior:url("<?php echo BASE_PATH ?>/public/js/PIE.htc");position:relative}
	.menu li a {behavior:url("<?php echo BASE_PATH ?>/public/js/PIE.htc");position:relative}
	.numb {behavior:url("<?php echo BASE_PATH ?>/public/js/PIE.htc");position:relative}
	.box {behavior:url("<?php echo BASE_PATH ?>/public/js/PIE.htc");position:relative}
	.button-2 {behavior:url("<?php echo BASE_PATH ?>/public/js/PIE.htc")}
	#page2 .button-2 {behavior:url("<?php echo BASE_PATH ?>/public/js/PIE.htc");position:relative}
	#content {behavior:url("<?php echo BASE_PATH ?>/public/js/PIE.htc");position:relative}
	.block-news {behavior:url("<?php echo BASE_PATH ?>/public/js/PIE.htc");position:relative}
	.slider-wrapper {behavior:url("<?php echo BASE_PATH ?>/public/js/PIE.htc")}
	</style>
<![endif]-->
</head>
<body>
<!-- header -->
	<div class="bg">
		<div class="main">
			<header>
				<div class="row-1">
					<h1>
						<a class="logo" href="index.html">Point.co</a>
						<strong class="slog">The most creative ideas</strong>
					</h1>
					<form id="search-form" action="" method="post" enctype="multipart/form-data">
						<fieldset>
							<div class="search-form">					
								<input type="text" name="search" value="Type Keyword Here" onBlur="if(this.value=='') this.value='Type Keyword Here'" onFocus="if(this.value =='Type Keyword Here' ) this.value=''" />
								<a href="#" onClick="document.getElementById('search-form').submit()">Search</a>									
							</div>
						</fieldset>
					</form>
				</div>
				<div class="row-2">
					<nav>
						<?php 
						include (ROOT . DS . 'public' . DS . 'components'.DS.'menu_component'.DS.'menu.php');
						?>
					</nav>
				</div>
			</header>
			<?php
			include (ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . $this->_action . '.php');
			?>
			<footer>
				<div class="row-top">
					<div class="row-padding">
						<div class="wrapper">
							<div class="col-1">
								<h4>Address:</h4>
								<dl class="address">
									<dt><span>Country:</span>USA</dt>
									<dd><span>City:</span>San Diego</dd>
									<dd><span>Address:</span>Beach st. 54</dd>
									<dd><span>Email:</span><a href="#">lcenter@mail.com</a></dd>
								</dl>
							</div>
							<div class="col-2">
								<h4>Follow Us:</h4>
								<ul class="list-services">
									<li class="item-1"><a href="#">Facebook</a></li>
									<li class="item-2"><a href="#">Twitter</a></li>
									<li class="item-3"><a href="#">LinkedIn</a></li>
								</ul>
							</div>
							<div class="col-3">
								<h4>Why Us:</h4>
								<ul class="list-1">
									<li><a href="#">Lorem ipsum dolor</a></li>
									<li><a href="#">Aonsect adipisic</a></li>
									<li><a href="#">Eiusmjkod tempor</a></li> 
									<li><a href="#">Incididunt ut labore</a></li>
								</ul>
							</div>
							<div class="col-4">
								<div class="indent3">
									<strong class="footer-logo">Point.<strong>co</strong></strong>
									<strong class="phone"><strong>Toll Free:</strong> 1-800-567-8934</strong>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row-bot">
					<div class="aligncenter">
						<p class="p0"><a href="http://www.templatemonster.com/" target="_blank">Website Template</a> by TemplateMonster.com</p>
						<a href="http://www.templates.com/product/3d-models/" target="_blank">3D Models</a> provided by Templates.com<br>
						<!-- {%FOOTER_LINK} -->
					</div>
				</div>
			</footer>
		</div>
	</div>
	<script type="text/javascript"> Cufon.now(); </script>
</body>
</html>
<script>
	var url_base = '<?php echo BASE_PATH ?>';
	function url(url) {
		return url_base+url;
	}
	//alert(url("js/PIE.htc"));
</script>