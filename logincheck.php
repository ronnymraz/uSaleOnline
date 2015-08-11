<?php
session_start();
/*
Checks the users information against what is in the database via validation methods.
if it passes, a session begins for the user. if not the form is returned notifying
the user of the validation errors.
*/
require "accessdatabase.php";
$db_server = mysql_connect($db_hostname, $db_username, $db_password);
if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());

mysql_select_db($db_database)
or die("Unable to select database: " . mysql_error());
$email = $password = "";

if(isset($_POST['Email']))
	$email = mysql_real_escape_string($_POST ['Email']);
if(isset($_POST['Password']))
	$password = ($_POST['Password']);
	$passwordsecure = hash('sha256',$password);
	$passwordcheck = mysql_real_escape_string($passwordsecure);
	

$fail = validate_email($email);
$fail .= validate_password($passwordcheck);
if($fail == "")
{
	//if(isset($_POST['rememberme'])) session_set_cookie_params(3600*24*7);
	
	
	$_SESSION['email'] = $email;
	$_SESSION['password'] = $passwordcheck;
	$_SESSION['postlimit'] = 0;
	
	//setcookie('$email','$password', time() + 86,400);
	
	header('Location: browse');
}else{ session_destroy();}

function validate_email($field){
	if($field == "") return "Please enter a .edu email addresss. <br/>";
	if ((strpos($field, ".edu")>0) &&(filter_var($field, FILTER_VALIDATE_EMAIL)))
	{
		//checks ot make sure the email exists if it passes validation
		$queryemail = "SELECT * FROM user WHERE Email = '$field'";
		$emailresult = mysql_query($queryemail);
		$emailarray = mysql_fetch_array($emailresult);
			if($emailarray['Email'] =="") return"Email address Doesn't exist!<br />";
			else return "";
	}
}
function validate_password($field){
	if(isset($_POST['Email']))
	$email = ($_POST ['Email']);
	if($field == "") return "Please enter a password! <br />";
	else 
	$querypassword = "SELECT * FROM user WHERE Email = '$email' AND password = '$field'";
	$passwordresult = mysql_query($querypassword);
	$passwordarray = mysql_fetch_array($passwordresult);
	if($passwordarray['Password'] != $field) return "invalid password"; 
	else return "";
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>U Sale | Login</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<noscript>
<link rel="stylesheet" href="css/5grid/core.css" />
<link rel="stylesheet" href="css/5grid/core-desktop.css" />
<link rel="stylesheet" href="css/5grid/core-1200px.css" />
<link rel="stylesheet" href="css/5grid/core-noscript.css" />
<link rel="stylesheet" href="../css/style.css" />
<link rel="stylesheet" href="css/style-desktop.css" />
</noscript>
<script src="css/5grid/jquery.js"></script>
<script src="css/5grid/init.js?use=mobile,desktop,1000px&mobileUI=1&mobileUI.theme=none&mobileUI.openerWidth=52"></script>
<!--[if IE 9]><link rel="stylesheet" href="css/style-ie9.css" /><![endif]-->
</head><body class="onecolumn">
<div id="wrapper">
	<div id="header-wrapper">
		<header id="header">
			<div class="5grid-layout">
				<div class="row">
					<div class="12u" id="logo"> <!-- Logo -->
						<h1><a href="."><img src = "../images/logo.png"></a></h1>
						<p><a href="login">Login</a> / <a href="signup">Sign Up</a></p>
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
			<h2>Account</h2>
		</div>
		<div class="row" id="content">
			<div class="12u">
				<section>
					<div class="post" align = "center">
						<h2>Login</h2>
						
						<form method = "POST" action = "logincheck.php">
<table class = "login" border = 0 cellpadding = "2">
<?php echo $fail?>
<tr><td>Email Address</td><td><input type = "text" maxlength = "32" name = "Email"  /></td></tr>
<tr><td>Password</td><td><input type = "password" maxlength = "32" name = "Password" /><br><br></td></tr>
<tr><td><input type = "checkbox" name = "rememberme">Remember Me</table><br></td></tr>
<tr><td colspan = "1" align = "center"><input type = "submit" name = "login" value = "Login" action = "logincheck.php" /></td></form></tr>
<br><a href="forgotpassword" class='darker'>Forgot Password?</a></table>
</form>
					</div>
				</section>
			</div>
		</div>
	</div>
	<div id="footer-content-wrapper">
		<div class="5grid-layout">
			<div class="row" id="footer-content">
				<div class="6u" id="box1">
					<section>
						<h2 align = "left"><a href="signup">Need an account? Sign Up Here!</a></h2>
					</section>
				</div>
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