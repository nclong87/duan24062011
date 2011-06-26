<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	$msg = "";
	if(isset($_GET["reason"])) {
		$msg = $_GET["reason"];
		if($msg == "username")
			$msg = "Username này không tồn tại!";
		else if ($msg == "password")
			$msg = "Sai mật khẩu đăng nhập!";
		else if ($msg == "admin")
			$msg = "Vui lòng đăng nhập bằng tài khoản quản trị!";
	}
		
	$username = "";
	if(isset($_GET["username"]))
		$username = $_GET["username"];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>.: ĐĂNG NHẬP TRANG QUẢN TRỊ :.</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--[if IE]><link rel="stylesheet" href="../public/css/ie.css" type="text/css" media="screen, projection" /><![endif]-->
    <link rel="stylesheet" type="text/css" media="all" href="../public/css/style.css" />
	<link rel="Stylesheet" type="text/css" href="../public/css/smoothness/jquery-ui-1.7.1.custom.css"  />	
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
    <script type="text/javascript" src="../public/js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="../public/js/jquery-ui-1.7.1.custom.min.js"></script>
	<script type="text/javascript" src="../public/js/custom.js"></script>
	<!--[if IE]><script language="javascript" type="text/javascript" src="../public/js/excanvas.pack.js"></script><![endif]-->
</head>
<body>
<div  id="login_container">
    <div  id="header">
		<div id="logo"><h1><a href="/">AdmintTheme</a></h1></div>
    </div><!-- end header -->
	    <div id="login" class="section">
			<?php
			if(!empty($msg))
				echo "<div id='fail' class='info_div'><span class='ico_cancel'>$msg</span></div>";
			?>
	    	<form method="POST" action="<?php echo BASE_PATH ?>/account/doLogin">
			<label><strong>Username</strong></label><input type="text" name="username" id="username"  size="28" class="input" value="<?php echo $username ?>"/>
			<br />
			<label><strong>Password</strong></label><input type="password" name="password" id="password"  size="28" class="input"/>
			<br />
			<input id="save" class="loginbutton" type="submit" class="submit" style="cursor:pointer" value="Đăng Nhập" />
			</form>
			<a href="#" id="passwordrecoverylink">Forgot your username or password?</a>
	    </div>
</div><!-- end container -->
</body>
</html>
