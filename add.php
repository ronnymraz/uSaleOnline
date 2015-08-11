<?php
/*
this is the form to add a book to your wishlist. 
*/
session_start();
	
if(!isset($_SESSION['email'])) {
die(header('Location: login.php'));
}else{
$sessionemail = ($_SESSION['email']);
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>U Sale | Add To Wish List</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<noscript>
<link rel="stylesheet" href="css/5grid/core.css" />
<link rel="stylesheet" href="css/5grid/core-desktop.css" />
<link rel="stylesheet" href="css/5grid/core-1200px.css" />
<link rel="stylesheet" href="css/5grid/core-noscript.css" />
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="css/style-desktop.css" />
</noscript>
<script src="css/5grid/jquery.js"></script>
<script src="css/5grid/init.js?use=mobile,desktop,1000px&amp;mobileUI=1&amp;mobileUI.theme=none&amp;mobileUI.openerWidth=52"></script>
<!--[if IE 9]><link rel="stylesheet" href="css/style-ie9.css" /><![endif]-->
</head><body class="onecolumn">
<div id="wrapper">
	<div id="header-wrapper">
		<header id="header">
			<div class="5grid-layout">
				<div class="row">
					<div class="12u" id="logo"> <!-- Logo -->
						<h1><a href="."><img src = "images/logo.png"></a></h1>
						<p><a href="logout">Log Out</a>
					</div>
				</div>
			</div>
			<div class="5grid-layout">
				<div class="row">
					<div class="12u" id="menu">
						<div id="menu-wrapper">
							<nav class="mobileUI-site-nav">
								<ul>
								 	
									<li><a href="search">Search</a></li>
									<li><a href="browse">Browse</a></li>
									<li><a href="sell">Sell</a></li>
									<li class="current_page_item"><a href="account">Account</a></li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</header>
	</div>
	<div id="page-wrapper" class="5grid-layout">
		<div class="row titlebg">
			<h2>Add to Wish List</h2>
		</div>
		<div class="row" id="content">
			<div class="12u">
				<section>
					<div class="post" align = "center">
						<h2>Add To Wish List</h2>
						<p>Please enter as much information as possible</p>
						<form method="POST" action="addtowishlist.php" >
<table class="signup" border="0" cellpadding="2" cellspacing = "0" >
<th colspan = "2" align = "center"></th>
<tr><td><br>Title   </td><td><br><input type = "text" maxlength = "32"
name = "Title" /></tr></td>
<tr><td><br>ISBN</td><td><br><input type = "text" maxlength = "13"
name = "ISBN" /></tr></td>


<tr><br><td colspan = "2" align = "center"><br><input type = "submit" value="Add" /></td></tr></table></form>
					</div>
				</section>
			</div>
		</div>
	</div>
</div>
<div id="copyright" class="5grid-layout">
	<section>
		<p>&copy; 2013 U Sale   |   <a href="about">About Us</a>   |   <a href="privacy">Privacy Policy</a>   |   <a href="terms">Terms of Use</a></p>
	</section>
</div>
</body>
</html>